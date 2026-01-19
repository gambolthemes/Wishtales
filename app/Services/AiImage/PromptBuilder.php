<?php

namespace App\Services\AiImage;

/**
 * PromptBuilder - Constructs structured AI prompts for greeting card generation
 * 
 * This class builds commercial-safe, high-quality prompts optimized for
 * Stable Diffusion / SDXL models to generate unique greeting card images.
 */
class PromptBuilder
{
    /**
     * Base prompt rules that ALWAYS apply to ensure quality and safety
     */
    private static function getBasePrompt(): string
    {
        return implode(', ', [
            'masterpiece',
            'best quality',
            'ultra detailed',
            'professional greeting card design',
            'clean composition',
            'modern aesthetic',
            'high resolution',
            'sharp focus',
            'commercially safe',
            'original artwork',
            'no text',
            'no words',
            'no letters',
            'no watermark',
            'no signature',
            'no logo',
        ]);
    }

    /**
     * Build complete prompt from user parameters
     */
    public static function build(array $data): string
    {
        $parts = [];

        // 1. Base quality prompt
        $parts[] = self::getBasePrompt();

        // 2. Occasion-specific elements
        if (!empty($data['occasion'])) {
            $parts[] = self::getOccasionPrompt($data['occasion']);
        }

        // 3. Mood and atmosphere
        if (!empty($data['mood'])) {
            $parts[] = self::getMoodPrompt($data['mood']);
        }

        // 4. Art style
        if (!empty($data['art_style'])) {
            $parts[] = self::getArtStylePrompt($data['art_style']);
        }

        // 5. Design style
        if (!empty($data['style'])) {
            $parts[] = "design style: {$data['style']}";
        }

        // 6. Theme elements
        if (!empty($data['elements'])) {
            $parts[] = "featuring: {$data['elements']}";
        }

        // 7. Color palette
        if (!empty($data['colors'])) {
            $parts[] = self::getColorPrompt($data['colors']);
        }

        // 8. Background style
        if (!empty($data['background'])) {
            $parts[] = "background: {$data['background']}";
        }

        // 9. Lighting
        if (!empty($data['lighting'])) {
            $parts[] = self::getLightingPrompt($data['lighting']);
        }

        // 10. Orientation-specific composition
        if (!empty($data['orientation'])) {
            $parts[] = self::getOrientationPrompt($data['orientation']);
        }

        return implode(', ', array_filter($parts));
    }

    /**
     * Get occasion-specific prompt elements
     */
    private static function getOccasionPrompt(string $occasion): string
    {
        $occasions = [
            'birthday' => 'birthday celebration theme, festive decorations, balloons, confetti, party elements, joyful atmosphere',
            'wedding' => 'elegant wedding theme, romantic florals, soft pastels, love symbols, celebration of union',
            'anniversary' => 'romantic anniversary theme, elegant design, timeless love symbols, sophisticated style',
            'graduation' => 'graduation celebration, achievement theme, academic success, bright future symbolism',
            'baby_shower' => 'baby shower theme, soft nursery colors, gentle baby elements, warm welcoming feel',
            'thank_you' => 'gratitude theme, appreciation elements, warm thankful design, heartfelt aesthetic',
            'get_well' => 'healing and wellness theme, soothing colors, comforting elements, hopeful imagery',
            'sympathy' => 'peaceful sympathy theme, gentle comfort, serene atmosphere, respectful design',
            'congratulations' => 'celebration theme, achievement symbols, success imagery, triumphant design',
            'holiday' => 'festive holiday theme, seasonal decorations, celebratory atmosphere',
            'christmas' => 'christmas theme, winter wonderland, festive decorations, cozy holiday atmosphere',
            'valentines' => 'romantic valentine theme, hearts and love, red and pink aesthetics, romantic imagery',
            'mothers_day' => 'mothers day theme, floral beauty, nurturing love, elegant feminine design',
            'fathers_day' => 'fathers day theme, distinguished design, appreciation elements, warm masculine aesthetic',
            'easter' => 'easter spring theme, pastel colors, renewal symbols, fresh spring imagery',
            'new_year' => 'new year celebration, fresh beginnings, sparkles and stars, hopeful future',
            'friendship' => 'friendship theme, connection symbols, warm companionship, joyful bond imagery',
            'love' => 'romantic love theme, hearts and romance, passionate colors, intimate atmosphere',
        ];

        return $occasions[$occasion] ?? "themed for {$occasion} occasion";
    }

    /**
     * Get mood-specific prompt elements
     */
    private static function getMoodPrompt(string $mood): string
    {
        $moods = [
            'joyful' => 'bright joyful atmosphere, happy vibes, uplifting energy, cheerful colors',
            'romantic' => 'romantic dreamy atmosphere, soft and intimate, loving warmth',
            'elegant' => 'sophisticated elegant mood, refined aesthetic, luxurious feel',
            'playful' => 'fun playful mood, whimsical elements, light-hearted design',
            'serene' => 'calm serene atmosphere, peaceful tranquility, soothing presence',
            'warm' => 'warm cozy atmosphere, comforting presence, heartfelt warmth',
            'nostalgic' => 'nostalgic vintage feel, timeless charm, sentimental beauty',
            'modern' => 'contemporary modern aesthetic, clean minimal, current trends',
            'whimsical' => 'magical whimsical mood, fantasy elements, enchanting design',
            'sophisticated' => 'high-end sophisticated mood, premium quality feel, refined taste',
        ];

        return $moods[$mood] ?? "{$mood} atmosphere and mood";
    }

    /**
     * Get art style prompt elements
     */
    private static function getArtStylePrompt(string $artStyle): string
    {
        $styles = [
            'watercolor' => 'beautiful watercolor painting style, soft brush strokes, flowing colors, artistic blend',
            'digital_art' => 'polished digital art style, clean lines, vibrant colors, modern illustration',
            'oil_painting' => 'rich oil painting style, textured brush work, classical art feel',
            'minimalist' => 'minimalist design style, clean simple forms, negative space, modern minimal',
            'realistic' => 'photorealistic style, lifelike details, natural appearance',
            'abstract' => 'abstract artistic style, creative interpretation, artistic expression',
            'vintage' => 'vintage retro style, classic design elements, timeless aesthetic',
            'flat_design' => 'modern flat design, clean vectors, bold shapes, contemporary graphic',
            '3d_render' => 'professional 3D render style, depth and dimension, polished surfaces',
            'pencil_sketch' => 'elegant pencil sketch style, fine line work, artistic drawing',
            'pastel' => 'soft pastel art style, gentle colors, dreamy texture',
            'pop_art' => 'bold pop art style, vibrant contrasts, graphic impact',
        ];

        return $styles[$artStyle] ?? "{$artStyle} artistic style";
    }

    /**
     * Get color palette prompt
     */
    private static function getColorPrompt(string $colors): string
    {
        $palettes = [
            'warm' => 'warm color palette, reds oranges yellows, cozy inviting tones',
            'cool' => 'cool color palette, blues greens purples, calming refreshing tones',
            'pastel' => 'soft pastel colors, gentle muted tones, delicate palette',
            'vibrant' => 'vibrant bold colors, high saturation, eye-catching palette',
            'monochrome' => 'elegant monochrome palette, single color variations, sophisticated',
            'earth' => 'natural earth tones, browns greens tans, organic palette',
            'sunset' => 'sunset color palette, warm gradients, golden hour tones',
            'ocean' => 'ocean color palette, blues teals aquas, seaside freshness',
            'forest' => 'forest color palette, deep greens browns, natural woodland',
            'romantic' => 'romantic color palette, pinks reds soft purples, loving tones',
            'luxury' => 'luxury color palette, golds blacks deep colors, premium feel',
            'spring' => 'spring color palette, fresh greens soft pinks, renewal colors',
            'autumn' => 'autumn color palette, oranges reds browns, harvest tones',
            'winter' => 'winter color palette, icy blues whites silvers, crisp cold tones',
        ];

        return $palettes[$colors] ?? "color palette: {$colors}";
    }

    /**
     * Get lighting prompt
     */
    private static function getLightingPrompt(string $lighting): string
    {
        $lights = [
            'soft' => 'soft diffused lighting, gentle shadows, even illumination',
            'dramatic' => 'dramatic lighting, bold shadows, high contrast',
            'warm' => 'warm golden lighting, cozy glow, inviting atmosphere',
            'cool' => 'cool blue lighting, crisp clarity, fresh feel',
            'natural' => 'natural daylight lighting, realistic illumination',
            'studio' => 'professional studio lighting, clean bright, polished',
            'sunset' => 'warm sunset lighting, golden hour glow, romantic ambiance',
            'moonlight' => 'soft moonlight glow, ethereal night lighting, dreamy',
            'backlit' => 'beautiful backlighting, rim light, atmospheric depth',
        ];

        return $lights[$lighting] ?? "{$lighting} lighting style";
    }

    /**
     * Get orientation-specific composition
     */
    private static function getOrientationPrompt(string $orientation): string
    {
        return match ($orientation) {
            'portrait'  => 'vertical portrait composition, tall format design, balanced vertical layout',
            'landscape' => 'horizontal landscape composition, wide format design, balanced horizontal layout',
            'square'    => 'square format composition, centered balanced design, symmetrical layout',
            default     => 'balanced greeting card composition',
        };
    }

    /**
     * Build a simple prompt from just a text description
     */
    public static function buildSimple(string $description, string $style = 'digital_art'): string
    {
        return self::build([
            'elements'  => $description,
            'art_style' => $style,
            'mood'      => 'warm',
            'colors'    => 'vibrant',
            'lighting'  => 'soft',
        ]);
    }
}

