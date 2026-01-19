@extends('layouts.app')

@section('title', 'Customize - ' . $card->title)

@push('styles')
<style>
    .customize-container {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        min-height: calc(100vh - 4rem);
    }
    
    .card-preview-container {
        perspective: 1000px;
    }
    
    .card-preview {
        transform-style: preserve-3d;
        transition: transform 0.6s;
    }
    
    .envelope {
        background: linear-gradient(135deg, #d4a574 0%, #c4956a 100%);
        clip-path: polygon(0 30%, 50% 0, 100% 30%, 100% 100%, 0 100%);
        transition: all 0.3s ease;
    }
    
    .envelope.gold {
        background: linear-gradient(135deg, #ffd700 0%, #ffb347 100%);
    }
    
    .envelope.pink {
        background: linear-gradient(135deg, #ffb6c1 0%, #ff69b4 100%);
    }
    
    .envelope.blue {
        background: linear-gradient(135deg, #87ceeb 0%, #4169e1 100%);
    }
    
    .envelope.red {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a5a 100%);
    }
    
    .tab-button.active {
        background-color: #FF6B9D;
        color: white;
    }
    
    .tab-panel {
        display: none;
    }
    
    .tab-panel.active {
        display: block;
    }
    
    .envelope-option {
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .envelope-option:hover, .envelope-option.selected {
        transform: scale(1.05);
        box-shadow: 0 0 0 3px #FF6B9D;
    }
    
    .message-overlay {
        position: absolute;
        bottom: 20%;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255,255,255,0.95);
        padding: 1rem;
        border-radius: 8px;
        max-width: 80%;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .envelope-animation {
        animation: float 3s ease-in-out infinite;
    }
</style>
@endpush

@section('content')
<div class="customize-container relative">
    <!-- Header -->
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-700">
        <a href="{{ route('cards.show', $card) }}" class="flex items-center text-white hover:text-primary transition">
            <i class="fas fa-arrow-left mr-2"></i>
            <span>Back</span>
        </a>
        <h1 class="text-white font-semibold text-lg">Customize</h1>
        @auth
            <button type="button" id="next-btn" class="text-primary font-semibold hover:text-primary-dark transition">
                Next <i class="fas fa-arrow-right ml-1"></i>
            </button>
        @else
            <a href="{{ route('login') }}" class="text-primary font-semibold hover:text-primary-dark transition">
                Login <i class="fas fa-arrow-right ml-1"></i>
            </a>
        @endauth
    </div>
    
    <div class="flex flex-col lg:flex-row min-h-[calc(100vh-8rem)]">
        <!-- Left Panel - Tab Content -->
        <div class="w-full lg:w-80 bg-gray-900 bg-opacity-50 p-4 overflow-y-auto" id="left-panel">
            <!-- Card Panel -->
            <div class="tab-panel active" id="panel-card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-white font-semibold">Choose Card</h3>
                </div>
                
                <div class="grid grid-cols-2 gap-3">
                    <div class="aspect-[3/4] rounded-lg overflow-hidden border-2 border-primary cursor-pointer">
                        <img src="{{ $card->image }}" alt="{{ $card->title }}" class="w-full h-full object-cover">
                    </div>
                    @php
                        $relatedCards = \App\Models\Card::where('category_id', $card->category_id)
                            ->where('id', '!=', $card->id)
                            ->take(5)
                            ->get();
                    @endphp
                    @foreach($relatedCards as $relatedCard)
                        <a href="{{ route('cards.customize', $relatedCard) }}" class="aspect-[3/4] rounded-lg overflow-hidden border-2 border-transparent hover:border-gray-500 cursor-pointer">
                            <img src="{{ $relatedCard->image }}" alt="{{ $relatedCard->title }}" class="w-full h-full object-cover">
                        </a>
                    @endforeach
                </div>
            </div>
            
            <!-- Message Panel -->
            <div class="tab-panel" id="panel-message">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-white font-semibold">Your Message</h3>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Recipient Name</label>
                        <input type="text" id="recipient-name" placeholder="Enter name" 
                               class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white border border-gray-700 focus:border-primary focus:outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Your Message</label>
                        <textarea id="card-message" rows="4" placeholder="Write your message here..."
                                  class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white border border-gray-700 focus:border-primary focus:outline-none resize-none"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Your Name</label>
                        <input type="text" id="sender-name" placeholder="From" 
                               class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white border border-gray-700 focus:border-primary focus:outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Font Style</label>
                        <select id="font-style" class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white border border-gray-700 focus:border-primary focus:outline-none">
                            <option value="font-sans">Sans Serif</option>
                            <option value="font-serif">Serif</option>
                            <option value="font-mono">Monospace</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Envelope Panel -->
            <div class="tab-panel" id="panel-envelope">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-white font-semibold">Choose Envelope</h3>
                </div>
                
                <div class="grid grid-cols-2 gap-3">
                    <div class="envelope-option selected rounded-lg p-4 bg-gray-800" data-envelope="default">
                        <div class="w-full h-16 rounded bg-gradient-to-r from-amber-200 to-amber-300 mb-2"></div>
                        <span class="text-white text-sm">Classic</span>
                    </div>
                    <div class="envelope-option rounded-lg p-4 bg-gray-800" data-envelope="gold">
                        <div class="w-full h-16 rounded bg-gradient-to-r from-yellow-400 to-yellow-500 mb-2"></div>
                        <span class="text-white text-sm">Gold</span>
                    </div>
                    <div class="envelope-option rounded-lg p-4 bg-gray-800" data-envelope="pink">
                        <div class="w-full h-16 rounded bg-gradient-to-r from-pink-300 to-pink-400 mb-2"></div>
                        <span class="text-white text-sm">Pink</span>
                    </div>
                    <div class="envelope-option rounded-lg p-4 bg-gray-800" data-envelope="blue">
                        <div class="w-full h-16 rounded bg-gradient-to-r from-blue-300 to-blue-500 mb-2"></div>
                        <span class="text-white text-sm">Blue</span>
                    </div>
                    <div class="envelope-option rounded-lg p-4 bg-gray-800" data-envelope="red">
                        <div class="w-full h-16 rounded bg-gradient-to-r from-red-400 to-red-500 mb-2"></div>
                        <span class="text-white text-sm">Red</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Preview Area -->
        <div class="flex-1 flex items-center justify-center p-8">
            <div class="card-preview-container">
                <div class="relative">
                    <!-- Decorative sparkles -->
                    <div class="absolute -top-4 -left-4 w-8 h-8 text-yellow-300 animate-pulse">✨</div>
                    <div class="absolute -top-2 right-8 w-6 h-6 text-yellow-200 animate-pulse">✨</div>
                    <div class="absolute bottom-10 -right-6 w-8 h-8 text-yellow-300 animate-pulse">✨</div>
                    
                    <!-- Card with message overlay -->
                    <div class="card-preview relative">
                        <div class="w-64 md:w-80 aspect-[3/4] rounded-lg shadow-2xl overflow-hidden relative">
                            <img src="{{ $card->image }}" alt="{{ $card->title }}" class="w-full h-full object-cover">
                            
                            <!-- Message Overlay (shown when message is entered) -->
                            <div id="message-preview" class="message-overlay hidden">
                                <p id="preview-recipient" class="text-gray-600 text-sm mb-1"></p>
                                <p id="preview-message" class="text-gray-800 font-medium"></p>
                                <p id="preview-sender" class="text-gray-600 text-sm mt-2"></p>
                            </div>
                        </div>
                        
                        <!-- Envelope -->
                        <div id="envelope-preview" class="envelope absolute -bottom-10 left-1/2 -translate-x-1/2 w-72 md:w-96 h-32 rounded-b-lg shadow-xl envelope-animation"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Panel - Preview Info -->
        <div class="w-full lg:w-64 bg-gray-900 bg-opacity-50 p-4 overflow-y-auto hidden lg:block">
            <h3 class="text-white font-semibold mb-4">Preview</h3>
            
            <div class="space-y-4 text-sm">
                <div class="bg-gray-800 rounded-lg p-4">
                    <p class="text-gray-400 mb-1">Card</p>
                    <p class="text-white">{{ $card->title }}</p>
                </div>
                
                <div class="bg-gray-800 rounded-lg p-4">
                    <p class="text-gray-400 mb-1">Category</p>
                    <p class="text-white">{{ $card->category->name }}</p>
                </div>
                
                <div class="bg-gray-800 rounded-lg p-4" id="preview-envelope-info">
                    <p class="text-gray-400 mb-1">Envelope</p>
                    <p class="text-white">Classic</p>
                </div>
                
                <div class="bg-gray-800 rounded-lg p-4" id="preview-message-info">
                    <p class="text-gray-400 mb-1">Message</p>
                    <p class="text-white text-xs" id="preview-message-text">Not set</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bottom Tabs -->
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2">
        <div class="flex bg-gray-800 rounded-full p-1">
            <button class="tab-button active px-6 py-2 rounded-full text-sm font-medium transition" data-tab="card">
                Card
            </button>
            <button class="tab-button text-gray-400 px-6 py-2 rounded-full text-sm font-medium hover:text-white transition" data-tab="message">
                Message
            </button>
            <button class="tab-button text-gray-400 px-6 py-2 rounded-full text-sm font-medium hover:text-white transition" data-tab="envelope">
                Envelope
            </button>
        </div>
    </div>
</div>

<!-- Hidden form for sending data -->
<form id="customize-form" action="{{ route('gifts.create', $card) }}" method="GET" class="hidden">
    <input type="hidden" name="message" id="form-message">
    <input type="hidden" name="recipient_name" id="form-recipient">
    <input type="hidden" name="sender_name" id="form-sender">
    <input type="hidden" name="envelope_style" id="form-envelope" value="default">
</form>
@endsection

@push('scripts')
<script>
    // Tab switching functionality
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.dataset.tab;
            
            // Update tab buttons
            document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Update tab panels
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            document.getElementById('panel-' + tabName).classList.add('active');
        });
    });
    
    // Envelope selection
    let selectedEnvelope = 'default';
    document.querySelectorAll('.envelope-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.envelope-option').forEach(o => o.classList.remove('selected'));
            this.classList.add('selected');
            
            selectedEnvelope = this.dataset.envelope;
            const envelopePreview = document.getElementById('envelope-preview');
            
            // Remove all envelope classes
            envelopePreview.className = 'envelope absolute -bottom-10 left-1/2 -translate-x-1/2 w-72 md:w-96 h-32 rounded-b-lg shadow-xl envelope-animation';
            
            // Add selected envelope class
            if (selectedEnvelope !== 'default') {
                envelopePreview.classList.add(selectedEnvelope);
            }
            
            // Update form
            document.getElementById('form-envelope').value = selectedEnvelope;
            
            // Update preview info
            const envelopeNames = {
                'default': 'Classic',
                'gold': 'Gold',
                'pink': 'Pink',
                'blue': 'Blue',
                'red': 'Red'
            };
            document.querySelector('#preview-envelope-info p.text-white').textContent = envelopeNames[selectedEnvelope];
        });
    });
    
    // Message preview
    const recipientInput = document.getElementById('recipient-name');
    const messageInput = document.getElementById('card-message');
    const senderInput = document.getElementById('sender-name');
    const messagePreview = document.getElementById('message-preview');
    const previewRecipient = document.getElementById('preview-recipient');
    const previewMessage = document.getElementById('preview-message');
    const previewSender = document.getElementById('preview-sender');
    const previewMessageText = document.getElementById('preview-message-text');
    
    function updateMessagePreview() {
        const recipient = recipientInput.value.trim();
        const message = messageInput.value.trim();
        const sender = senderInput.value.trim();
        
        if (recipient || message || sender) {
            messagePreview.classList.remove('hidden');
            previewRecipient.textContent = recipient ? `Dear ${recipient},` : '';
            previewMessage.textContent = message || '';
            previewSender.textContent = sender ? `- ${sender}` : '';
            
            // Update sidebar preview
            previewMessageText.textContent = message ? (message.length > 50 ? message.substring(0, 50) + '...' : message) : 'Not set';
        } else {
            messagePreview.classList.add('hidden');
            previewMessageText.textContent = 'Not set';
        }
        
        // Update form fields
        document.getElementById('form-recipient').value = recipient;
        document.getElementById('form-message').value = message;
        document.getElementById('form-sender').value = sender;
    }
    
    recipientInput.addEventListener('input', updateMessagePreview);
    messageInput.addEventListener('input', updateMessagePreview);
    senderInput.addEventListener('input', updateMessagePreview);
    
    // Font style
    document.getElementById('font-style').addEventListener('change', function() {
        const messageOverlay = document.getElementById('message-preview');
        messageOverlay.className = 'message-overlay ' + this.value;
        if (!recipientInput.value && !messageInput.value && !senderInput.value) {
            messageOverlay.classList.add('hidden');
        }
    });
    
    // Next button - submit form
    const nextBtn = document.getElementById('next-btn');
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            document.getElementById('customize-form').submit();
        });
    }
</script>
@endpush
