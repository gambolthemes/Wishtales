<?php

namespace App\Services\AiImage;

/**
 * ImageGenerator - Main orchestrator for AI image generation
 * 
 * This is the primary service class that coordinates all AI image
 * generation components. Use this class as the main entry point.
 */
class ImageGenerator
{
    private StableDiffusionClient $client;

    public function __construct()
    {
        $this->client = new StableDiffusionClient();
    }

    /**
     * Generate a greeting card image
     * 
     * @param array $params Card parameters (occasion, mood, style, etc.)
     * @return array Result with success status, image path/url, and metadata
     */
    public function generate(array $params): array
    {
        // 1. Build the prompt
        $prompt = PromptBuilder::build($params);
        
        // 2. Add randomization for uniqueness
        $randomization = PromptRandomizer::randomWithTracking();
        $prompt .= $randomization['prompt'];

        // 3. Get appropriate negative prompt
        $negativePrompt = isset($params['art_style']) 
            ? NegativePrompt::forStyle($params['art_style'])
            : NegativePrompt::text();

        // 4. Generate card DNA for tracking
        $identity = CardDNA::createIdentity($params);

        // 5. Build API payload
        $payload = StableDiffusionClient::buildPayload(
            prompt: $prompt,
            negativePrompt: $negativePrompt,
            orientation: $params['orientation'] ?? 'portrait',
        );

        // 6. Call the API
        $result = $this->client->generateImage($payload);

        if (!$result['success']) {
            return [
                'success' => false,
                'error' => $result['error'] ?? 'Generation failed',
            ];
        }

        // 7. Save the image
        $imagePath = StableDiffusionClient::saveImage(
            $result['images'][0],
            $identity['short_code'] . '.png'
        );

        $imageUrl = StableDiffusionClient::getImageUrl($imagePath);

        // 8. Return complete result
        return [
            'success' => true,
            'image_url' => $imageUrl,
            'image_path' => $imagePath,
            'identity' => $identity,
            'prompt' => $prompt,
            'negative_prompt' => $negativePrompt,
            'randomization' => $randomization['tracking'],
            'seed' => $result['info']['seed'] ?? null,
        ];
    }

    /**
     * Generate multiple variations of a card
     */
    public function generateVariations(array $params, int $count = 4): array
    {
        $results = [];

        for ($i = 0; $i < $count; $i++) {
            $result = $this->generate($params);
            
            if ($result['success']) {
                $results[] = $result;
            }
        }

        return [
            'success' => count($results) > 0,
            'generated' => count($results),
            'requested' => $count,
            'cards' => $results,
        ];
    }

    /**
     * Generate with simple text prompt
     */
    public function generateSimple(string $description, string $style = 'digital_art'): array
    {
        return $this->generate([
            'elements' => $description,
            'art_style' => $style,
            'mood' => 'warm',
            'colors' => 'vibrant',
            'lighting' => 'soft',
            'orientation' => 'portrait',
        ]);
    }

    /**
     * Get the prompt that would be generated (for preview/debugging)
     */
    public function previewPrompt(array $params): array
    {
        $prompt = PromptBuilder::build($params);
        $randomization = PromptRandomizer::randomWithTracking();
        
        $negativePrompt = isset($params['art_style']) 
            ? NegativePrompt::forStyle($params['art_style'])
            : NegativePrompt::text();

        return [
            'prompt' => $prompt . $randomization['prompt'],
            'negative_prompt' => $negativePrompt,
            'randomization' => $randomization['tracking'],
            'identity' => CardDNA::createIdentity($params),
        ];
    }

    /**
     * Check if the AI service is available
     */
    public function isAvailable(): bool
    {
        return $this->client->healthCheck();
    }
}
