<?php

namespace App\Services\AiImage;

/**
 * NegativePrompt - Defines what to EXCLUDE from generated images
 * 
 * Critical for ensuring commercial safety, quality, and compliance.
 * These prompts tell Stable Diffusion what NOT to generate.
 */
class NegativePrompt
{
    /**
     * Get the complete negative prompt for greeting card generation
     */
    public static function text(): string
    {
        return implode(', ', array_merge(
            self::getTextElements(),
            self::getBrandElements(),
            self::getPeopleElements(),
            self::getQualityIssues(),
            self::getCopyrightElements(),
            self::getUnwantedContent()
        ));
    }

    /**
     * Text and typography exclusions - CRITICAL for cards
     */
    private static function getTextElements(): array
    {
        return [
            'text',
            'words',
            'letters',
            'numbers',
            'typography',
            'writing',
            'handwriting',
            'calligraphy',
            'font',
            'label',
            'caption',
            'title',
            'subtitle',
            'headline',
            'inscription',
            'signature text',
        ];
    }

    /**
     * Brand and logo exclusions - Commercial safety
     */
    private static function getBrandElements(): array
    {
        return [
            'watermark',
            'logo',
            'brand',
            'trademark',
            'company name',
            'website',
            'url',
            'copyright symbol',
            'registered trademark',
            'brand mark',
            'stamp',
            'seal',
        ];
    }

    /**
     * People and face exclusions - Avoid likeness issues
     */
    private static function getPeopleElements(): array
    {
        return [
            'person',
            'people',
            'human',
            'face',
            'portrait',
            'hands',
            'fingers',
            'body parts',
            'celebrity',
            'real person',
            'photograph of person',
        ];
    }

    /**
     * Quality issue exclusions
     */
    private static function getQualityIssues(): array
    {
        return [
            'blurry',
            'blur',
            'out of focus',
            'noise',
            'grain',
            'pixelated',
            'low quality',
            'low resolution',
            'jpeg artifacts',
            'compression artifacts',
            'distorted',
            'deformed',
            'ugly',
            'bad anatomy',
            'bad proportions',
            'amateur',
            'poorly drawn',
            'bad art',
            'cropped',
            'worst quality',
        ];
    }

    /**
     * Copyright and character exclusions
     */
    private static function getCopyrightElements(): array
    {
        return [
            'copyrighted character',
            'disney',
            'marvel',
            'cartoon character',
            'movie character',
            'tv character',
            'anime character',
            'game character',
            'mascot',
            'famous character',
            'licensed character',
        ];
    }

    /**
     * Other unwanted content exclusions
     */
    private static function getUnwantedContent(): array
    {
        return [
            'nsfw',
            'adult content',
            'violence',
            'blood',
            'scary',
            'horror',
            'disturbing',
            'offensive',
            'political',
            'religious symbols',
            'controversial',
            'weapon',
        ];
    }

    /**
     * Get a minimal negative prompt for faster generation
     */
    public static function minimal(): string
    {
        return implode(', ', [
            'text', 'words', 'letters', 'watermark', 'logo',
            'person', 'face', 'blurry', 'low quality', 'ugly',
        ]);
    }

    /**
     * Get negative prompt for specific style
     */
    public static function forStyle(string $style): string
    {
        $baseNegative = self::text();

        $styleNegatives = match ($style) {
            'realistic' => ', cartoon, anime, illustration, drawing, painting, sketch',
            'watercolor' => ', photo, realistic, 3d render, digital art, sharp edges',
            'digital_art' => ', photo, painting, sketch, traditional media, hand drawn',
            'minimalist' => ', complex, busy, cluttered, detailed, ornate, decorative',
            '3d_render' => ', flat, 2d, drawing, painting, sketch, illustration',
            default => '',
        };

        return $baseNegative . $styleNegatives;
    }
}
