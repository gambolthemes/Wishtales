<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        $featuredCards = Card::with('category')
            ->active()
            ->featured()
            ->take(8)
            ->get();
        
        return view('home', compact('categories', 'featuredCards'));
    }

    public function getInspired()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        $cards = Card::with('category')
            ->active()
            ->latest()
            ->paginate(20);
        
        return view('inspired', compact('categories', 'cards'));
    }

    public function aiGenerator()
    {
        return view('ai-generator');
    }
}
