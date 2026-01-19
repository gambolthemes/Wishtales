<?php

namespace App\Services\AiImage;

/**
 * PromptRandomizer - Adds random variation elements to ensure unique generations
 * 
 * This class injects controlled randomness into prompts to guarantee
 * that each generated image is unique while maintaining quality.
 */
class PromptRandomizer
{
    /**
     * Generate random variation elements
     */
    public static function random(): string
    {
        $variations = [];

        // Camera/Perspective variations
        $variations[] = self::getRandomElement(self::getCameraOptions());

        // Visual depth variations
        $variations[] = self::getRandomElement(self::getDepthOptions());

        // Texture variations
        $variations[] = self::getRandomElement(self::getTextureOptions());

        // Accent/Detail variations
        $variations[] = self::getRandomElement(self::getAccentOptions());

        // Composition variations
        $variations[] = self::getRandomElement(self::getCompositionOptions());

        return ', ' . implode(', ', $variations);
    }

    /**
     * Generate a unique seed string for tracking
     */
    public static function generateSeed(): string
    {
        return bin2hex(random_bytes(8));
    }

    /**
     * Get a random element from array
     */
    private static function getRandomElement(array $options): string
    {
        return $options[array_rand($options)];
    }

    /**
     * Camera and perspective options
     */
    private static function getCameraOptions(): array
    {
        return [
            'top-down view',
            'front facing view',
            'slight angle perspective',
            'centered composition',
            'eye-level view',
            'artistic angle',
            'dynamic perspective',
            'straight-on view',
            'gentle tilt angle',
            'flat lay style',
        ];
    }

    /**
     * Visual depth options
     */
    private static function getDepthOptions(): array
    {
        return [
            'soft blurred background',
            'layered depth design',
            'smooth gradient depth',
            'bokeh background effect',
            'shallow depth of field',
            'dreamy soft focus background',
            'multi-layer composition',
            'foreground focus clarity',
            'atmospheric depth',
            'clean minimal depth',
        ];
    }

    /**
     * Texture options
     */
    private static function getTextureOptions(): array
    {
        return [
            'watercolor texture finish',
            'soft paper texture',
            'smooth matte finish',
            'subtle grain texture',
            'silk smooth surface',
            'gentle canvas texture',
            'clean digital finish',
            'soft velvet feel',
            'light linen texture',
            'polished glossy finish',
        ];
    }

    /**
     * Accent and detail options
     */
    private static function getAccentOptions(): array
    {
        return [
            'subtle gold foil accents',
            'soft pastel glow',
            'gentle sparkle effects',
            'delicate shimmer highlights',
            'elegant metallic touches',
            'soft light rays',
            'magical dust particles',
            'gentle lens flare',
            'subtle rainbow prismatic',
            'warm ambient glow',
        ];
    }

    /**
     * Composition variations
     */
    private static function getCompositionOptions(): array
    {
        return [
            'rule of thirds composition',
            'centered symmetrical layout',
            'golden ratio placement',
            'balanced asymmetry',
            'flowing organic arrangement',
            'geometric structured layout',
            'radial composition',
            'diagonal dynamic flow',
            'frame within frame',
            'negative space emphasis',
        ];
    }

    /**
     * Get full randomization data for tracking/logging
     */
    public static function getRandomizationData(): array
    {
        return [
            'camera'      => self::getRandomElement(self::getCameraOptions()),
            'depth'       => self::getRandomElement(self::getDepthOptions()),
            'texture'     => self::getRandomElement(self::getTextureOptions()),
            'accent'      => self::getRandomElement(self::getAccentOptions()),
            'composition' => self::getRandomElement(self::getCompositionOptions()),
            'seed'        => self::generateSeed(),
            'timestamp'   => now()->timestamp,
        ];
    }

    /**
     * Build random prompt with tracking data
     */
    public static function randomWithTracking(): array
    {
        $data = self::getRandomizationData();
        
        $prompt = ', ' . implode(', ', [
            $data['camera'],
            $data['depth'],
            $data['texture'],
            $data['accent'],
            $data['composition'],
        ]);

        return [
            'prompt' => $prompt,
            'tracking' => $data,
        ];
    }
}
