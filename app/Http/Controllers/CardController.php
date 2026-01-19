<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Category;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index(Request $request)
    {
        $query = Card::with('category')->active();
        
        // Filter by category
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filter by premium
        if ($request->has('premium')) {
            $query->premium();
        }
        
        if ($request->has('free')) {
            $query->free();
        }
        
        $cards = $query->latest()->paginate(20);
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        
        return view('cards.index', compact('cards', 'categories'));
    }

    public function show(Card $card)
    {
        $card->incrementViews();
        
        $relatedCards = Card::with('category')
            ->active()
            ->where('category_id', $card->category_id)
            ->where('id', '!=', $card->id)
            ->take(4)
            ->get();
        
        return view('cards.show', compact('card', 'relatedCards'));
    }

    public function customize(Card $card)
    {
        return view('cards.customize', compact('card'));
    }

    public function preview(Request $request, Card $card)
    {
        $customization = $request->validate([
            'message' => 'nullable|string|max:1000',
            'recipient_name' => 'nullable|string|max:100',
            'sender_name' => 'nullable|string|max:100',
            'envelope_style' => 'nullable|string',
        ]);
        
        return view('cards.preview', compact('card', 'customization'));
    }

    public function byCategory(Category $category)
    {
        $cards = Card::with('category')
            ->active()
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(20);
        
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        
        return view('cards.index', compact('cards', 'categories', 'category'));
    }
}
