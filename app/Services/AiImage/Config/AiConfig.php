<?php

namespace App\Services\AiImage\Config;

/**
 * AI Image Generation Configuration
 * 
 * This class centralizes all AI generation settings for easy maintenance
 * and production-ready configuration management.
 */
class AiConfig
{
    /**
     * Get Stable Diffusion API endpoint
     */
    public static function getApiEndpoint(): string
    {
        return config('stable_diffusion.endpoint', 'http://localhost:7860');
    }

    /**
     * Get API key for authentication
     */
    public static function getApiKey(): ?string
    {
        return config('stable_diffusion.api_key');
    }

    /**
     * Get available image dimensions based on orientation
     */
    public static function getDimensions(string $orientation): array
    {
        return match ($orientation) {
            'portrait'  => ['width' => 768, 'height' => 1024],
            'landscape' => ['width' => 1024, 'height' => 768],
            'square'    => ['width' => 1024, 'height' => 1024],
            default     => ['width' => 768, 'height' => 1024], // Default to portrait for cards
        };
    }

    /**
     * Get generation parameters
     */
    public static function getGenerationParams(): array
    {
        return [
            'steps'          => (int) config('stable_diffusion.steps', 30),
            'cfg_scale'      => (float) config('stable_diffusion.cfg_scale', 7.5),
            'sampler'        => config('stable_diffusion.sampler', 'DPM++ 2M Karras'),
            'seed'           => -1, // -1 for random
            'batch_size'     => 1,
            'n_iter'         => 1,
        ];
    }

    /**
     * Get the model checkpoint to use
     */
    public static function getModel(): string
    {
        return config('stable_diffusion.model', 'sdxl_base_1.0');
    }

    /**
     * Get timeout for API requests (seconds)
     */
    public static function getTimeout(): int
    {
        return (int) config('stable_diffusion.timeout', 120);
    }

    /**
     * Get maximum retry attempts
     */
    public static function getMaxRetries(): int
    {
        return (int) config('stable_diffusion.max_retries', 3);
    }

    /**
     * Get storage disk for generated images
     */
    public static function getStorageDisk(): string
    {
        return config('stable_diffusion.storage_disk', 'public');
    }

    /**
     * Get storage path prefix
     */
    public static function getStoragePath(): string
    {
        return config('stable_diffusion.storage_path', 'ai-cards');
    }
}
