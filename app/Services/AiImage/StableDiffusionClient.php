<?php

namespace App\Services\AiImage;

use App\Services\AiImage\Config\AiConfig;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * StableDiffusionClient - HTTP client for Stable Diffusion / SDXL API
 * 
 * Handles all communication with the AI image generation endpoint.
 * Supports both local (Automatic1111) and cloud-hosted SD APIs.
 */
class StableDiffusionClient
{
    private string $endpoint;
    private ?string $apiKey;
    private int $timeout;
    private int $maxRetries;

    public function __construct()
    {
        $this->endpoint = AiConfig::getApiEndpoint();
        $this->apiKey = AiConfig::getApiKey();
        $this->timeout = AiConfig::getTimeout();
        $this->maxRetries = AiConfig::getMaxRetries();
    }

    /**
     * Generate an image using txt2img endpoint
     */
    public function generateImage(array $params): array
    {
        $attempt = 0;
        $lastError = null;

        while ($attempt < $this->maxRetries) {
            try {
                $response = $this->makeRequest('/sdapi/v1/txt2img', $params);
                
                if (isset($response['images']) && !empty($response['images'])) {
                    return [
                        'success' => true,
                        'images' => $response['images'],
                        'parameters' => $response['parameters'] ?? [],
                        'info' => json_decode($response['info'] ?? '{}', true),
                    ];
                }

                throw new \Exception('No images returned from API');
            } catch (\Exception $e) {
                $lastError = $e;
                $attempt++;
                Log::warning("SD API attempt {$attempt} failed: " . $e->getMessage());
                
                if ($attempt < $this->maxRetries) {
                    sleep(2 * $attempt); // Exponential backoff
                }
            }
        }

        Log::error('SD API failed after all retries', ['error' => $lastError->getMessage()]);
        
        return [
            'success' => false,
            'error' => $lastError->getMessage(),
        ];
    }

    /**
     * Make HTTP request to SD API
     */
    private function makeRequest(string $path, array $payload): array
    {
        $url = rtrim($this->endpoint, '/') . $path;

        $request = Http::timeout($this->timeout)
            ->withHeaders($this->getHeaders());

        $response = $request->post($url, $payload);

        if (!$response->successful()) {
            throw new \Exception("API error: HTTP {$response->status()} - " . $response->body());
        }

        return $response->json();
    }

    /**
     * Get request headers
     */
    private function getHeaders(): array
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        if ($this->apiKey) {
            $headers['Authorization'] = "Bearer {$this->apiKey}";
        }

        return $headers;
    }

    /**
     * Build the complete payload for image generation
     */
    public static function buildPayload(
        string $prompt,
        string $negativePrompt,
        string $orientation = 'portrait',
        ?int $seed = null
    ): array {
        $dimensions = AiConfig::getDimensions($orientation);
        $params = AiConfig::getGenerationParams();

        return [
            'prompt' => $prompt,
            'negative_prompt' => $negativePrompt,
            'width' => $dimensions['width'],
            'height' => $dimensions['height'],
            'steps' => $params['steps'],
            'cfg_scale' => $params['cfg_scale'],
            'sampler_name' => $params['sampler'],
            'seed' => $seed ?? -1,
            'batch_size' => $params['batch_size'],
            'n_iter' => $params['n_iter'],
            'restore_faces' => false,
            'tiling' => false,
        ];
    }

    /**
     * Save base64 image to storage
     */
    public static function saveImage(string $base64Image, ?string $filename = null): string
    {
        $disk = AiConfig::getStorageDisk();
        $path = AiConfig::getStoragePath();
        
        // Generate unique filename
        $filename = $filename ?? Str::uuid() . '.png';
        $fullPath = "{$path}/{$filename}";

        // Decode and save
        $imageData = base64_decode($base64Image);
        Storage::disk($disk)->put($fullPath, $imageData);

        return $fullPath;
    }

    /**
     * Get public URL for saved image
     */
    public static function getImageUrl(string $path): string
    {
        $disk = AiConfig::getStorageDisk();
        return Storage::disk($disk)->url($path);
    }

    /**
     * Check if the SD API is available
     */
    public function healthCheck(): bool
    {
        try {
            $url = rtrim($this->endpoint, '/') . '/sdapi/v1/options';
            $response = Http::timeout(10)
                ->withHeaders($this->getHeaders())
                ->get($url);
            
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('SD API health check failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get available models from SD API
     */
    public function getModels(): array
    {
        try {
            $url = rtrim($this->endpoint, '/') . '/sdapi/v1/sd-models';
            $response = Http::timeout(30)
                ->withHeaders($this->getHeaders())
                ->get($url);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return [];
        } catch (\Exception $e) {
            Log::error('Failed to get SD models: ' . $e->getMessage());
            return [];
        }
    }
}
