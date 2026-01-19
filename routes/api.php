<?php

use App\Http\Controllers\Api\V1\AiCardApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| AI Card Generation API v1
|--------------------------------------------------------------------------
|
| RESTful API for AI-powered greeting card generation.
| All endpoints are prefixed with /api/v1/cards
|
*/

Route::prefix('v1/cards')->name('api.v1.cards.')->group(function () {
    
    // Public endpoints
    Route::get('/options', [AiCardApiController::class, 'options'])
        ->name('options');
    
    Route::get('/health', [AiCardApiController::class, 'health'])
        ->name('health');

    // Protected endpoints (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        
        // Generate a new card
        Route::post('/generate', [AiCardApiController::class, 'generate'])
            ->name('generate');
        
        // Check generation status
        Route::get('/status/{id}', [AiCardApiController::class, 'status'])
            ->name('status');
        
        // Preview prompt without generating
        Route::post('/preview-prompt', [AiCardApiController::class, 'previewPrompt'])
            ->name('preview-prompt');
        
        // Get user's generation history
        Route::get('/history', [AiCardApiController::class, 'history'])
            ->name('history');
    });
});
