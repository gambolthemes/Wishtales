<?php

namespace App\Services\AiImage;

use Illuminate\Support\Str;

/**
 * CardDNA - Unique identifier system to prevent duplicate-looking cards
 * 
 * Creates a "DNA fingerprint" of each card based on its prompt parameters.
 * This allows detection of similar cards and ensures variety.
 */
class CardDNA
{
    /**
     * Generate a unique DNA hash for a card configuration
     */
    public static function generate(array $params): string
    {
        // Extract key differentiating factors
        $dnaComponents = [
            'occasion' => $params['occasion'] ?? 'general',
            'mood' => $params['mood'] ?? 'warm',
            'style' => $params['style'] ?? 'modern',
            'art_style' => $params['art_style'] ?? 'digital_art',
            'colors' => $params['colors'] ?? 'vibrant',
            'elements' => self::normalizeElements($params['elements'] ?? ''),
        ];

        // Sort for consistency
        ksort($dnaComponents);

        // Create base DNA string
        $dnaString = json_encode($dnaComponents);

        // Generate hash
        return hash('sha256', $dnaString);
    }

    /**
     * Generate a short DNA code for display/reference
     */
    public static function shortCode(array $params): string
    {
        $fullDNA = self::generate($params);
        return substr($fullDNA, 0, 12);
    }

    /**
     * Check similarity between two DNA codes
     * Returns a percentage (0-100) of similarity
     */
    public static function calculateSimilarity(string $dna1, string $dna2): float
    {
        if ($dna1 === $dna2) {
            return 100.0;
        }

        // Compare character by character
        $matching = 0;
        $length = min(strlen($dna1), strlen($dna2));

        for ($i = 0; $i < $length; $i++) {
            if ($dna1[$i] === $dna2[$i]) {
                $matching++;
            }
        }

        return ($matching / max(strlen($dna1), strlen($dna2))) * 100;
    }

    /**
     * Check if DNA is too similar to existing ones
     */
    public static function isTooSimilar(string $newDNA, array $existingDNAs, float $threshold = 80.0): bool
    {
        foreach ($existingDNAs as $existingDNA) {
            if (self::calculateSimilarity($newDNA, $existingDNA) >= $threshold) {
                return true;
            }
        }

        return false;
    }

    /**
     * Normalize element strings for consistent comparison
     */
    private static function normalizeElements(string $elements): string
    {
        // Lowercase
        $normalized = strtolower($elements);
        
        // Remove extra whitespace
        $normalized = preg_replace('/\s+/', ' ', $normalized);
        
        // Sort words alphabetically
        $words = explode(' ', trim($normalized));
        sort($words);
        
        return implode(' ', $words);
    }

    /**
     * Generate a variation signature to ensure uniqueness
     */
    public static function generateVariationSignature(): string
    {
        return Str::random(8) . '-' . time();
    }

    /**
     * Create a complete card identity package
     */
    public static function createIdentity(array $params): array
    {
        $dna = self::generate($params);
        
        return [
            'dna' => $dna,
            'short_code' => self::shortCode($params),
            'variation_id' => self::generateVariationSignature(),
            'created_at' => now()->toIso8601String(),
            'params_hash' => md5(json_encode($params)),
        ];
    }

    /**
     * Verify card identity integrity
     */
    public static function verifyIntegrity(array $identity, array $params): bool
    {
        $expectedDNA = self::generate($params);
        return $identity['dna'] === $expectedDNA;
    }
}
