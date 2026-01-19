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
        Schema::create('ai_card_generations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            
            // Status tracking
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            
            // Input parameters
            $table->string('occasion', 50)->nullable();
            $table->string('mood', 50)->nullable();
            $table->string('art_style', 50)->nullable();
            $table->string('orientation', 20)->default('portrait');
            $table->json('params')->nullable();
            
            // Generated content
            $table->string('image_url')->nullable();
            $table->string('image_path')->nullable();
            $table->text('prompt_used')->nullable();
            $table->text('negative_prompt_used')->nullable();
            
            // Card DNA for uniqueness tracking
            $table->string('card_dna', 64)->nullable()->index();
            $table->bigInteger('seed')->nullable();
            $table->json('metadata')->nullable();
            
            // Error handling
            $table->text('error_message')->nullable();
            
            // Timestamps
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['user_id', 'status']);
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_card_generations');
    }
};
