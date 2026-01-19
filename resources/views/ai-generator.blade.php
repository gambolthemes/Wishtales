@extends('layouts.app')

@section('title', 'AI Card Generator - Create Magic')

@push('styles')
<style>
    .ai-hero {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        position: relative;
        overflow: hidden;
        min-height: calc(100vh - 64px);
    }
    
    .ai-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,107,157,0.1) 0%, transparent 50%);
        animation: rotate 20s linear infinite;
    }
    
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .style-card {
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }
    
    .style-card:hover {
        transform: translateY(-5px) scale(1.02);
    }
    
    .style-card.selected {
        box-shadow: 0 0 0 3px #FF6B9D, 0 0 20px rgba(255,107,157,0.5);
    }
    
    .style-card.selected::after {
        content: '✓';
        position: absolute;
        top: 8px;
        right: 8px;
        width: 24px;
        height: 24px;
        background: linear-gradient(135deg, #FF6B9D, #FF8E53);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 12px;
        font-weight: bold;
        z-index: 10;
    }
    
    .recipe-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .recipe-card:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    
    .recipe-card.selected {
        box-shadow: 0 0 0 2px #FF6B9D;
    }
    
    .floating-shape {
        position: absolute;
        opacity: 0.1;
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(10deg); }
    }
    
    .generate-btn {
        background: linear-gradient(135deg, #FF6B9D 0%, #FF8E53 100%);
        transition: all 0.3s ease;
    }
    
    .generate-btn:hover:not(:disabled) {
        transform: scale(1.05);
        box-shadow: 0 10px 30px rgba(255,107,157,0.4);
    }
    
    .generate-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    
    .prompt-input {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.3s ease;
    }
    
    .prompt-input:focus {
        background: rgba(255,255,255,0.1);
        border-color: #FF6B9D;
        box-shadow: 0 0 20px rgba(255,107,157,0.2);
    }
    
    .generated-card {
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }
    
    .generated-card:nth-child(1) { animation-delay: 0.1s; }
    .generated-card:nth-child(2) { animation-delay: 0.2s; }
    .generated-card:nth-child(3) { animation-delay: 0.3s; }
    .generated-card:nth-child(4) { animation-delay: 0.4s; }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .loading-overlay {
        background: rgba(0,0,0,0.9);
        backdrop-filter: blur(10px);
    }
    
    .sparkle {
        animation: sparkle 1.5s ease-in-out infinite;
    }
    
    @keyframes sparkle {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.2); }
    }
    
    .card-selected {
        box-shadow: 0 0 0 3px #10B981, 0 0 20px rgba(16,185,129,0.5) !important;
    }
    
    .toast {
        animation: slideIn 0.3s ease;
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>
@endpush

@section('content')
<div class="ai-hero py-8 px-6">
    <!-- Floating Decorations -->
    <div class="floating-shape top-20 left-10 w-20 h-20 border-2 border-pink-400 rounded-full"></div>
    <div class="floating-shape top-40 right-20 w-16 h-16 border-2 border-blue-400" style="animation-delay: -2s; clip-path: polygon(50% 0%, 100% 100%, 0% 100%);"></div>
    <div class="floating-shape bottom-40 left-1/4 w-12 h-12 bg-gradient-to-r from-pink-400 to-orange-400 rounded-full" style="animation-delay: -4s;"></div>
    <div class="floating-shape bottom-20 right-10 w-24 h-24 border-2 border-cyan-400" style="animation-delay: -3s; clip-path: polygon(50% 0%, 100% 100%, 0% 100%);"></div>
    
    <div class="max-w-5xl mx-auto relative z-10">
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-pink-500 to-orange-400 rounded-2xl mb-6 shadow-lg">
                <i class="fas fa-wand-magic-sparkles text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl lg:text-4xl font-bold text-white mb-3">
                Ultimate convenience, for the
            </h1>
            <h2 class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-pink-400 to-orange-400 bg-clip-text text-transparent">
                AI card creator lifestyle
            </h2>
            <p class="text-gray-400 mt-4 max-w-lg mx-auto">
                Describe your dream card and let AI create beautiful designs for you instantly!
            </p>
        </div>
        
        <!-- Choose Style Section -->
        <div class="mb-8">
            <h3 class="text-white text-lg font-semibold text-center mb-4">Choose Style</h3>
            <div class="flex justify-center gap-4 flex-wrap">
                <!-- Realistic -->
                <div class="style-card relative w-32 h-40 rounded-2xl overflow-hidden shadow-xl" data-style="realistic">
                    <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=300&h=400&fit=crop" 
                         alt="Realistic" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                    <span class="absolute bottom-3 left-0 right-0 text-center text-white text-sm font-medium">Realistic</span>
                </div>
                
                <!-- Painting -->
                <div class="style-card selected relative w-32 h-40 rounded-2xl overflow-hidden shadow-xl" data-style="painting">
                    <img src="https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?w=300&h=400&fit=crop" 
                         alt="Painting" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                    <span class="absolute bottom-3 left-0 right-0 text-center text-white text-sm font-medium">Painting</span>
                </div>
                
                <!-- Drawing -->
                <div class="style-card relative w-32 h-40 rounded-2xl overflow-hidden shadow-xl" data-style="drawing">
                    <img src="https://images.unsplash.com/photo-1596638787647-904d822d751e?w=300&h=400&fit=crop" 
                         alt="Drawing" class="w-full h-full object-cover grayscale">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                    <span class="absolute bottom-3 left-0 right-0 text-center text-white text-sm font-medium">Drawing</span>
                </div>
                
                <!-- 3D Art -->
                <div class="style-card relative w-32 h-40 rounded-2xl overflow-hidden shadow-xl" data-style="3d">
                    <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=300&h=400&fit=crop" 
                         alt="3D Art" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                    <span class="absolute bottom-3 left-0 right-0 text-center text-white text-sm font-medium">3D Art</span>
                </div>
            </div>
        </div>
        
        <!-- Hashtag Recipes Section -->
        <div class="mb-8">
            <h3 class="text-white text-lg font-semibold text-center mb-4">Card Recipes</h3>
            <div class="flex justify-center gap-3 flex-wrap">
                <div class="recipe-card w-16 h-16 rounded-xl overflow-hidden relative" data-recipe="birthday-magic">
                    <img src="https://images.unsplash.com/photo-1530103862676-de8c9debad1d?w=150&h=150&fit=crop" 
                         alt="Birthday" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-purple-600/80 to-transparent"></div>
                    <span class="absolute bottom-0.5 left-0 right-0 text-center text-white text-[9px] font-medium">#birthday</span>
                </div>
                
                <div class="recipe-card w-16 h-16 rounded-xl overflow-hidden relative" data-recipe="love-story">
                    <img src="https://images.unsplash.com/photo-1518199266791-5375a83190b7?w=150&h=150&fit=crop" 
                         alt="Love" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-pink-600/80 to-transparent"></div>
                    <span class="absolute bottom-0.5 left-0 right-0 text-center text-white text-[9px] font-medium">#love</span>
                </div>
                
                <div class="recipe-card selected w-16 h-16 rounded-xl overflow-hidden relative" data-recipe="galaxy">
                    <img src="https://images.unsplash.com/photo-1462331940025-496dfbfc7564?w=150&h=150&fit=crop" 
                         alt="Galaxy" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-600/80 to-transparent"></div>
                    <span class="absolute bottom-0.5 left-0 right-0 text-center text-white text-[9px] font-medium">#galaxy</span>
                </div>
                
                <div class="recipe-card w-16 h-16 rounded-xl overflow-hidden relative" data-recipe="nature">
                    <img src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=150&h=150&fit=crop" 
                         alt="Nature" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-green-600/80 to-transparent"></div>
                    <span class="absolute bottom-0.5 left-0 right-0 text-center text-white text-[9px] font-medium">#nature</span>
                </div>
                
                <div class="recipe-card w-16 h-16 rounded-xl overflow-hidden relative" data-recipe="wonder">
                    <img src="https://images.unsplash.com/photo-1534447677768-be436bb09401?w=150&h=150&fit=crop" 
                         alt="Wonder" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-cyan-600/80 to-transparent"></div>
                    <span class="absolute bottom-0.5 left-0 right-0 text-center text-white text-[9px] font-medium">#wonder</span>
                </div>
                
                <div class="recipe-card w-16 h-16 rounded-xl overflow-hidden relative" data-recipe="noir">
                    <img src="https://images.unsplash.com/photo-1489549132488-d00b7eee80f1?w=150&h=150&fit=crop" 
                         alt="Noir" class="w-full h-full object-cover grayscale">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-800/80 to-transparent"></div>
                    <span class="absolute bottom-0.5 left-0 right-0 text-center text-white text-[9px] font-medium">#noir</span>
                </div>
                
                <div class="recipe-card w-16 h-16 rounded-xl overflow-hidden relative" data-recipe="vintage">
                    <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=150&h=150&fit=crop" 
                         alt="Vintage" class="w-full h-full object-cover sepia">
                    <div class="absolute inset-0 bg-gradient-to-t from-amber-600/80 to-transparent"></div>
                    <span class="absolute bottom-0.5 left-0 right-0 text-center text-white text-[9px] font-medium">#vintage</span>
                </div>
                
                <div class="recipe-card w-16 h-16 rounded-xl overflow-hidden relative" data-recipe="watercolor">
                    <img src="https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?w=150&h=150&fit=crop" 
                         alt="Watercolor" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-rose-600/80 to-transparent"></div>
                    <span class="absolute bottom-0.5 left-0 right-0 text-center text-white text-[9px] font-medium">#watercolor</span>
                </div>
            </div>
        </div>
        
        <!-- Prompt Input Section -->
        <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-5 mb-8 border border-white/10">
            <form id="generate-form">
                @csrf
                <div class="flex items-center gap-4">
                    <div class="flex-1">
                        <input type="text" 
                               id="prompt-input"
                               name="prompt"
                               placeholder="What do you want to generate? e.g., A birthday card with balloons and confetti..."
                               class="prompt-input w-full px-5 py-3 rounded-xl text-white placeholder-gray-400 outline-none"
                               required>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/20 transition" title="Add Reference Image">
                            <i class="fas fa-image"></i>
                        </button>
                        <button type="submit" id="generate-btn" class="generate-btn px-6 py-3 rounded-xl text-white font-semibold flex items-center gap-2">
                            <i class="fas fa-sparkles sparkle"></i> Generate
                        </button>
                    </div>
                </div>
            </form>
            
            <!-- Quick Prompts -->
            <div class="flex flex-wrap gap-2 mt-4">
                <span class="text-gray-500 text-sm">Try:</span>
                <button class="quick-prompt px-3 py-1 bg-white/10 rounded-full text-gray-300 text-xs hover:bg-white/20 transition">
                    🎂 Birthday celebration with cake
                </button>
                <button class="quick-prompt px-3 py-1 bg-white/10 rounded-full text-gray-300 text-xs hover:bg-white/20 transition">
                    💕 Romantic anniversary card
                </button>
                <button class="quick-prompt px-3 py-1 bg-white/10 rounded-full text-gray-300 text-xs hover:bg-white/20 transition">
                    🌸 Thank you with flowers
                </button>
                <button class="quick-prompt px-3 py-1 bg-white/10 rounded-full text-gray-300 text-xs hover:bg-white/20 transition">
                    🎄 Christmas winter wonderland
                </button>
            </div>
        </div>
        
        <!-- Generated Cards Preview -->
        <div id="generated-cards" class="hidden">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-white text-lg font-semibold">
                    <i class="fas fa-wand-magic-sparkles text-pink-400 mr-2"></i>
                    Generated Cards
                </h3>
                <span class="text-gray-400 text-sm">Click on a card to select it</span>
            </div>
            <div id="cards-grid" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Generated cards will appear here -->
            </div>
            
            <div class="flex justify-center gap-4 mt-8">
                <button id="regenerate-btn" class="px-6 py-3 bg-white/10 rounded-xl text-white font-medium hover:bg-white/20 transition flex items-center gap-2">
                    <i class="fas fa-rotate"></i> Regenerate
                </button>
                <button id="save-btn" class="px-6 py-3 bg-green-500/20 border border-green-500/50 rounded-xl text-green-400 font-medium hover:bg-green-500/30 transition flex items-center gap-2 hidden">
                    <i class="fas fa-heart"></i> Save to Collection
                </button>
                <button id="use-card-btn" class="generate-btn px-6 py-3 rounded-xl text-white font-medium flex items-center gap-2 hidden">
                    <i class="fas fa-check"></i> Use This Card
                </button>
            </div>
        </div>

        <!-- My Saved Cards -->
        @auth
        @if(isset($myGenerations) && count($myGenerations) > 0)
        <div class="mt-12 pt-8 border-t border-white/10">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-white text-lg font-semibold">
                    <i class="fas fa-folder text-yellow-400 mr-2"></i>
                    My Saved Cards
                </h3>
                <a href="{{ route('ai.my-cards') }}" class="text-pink-400 hover:text-pink-300 text-sm font-medium">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($myGenerations as $card)
                <div class="relative group rounded-2xl overflow-hidden shadow-xl">
                    <div class="aspect-[3/4]">
                        <img src="{{ $card->image_url }}" alt="Generated Card" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition">
                        <div class="absolute bottom-3 left-3 right-3">
                            <p class="text-white text-xs truncate mb-2">{{ $card->prompt }}</p>
                            <div class="flex gap-2">
                                <span class="bg-white/20 text-white text-[10px] px-2 py-0.5 rounded-full">{{ $card->style }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endauth
    </div>
    
    <!-- Loading Overlay -->
    <div id="loading-overlay" class="hidden fixed inset-0 loading-overlay z-50 flex items-center justify-center">
        <div class="text-center">
            <div class="relative w-24 h-24 mx-auto mb-6">
                <div class="absolute inset-0 border-4 border-pink-500/30 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-transparent border-t-pink-500 rounded-full animate-spin"></div>
                <div class="absolute inset-2 border-4 border-transparent border-t-orange-400 rounded-full animate-spin" style="animation-direction: reverse; animation-duration: 0.8s;"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <i class="fas fa-wand-magic-sparkles text-pink-400 text-2xl sparkle"></i>
                </div>
            </div>
            <p class="text-white text-xl font-semibold mb-2">Creating Magic...</p>
            <p class="text-gray-400" id="loading-status">Analyzing your prompt</p>
        </div>
    </div>
    
    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedStyle = 'painting';
    let selectedRecipe = 'galaxy';
    let selectedCard = null;
    let generatedCards = [];
    
    // Style Selection
    document.querySelectorAll('.style-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.style-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            selectedStyle = this.dataset.style;
        });
    });
    
    // Recipe Selection
    document.querySelectorAll('.recipe-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.recipe-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            selectedRecipe = this.dataset.recipe;
        });
    });
    
    // Quick Prompts
    document.querySelectorAll('.quick-prompt').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('prompt-input').value = this.textContent.trim();
            document.getElementById('prompt-input').focus();
        });
    });
    
    // Generate Form Submit
    document.getElementById('generate-form').addEventListener('submit', function(e) {
        e.preventDefault();
        generateCards();
    });
    
    // Regenerate Button
    document.getElementById('regenerate-btn').addEventListener('click', generateCards);
    
    function generateCards() {
        const prompt = document.getElementById('prompt-input').value;
        if (!prompt.trim()) {
            showToast('Please enter a prompt!', 'error');
            return;
        }
        
        const overlay = document.getElementById('loading-overlay');
        const loadingStatus = document.getElementById('loading-status');
        const generateBtn = document.getElementById('generate-btn');
        
        overlay.classList.remove('hidden');
        generateBtn.disabled = true;
        
        // Reset selection
        selectedCard = null;
        document.getElementById('save-btn').classList.add('hidden');
        document.getElementById('use-card-btn').classList.add('hidden');
        
        // Loading states animation
        const statuses = [
            'Analyzing your prompt...',
            'Choosing the best style...',
            'Generating artwork...',
            'Adding finishing touches...'
        ];
        
        let statusIndex = 0;
        const statusInterval = setInterval(() => {
            statusIndex = (statusIndex + 1) % statuses.length;
            loadingStatus.textContent = statuses[statusIndex];
        }, 1000);
        
        // Make API call
        fetch('{{ route("ai.generate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                prompt: prompt,
                style: selectedStyle,
                recipe: selectedRecipe
            })
        })
        .then(response => response.json())
        .then(data => {
            clearInterval(statusInterval);
            overlay.classList.add('hidden');
            generateBtn.disabled = false;
            
            if (data.success) {
                generatedCards = data.cards;
                showGeneratedCards(data.cards);
                showToast('Cards generated successfully!', 'success');
            } else {
                showToast(data.message || 'Failed to generate cards', 'error');
            }
        })
        .catch(error => {
            clearInterval(statusInterval);
            overlay.classList.add('hidden');
            generateBtn.disabled = false;
            showToast('Something went wrong. Please try again.', 'error');
            console.error(error);
        });
    }
    
    function showGeneratedCards(cards) {
        const container = document.getElementById('generated-cards');
        const grid = document.getElementById('cards-grid');
        
        grid.innerHTML = cards.map((card, i) => `
            <div class="generated-card cursor-pointer group" data-index="${i}" data-image="${card.image}">
                <div class="card-wrapper relative aspect-[3/4] rounded-2xl overflow-hidden shadow-xl">
                    <img src="${card.image}" alt="Generated Card ${i+1}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition">
                        <div class="absolute bottom-4 left-4 right-4 flex justify-center gap-2">
                            <button onclick="event.stopPropagation(); saveCard(${i})" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-800 hover:bg-pink-100 transition" title="Save to Collection">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                    <div class="select-indicator absolute top-3 right-3 opacity-0 transition">
                        <span class="bg-green-500 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-check"></i>
                        </span>
                    </div>
                </div>
            </div>
        `).join('');
        
        container.classList.remove('hidden');
        
        // Add click handlers for selection
        document.querySelectorAll('.generated-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.generated-card').forEach(c => {
                    c.querySelector('.card-wrapper').classList.remove('card-selected');
                    c.querySelector('.select-indicator').classList.add('opacity-0');
                });
                this.querySelector('.card-wrapper').classList.add('card-selected');
                this.querySelector('.select-indicator').classList.remove('opacity-0');
                selectedCard = generatedCards[this.dataset.index];
                
                document.getElementById('save-btn').classList.remove('hidden');
                document.getElementById('use-card-btn').classList.remove('hidden');
            });
        });
        
        container.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    
    // Save Card Function (global)
    window.saveCard = function(index) {
        const card = generatedCards[index];
        
        fetch('{{ route("ai.save") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                image: card.image,
                prompt: card.prompt,
                style: card.style,
                recipe: card.recipe
            })
        })
        .then(response => {
            if (response.status === 401) {
                throw new Error('login');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showToast('Card saved to your collection!', 'success');
            } else {
                showToast(data.message || 'Failed to save card', 'error');
            }
        })
        .catch(error => {
            if (error.message === 'login') {
                showToast('Please login to save cards', 'error');
            } else {
                showToast('Something went wrong', 'error');
            }
        });
    };
    
    // Save Selected Card Button
    document.getElementById('save-btn').addEventListener('click', function() {
        if (!selectedCard) {
            showToast('Please select a card first', 'error');
            return;
        }
        
        const index = generatedCards.findIndex(c => c.id === selectedCard.id);
        if (index !== -1) {
            saveCard(index);
        }
    });
    
    // Use Card Button
    document.getElementById('use-card-btn').addEventListener('click', function() {
        if (!selectedCard) {
            showToast('Please select a card first', 'error');
            return;
        }
        
        fetch('{{ route("ai.use") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                image: selectedCard.image,
                prompt: selectedCard.prompt
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Redirecting to cards...', 'success');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1000);
            }
        })
        .catch(error => {
            showToast('Something went wrong', 'error');
        });
    });
    
    // Toast Function
    function showToast(message, type = 'info') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        
        const bgColors = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            info: 'bg-blue-500'
        };
        
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            info: 'fa-info-circle'
        };
        
        toast.className = `toast ${bgColors[type]} text-white px-4 py-3 rounded-lg shadow-lg flex items-center gap-2`;
        toast.innerHTML = `
            <i class="fas ${icons[type]}"></i>
            <span>${message}</span>
        `;
        
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
});
</script>
@endpush
@endsection
