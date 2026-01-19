<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateAiCardJob;
use App\Models\AiCardGeneration;
use App\Services\AiImage\ImageGenerator;
use App\Services\AiImage\PromptBuilder;
use App\Services\AiImage\PromptRandomizer;
use App\Services\AiImage\NegativePrompt;
use App\Services\AiImage\CardDNA;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * AiCardApiController - REST API for AI card generation
 * 
 * Provides endpoints for generating, checking status, and managing
 * AI-generated greeting cards. Designed for production use.
 */
class AiCardApiController extends Controller
{
    /**
     * Generate a new AI card
     * 
     * POST /api/v1/cards/generate
     */
    public function generate(Request $request): JsonResponse
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'occasion'    => 'required|string|max:50',
            'mood'        => 'required|string|max:50',
            'style'       => 'nullable|string|max:50',
            'art_style'   => 'required|string|max:50',
            'elements'    => 'required|string|max:200',
            'colors'      => 'nullable|string|max:50',
            'orientation' => 'nullable|string|in:portrait,landscape,square',
            'background'  => 'nullable|string|max:100',
            'lighting'    => 'nullable|string|max:50',
            'sync'        => 'nullable|boolean', // If true, generate synchronously
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $params = $validator->validated();
        $params['orientation'] = $params['orientation'] ?? 'portrait';
        $params['colors'] = $params['colors'] ?? 'vibrant';
        $params['lighting'] = $params['lighting'] ?? 'soft';

        // Generate card identity
        $identity = CardDNA::createIdentity($params);

        // Create generation record
        $generation = AiCardGeneration::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'card_dna' => $identity['dna'],
            'params' => json_encode($params),
            'occasion' => $params['occasion'],
            'mood' => $params['mood'],
            'art_style' => $params['art_style'],
            'orientation' => $params['orientation'],
        ]);

        // Check if sync generation requested (for testing/small scale)
        if ($request->boolean('sync')) {
            return $this->generateSync($generation, $params);
        }

        // Dispatch to queue for async processing
        GenerateAiCardJob::dispatch($generation->id, $params);

        return response()->json([
            'success' => true,
            'message' => 'Generation started',
            'data' => [
                'generation_id' => $generation->id,
                'status' => 'pending',
                'identity' => [
                    'dna' => $identity['dna'],
                    'short_code' => $identity['short_code'],
                ],
                'check_status_url' => route('api.v1.cards.status', $generation->id),
            ],
        ], 202);
    }

    /**
     * Generate synchronously (for testing or small scale)
     */
    private function generateSync(AiCardGeneration $generation, array $params): JsonResponse
    {
        try {
            $generator = new ImageGenerator();
            $result = $generator->generate($params);

            if ($result['success']) {
                $generation->update([
                    'status' => 'completed',
                    'image_url' => $result['image_url'],
                    'image_path' => $result['image_path'],
                    'prompt_used' => $result['prompt'],
                    'negative_prompt_used' => $result['negative_prompt'],
                    'seed' => $result['seed'],
                    'completed_at' => now(),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Card generated successfully',
                    'data' => [
                        'generation_id' => $generation->id,
                        'status' => 'completed',
                        'image_url' => $result['image_url'],
                        'identity' => $result['identity'],
                    ],
                ]);
            }

            throw new \Exception($result['error'] ?? 'Generation failed');
        } catch (\Exception $e) {
            $generation->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Generation failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check generation status
     * 
     * GET /api/v1/cards/status/{id}
     */
    public function status(int $id): JsonResponse
    {
        $generation = AiCardGeneration::find($id);

        if (!$generation) {
            return response()->json([
                'success' => false,
                'message' => 'Generation not found',
            ], 404);
        }

        $data = [
            'generation_id' => $generation->id,
            'status' => $generation->status,
            'created_at' => $generation->created_at->toIso8601String(),
        ];

        if ($generation->status === 'completed') {
            $data['image_url'] = $generation->image_url;
            $data['completed_at'] = $generation->completed_at?->toIso8601String();
        }

        if ($generation->status === 'failed') {
            $data['error'] = $generation->error_message;
            $data['failed_at'] = $generation->failed_at?->toIso8601String();
        }

        if ($generation->status === 'processing') {
            $data['started_at'] = $generation->started_at?->toIso8601String();
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Preview prompt without generating
     * 
     * POST /api/v1/cards/preview-prompt
     */
    public function previewPrompt(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'occasion'    => 'required|string|max:50',
            'mood'        => 'required|string|max:50',
            'art_style'   => 'required|string|max:50',
            'elements'    => 'required|string|max:200',
            'colors'      => 'nullable|string|max:50',
            'orientation' => 'nullable|string|in:portrait,landscape,square',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $params = $validator->validated();
        
        $generator = new ImageGenerator();
        $preview = $generator->previewPrompt($params);

        return response()->json([
            'success' => true,
            'data' => [
                'prompt' => $preview['prompt'],
                'negative_prompt' => $preview['negative_prompt'],
                'identity' => $preview['identity'],
            ],
        ]);
    }

    /**
     * Get user's generation history
     * 
     * GET /api/v1/cards/history
     */
    public function history(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 20), 100);
        
        $generations = AiCardGeneration::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $generations->items(),
            'meta' => [
                'current_page' => $generations->currentPage(),
                'last_page' => $generations->lastPage(),
                'per_page' => $generations->perPage(),
                'total' => $generations->total(),
            ],
        ]);
    }

    /**
     * Get available options for card generation
     * 
     * GET /api/v1/cards/options
     */
    public function options(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'occasions' => [
                    'birthday', 'wedding', 'anniversary', 'graduation',
                    'baby_shower', 'thank_you', 'get_well', 'sympathy',
                    'congratulations', 'holiday', 'christmas', 'valentines',
                    'mothers_day', 'fathers_day', 'easter', 'new_year',
                    'friendship', 'love',
                ],
                'moods' => [
                    'joyful', 'romantic', 'elegant', 'playful',
                    'serene', 'warm', 'nostalgic', 'modern',
                    'whimsical', 'sophisticated',
                ],
                'art_styles' => [
                    'watercolor', 'digital_art', 'oil_painting', 'minimalist',
                    'realistic', 'abstract', 'vintage', 'flat_design',
                    '3d_render', 'pencil_sketch', 'pastel', 'pop_art',
                ],
                'colors' => [
                    'warm', 'cool', 'pastel', 'vibrant',
                    'monochrome', 'earth', 'sunset', 'ocean',
                    'forest', 'romantic', 'luxury', 'spring',
                    'autumn', 'winter',
                ],
                'orientations' => [
                    'portrait', 'landscape', 'square',
                ],
                'lighting' => [
                    'soft', 'dramatic', 'warm', 'cool',
                    'natural', 'studio', 'sunset', 'moonlight', 'backlit',
                ],
            ],
        ]);
    }

    /**
     * Check API health
     * 
     * GET /api/v1/cards/health
     */
    public function health(): JsonResponse
    {
        $generator = new ImageGenerator();
        $isAvailable = $generator->isAvailable();

        return response()->json([
            'success' => true,
            'data' => [
                'api_status' => 'ok',
                'ai_service_status' => $isAvailable ? 'available' : 'unavailable',
                'queue_connection' => config('queue.default'),
                'timestamp' => now()->toIso8601String(),
            ],
        ], $isAvailable ? 200 : 503);
    }
}
