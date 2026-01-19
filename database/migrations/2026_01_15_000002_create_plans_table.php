<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Free, Pro, Premium
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->enum('billing_cycle', ['monthly', 'yearly', 'lifetime', 'free'])->default('monthly');
            $table->string('stripe_price_id')->nullable();
            
            // Features (JSON for flexibility)
            $table->json('features')->nullable();
            
            // Limits
            $table->integer('cards_per_month')->default(5); // -1 for unlimited
            $table->integer('ai_generations_per_month')->default(0); // -1 for unlimited
            $table->boolean('premium_templates')->default(false);
            $table->boolean('no_watermark')->default(false);
            $table->boolean('priority_support')->default(false);
            $table->boolean('custom_branding')->default(false);
            
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
