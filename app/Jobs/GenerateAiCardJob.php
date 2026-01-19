<?php

namespace App\Jobs;

use App\Models\AiCardGeneration;
use App\Services\AiImage\ImageGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * GenerateAiCardJob - Queue job for AI image generation
 * 
 * Handles heavy image generation asynchronously to prevent
 * blocking the web request. Supports retries and error handling.
 */
class GenerateAiCardJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     */
    public int $timeout = 180;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 30;

    /**
     * Card generation record ID
     */
    private int $generationId;

    /**
     * Generation parameters
     */
    private array $params;

    /**
     * Create a new job instance.
     */
    public function __construct(int $generationId, array $params)
    {
        $this->generationId = $generationId;
        $this->params = $params;
        
        // Use a dedicated queue for GPU-intensive tasks
        $this->onQueue('ai-generation');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Starting AI card generation", ['generation_id' => $this->generationId]);

        // Get the generation record
        $generation = AiCardGeneration::find($this->generationId);

        if (!$generation) {
            Log::error("Generation record not found", ['id' => $this->generationId]);
            return;
        }

        // Update status to processing
        $generation->update([
            'status' => 'processing',
            'started_at' => now(),
        ]);

        try {
            // Initialize the generator
            $generator = new ImageGenerator();

            // Generate the image
            $result = $generator->generate($this->params);

            if ($result['success']) {
                // Success - update the record
                $generation->update([
                    'status' => 'completed',
                    'image_url' => $result['image_url'],
                    'image_path' => $result['image_path'],
                    'prompt_used' => $result['prompt'],
                    'negative_prompt_used' => $result['negative_prompt'],
                    'card_dna' => $result['identity']['dna'],
                    'seed' => $result['seed'],
                    'metadata' => json_encode([
                        'identity' => $result['identity'],
                        'randomization' => $result['randomization'],
                    ]),
                    'completed_at' => now(),
                ]);

                Log::info("AI card generation completed", [
                    'generation_id' => $this->generationId,
                    'image_url' => $result['image_url'],
                ]);
            } else {
                throw new \Exception($result['error'] ?? 'Generation failed');
            }
        } catch (\Exception $e) {
            Log::error("AI card generation failed", [
                'generation_id' => $this->generationId,
                'error' => $e->getMessage(),
            ]);

            $generation->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'failed_at' => now(),
            ]);

            // Re-throw to trigger retry logic
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("AI card generation job failed permanently", [
            'generation_id' => $this->generationId,
            'error' => $exception->getMessage(),
        ]);

        $generation = AiCardGeneration::find($this->generationId);
        
        if ($generation) {
            $generation->update([
                'status' => 'failed',
                'error_message' => 'Max retries exceeded: ' . $exception->getMessage(),
                'failed_at' => now(),
            ]);
        }
    }

    /**
     * Get the tags that should be assigned to the job.
     */
    public function tags(): array
    {
        return [
            'ai-generation',
            'generation:' . $this->generationId,
        ];
    }
}
