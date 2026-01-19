<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PricingController extends Controller
{
    /**
     * Display pricing page
     */
    public function index()
    {
        $plans = Plan::active()->ordered()->get();
        
        $currentSubscription = null;
        if (Auth::check()) {
            $currentSubscription = Auth::user()->activeSubscription();
        }

        return view('pricing.index', compact('plans', 'currentSubscription'));
    }

    /**
     * Show plan details
     */
    public function show(Plan $plan)
    {
        return view('pricing.show', compact('plan'));
    }

    /**
     * Compare plans
     */
    public function compare()
    {
        $plans = Plan::active()->ordered()->get();
        
        return view('pricing.compare', compact('plans'));
    }
}
