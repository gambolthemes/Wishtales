<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You've received a gift from {{ $gift->sender_name }}!</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        .gift-bg {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
        }
        
        .envelope {
            background: linear-gradient(135deg, #d4a574 0%, #c4956a 100%);
            clip-path: polygon(0 30%, 50% 0, 100% 30%, 100% 100%, 0 100%);
            transition: all 0.8s ease;
        }
        
        .envelope.gold {
            background: linear-gradient(135deg, #ffd700 0%, #ffb347 100%);
        }
        
        .envelope.pink {
            background: linear-gradient(135deg, #ffb6c1 0%, #ff69b4 100%);
        }
        
        .envelope.opening {
            transform: translateY(150px) scale(0.8);
            opacity: 0;
        }
        
        .card-container {
            transition: all 0.8s ease;
            transform: scale(0.8);
            opacity: 0;
        }
        
        .card-container.revealed {
            transform: scale(1);
            opacity: 1;
        }
        
        .sparkle {
            animation: sparkle 2s ease-in-out infinite;
        }
        
        @keyframes sparkle {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.2); }
        }
        
        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            background-color: #f00;
            animation: confetti-fall 5s linear forwards;
        }
        
        @keyframes confetti-fall {
            0% {
                transform: translateY(-100px) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }
    </style>
</head>
<body class="gift-bg">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="max-w-lg mx-auto text-center">
            <!-- Pre-reveal state -->
            <div id="envelope-view">
                <h1 class="text-white text-2xl md:text-3xl font-bold mb-2">
                    You've received a gift!
                </h1>
                <p class="text-gray-300 mb-8">
                    From {{ $gift->sender_name }}
                </p>
                
                <!-- Envelope -->
                <div class="relative inline-block mb-8">
                    <!-- Sparkles -->
                    <div class="absolute -top-6 -left-6 text-yellow-300 text-3xl sparkle">✨</div>
                    <div class="absolute -top-4 right-4 text-yellow-200 text-2xl sparkle" style="animation-delay: 0.3s">✨</div>
                    <div class="absolute bottom-4 -right-8 text-yellow-300 text-3xl sparkle" style="animation-delay: 0.6s">✨</div>
                    
                    <div id="envelope" class="envelope {{ $gift->envelope_style }} w-80 h-48 md:w-96 md:h-56 rounded-b-lg shadow-2xl cursor-pointer transform hover:scale-105 transition-transform">
                        <div class="flex items-center justify-center h-full pt-12">
                            <span class="text-white text-opacity-80 text-lg font-medium">
                                <i class="fas fa-envelope-open-text text-4xl mb-2 block"></i>
                                Click to open
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Card reveal -->
            <div id="card-view" class="card-container hidden">
                <h1 class="text-white text-2xl md:text-3xl font-bold mb-6">
                    🎉 A gift for you, {{ $gift->recipient_name }}!
                </h1>
                
                <!-- Card -->
                <div class="relative inline-block mb-8">
                    <div class="absolute -top-4 -left-4 text-yellow-300 text-2xl sparkle">✨</div>
                    <div class="absolute -top-2 right-8 text-yellow-200 text-xl sparkle" style="animation-delay: 0.3s">✨</div>
                    
                    <div class="w-72 md:w-80 aspect-[3/4] rounded-2xl overflow-hidden shadow-2xl mx-auto">
                        <img src="{{ $gift->card->image }}" alt="{{ $gift->card->title }}" class="w-full h-full object-cover">
                    </div>
                </div>
                
                <!-- Message -->
                @if($gift->message)
                    <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl p-6 mb-6 text-white">
                        <p class="italic text-lg">"{{ $gift->message }}"</p>
                        <p class="text-right mt-4 text-gray-300">— {{ $gift->sender_name }}</p>
                    </div>
                @else
                    <p class="text-gray-300 mb-6">With love from {{ $gift->sender_name }} 💕</p>
                @endif
                
                <!-- CTA -->
                <a href="{{ route('home') }}" class="inline-block bg-pink-500 text-white px-8 py-4 rounded-full font-semibold hover:bg-pink-600 transition">
                    Send Your Own Card <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
    
    <script>
        const envelope = document.getElementById('envelope');
        const envelopeView = document.getElementById('envelope-view');
        const cardView = document.getElementById('card-view');
        
        envelope.addEventListener('click', function() {
            // Add opening animation
            this.classList.add('opening');
            
            // Create confetti
            createConfetti();
            
            // Show card after delay
            setTimeout(() => {
                envelopeView.classList.add('hidden');
                cardView.classList.remove('hidden');
                
                setTimeout(() => {
                    cardView.classList.add('revealed');
                }, 50);
            }, 600);
        });
        
        function createConfetti() {
            const colors = ['#FF6B9D', '#FFD700', '#00CED1', '#FF69B4', '#7B68EE', '#98FB98'];
            
            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.animationDelay = Math.random() * 3 + 's';
                confetti.style.animationDuration = (Math.random() * 3 + 2) + 's';
                document.body.appendChild(confetti);
                
                setTimeout(() => confetti.remove(), 5000);
            }
        }
    </script>
</body>
</html>
