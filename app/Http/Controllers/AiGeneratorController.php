<?php

namespace App\Http\Controllers;

use App\Models\GeneratedCard;
use App\Models\Card;
use App\Services\AiImage\PromptBuilder;
use App\Services\AiImage\PromptRandomizer;
use App\Services\AiImage\NegativePrompt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AiGeneratorController extends Controller
{
    // Predefined AI-style images for different styles and recipes
    private $styleImages = [
        'realistic' => [
            'https://images.unsplash.com/photo-1607344645866-009c320b63e0?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1513151233558-d860c5398176?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?w=400&h=500&fit=crop',
        ],
        'painting' => [
            'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1578926288207-a90a5366759d?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1549887534-1541e9326642?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1582201942988-13e60e4556ee?w=400&h=500&fit=crop',
        ],
        'drawing' => [
            'https://images.unsplash.com/photo-1596638787647-904d822d751e?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1502657877623-f66bf489d236?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=400&h=500&fit=crop',
        ],
        '3d' => [
            'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1634017839464-5c339bbe3c35?w=400&h=500&fit=crop',
        ],
    ];

    private $recipeImages = [
        'birthday-magic' => [
            'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1558636508-e0db3814bd1d?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1464349153735-7db50ed83c84?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1513151233558-d860c5398176?w=400&h=500&fit=crop',
        ],
        'love-story' => [
            'https://images.unsplash.com/photo-1518199266791-5375a83190b7?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1516589178581-6cd7833ae3b2?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1518568814500-bf0f8d125f46?w=400&h=500&fit=crop',
        ],
        'galaxy' => [
            'https://images.unsplash.com/photo-1462331940025-496dfbfc7564?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1419242902214-272b3f66ee7a?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1444703686981-a3abbc4d4fe3?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1506318137071-a8e063b4bec0?w=400&h=500&fit=crop',
        ],
        'nature' => [
            'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1426604966848-d7adac402bff?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=400&h=500&fit=crop',
        ],
        'wonder' => [
            'https://images.unsplash.com/photo-1534447677768-be436bb09401?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1507400492013-162706c8c05e?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1485470733090-0aae1788d5af?w=400&h=500&fit=crop',
        ],
        'noir' => [
            'https://images.unsplash.com/photo-1489549132488-d00b7eee80f1?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1478760329108-5c3ed9d495a0?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=400&h=500&fit=crop',
        ],
        'vintage' => [
            'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=500&fit=crop',
        ],
        'watercolor' => [
            'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=400&h=500&fit=crop',
            'https://images.unsplash.com/photo-1578926288207-a90a5366759d?w=400&h=500&fit=crop',
        ],
    ];

    public function index()
    {
        $myGenerations = [];
        if (Auth::check()) {
            $myGenerations = GeneratedCard::where('user_id', Auth::id())
                ->latest()
                ->take(8)
                ->get();
        }
        
        return view('ai-generator', compact('myGenerations'));
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'prompt' => 'required|string|min:3|max:500',
            'style' => 'required|string|in:realistic,painting,drawing,3d',
            'recipe' => 'nullable|string',
        ]);

        // Get images based on style and recipe
        $style = $validated['style'];
        $recipe = $validated['recipe'] ?? null;

        // Combine style and recipe images
        $images = $this->styleImages[$style] ?? $this->styleImages['painting'];
        
        if ($recipe && isset($this->recipeImages[$recipe])) {
            // Mix some recipe images with style images
            $recipeImgs = $this->recipeImages[$recipe];
            shuffle($recipeImgs);
            $images = array_merge(array_slice($images, 0, 2), array_slice($recipeImgs, 0, 2));
        }

        shuffle($images);

        // Generate unique IDs for each card
        $generatedCards = [];
        foreach ($images as $index => $image) {
            $generatedCards[] = [
                'id' => Str::uuid()->toString(),
                'image' => $image,
                'prompt' => $validated['prompt'],
                'style' => $style,
                'recipe' => $recipe,
            ];
        }

        return response()->json([
            'success' => true,
            'cards' => $generatedCards,
            'message' => 'Cards generated successfully!'
        ]);
    }

    public function save(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to save cards'
            ], 401);
        }

        $validated = $request->validate([
            'image' => 'required|url',
            'prompt' => 'required|string',
            'style' => 'required|string',
            'recipe' => 'nullable|string',
        ]);

        $card = GeneratedCard::create([
            'user_id' => Auth::id(),
            'image_url' => $validated['image'],
            'prompt' => $validated['prompt'],
            'style' => $validated['style'],
            'recipe' => $validated['recipe'],
        ]);

        return response()->json([
            'success' => true,
            'card' => $card,
            'message' => 'Card saved to your collection!'
        ]);
    }

    public function myCards()
    {
        $cards = GeneratedCard::where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        return view('ai-generator.my-cards', compact('cards'));
    }

    public function useCard(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|url',
            'prompt' => 'required|string',
        ]);

        // Store in session for use in gift creation
        session([
            'ai_generated_card' => [
                'image' => $validated['image'],
                'prompt' => $validated['prompt'],
            ]
        ]);

        return response()->json([
            'success' => true,
            'redirect' => route('cards.index'),
            'message' => 'Card ready to use!'
        ]);
    }

    public function destroy(GeneratedCard $card)
    {
        if ($card->user_id !== Auth::id()) {
            abort(403);
        }

        $card->delete();

        return back()->with('success', 'Card deleted successfully!');
    }

    /**
     * Generate card with structured prompt using AI services
     */
    public function generateCard(Request $request)
    {
        $validated = $request->validate([
            'occasion'    => 'required|string',
            'mood'        => 'required|string',
            'style'       => 'required|string',
            'elements'    => 'required|string',
            'colors'      => 'required|string',
            'orientation' => 'required|string|in:portrait,landscape,square',
            'background'  => 'required|string',
            'lighting'    => 'required|string',
            'art_style'   => 'required|string',
        ]);

        $prompt = PromptBuilder::build([
            'occasion'    => $validated['occasion'],
            'mood'        => $validated['mood'],
            'style'       => $validated['style'],
            'elements'    => $validated['elements'],
            'colors'      => $validated['colors'],
            'orientation' => $validated['orientation'],
            'background'  => $validated['background'],
            'lighting'    => $validated['lighting'],
            'art_style'   => $validated['art_style'],
        ]);

        $prompt .= PromptRandomizer::random();

        return response()->json([
            'success' => true,
            'prompt' => $prompt,
            'negative_prompt' => NegativePrompt::text()
        ]);
    }
}
