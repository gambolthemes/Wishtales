<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WishTales') - Send Beautiful Greeting Cards</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#FFD93D',
                        'primary-dark': '#F5C400',
                        'secondary': '#1a1a1a',
                        'accent': '#FFA07A',
                        'background': '#FFFDF5',
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        .nav-link {
            position: relative;
            transition: all 0.3s;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: #1a1a1a;
            transition: width 0.3s;
        }
        
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
        
        .nav-link.active {
            font-weight: 600;
        }
        
        .btn-signin {
            background: #1a1a1a;
            color: white;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-signin:hover {
            background: #333;
            transform: translateY(-2px);
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-white min-h-screen">
    <!-- Top Navigation -->
    <header class="fixed top-0 left-0 right-0 bg-white z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-yellow-400 rounded-lg flex items-center justify-center">
                        <i class="fas fa-gift text-gray-900 text-sm"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-900">Wishtales</span>
                    <span class="text-yellow-400">🎁</span>
                </a>
                
                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="nav-link text-gray-700 {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('cards.index') }}" class="nav-link text-gray-700 {{ request()->routeIs('cards.*') ? 'active' : '' }}">About us</a>
                    <a href="#how-it-works" class="nav-link text-gray-700">How it works</a>
                    <a href="{{ route('contacts.index') }}" class="nav-link text-gray-700 {{ request()->routeIs('contacts.*') ? 'active' : '' }}">Contact</a>
                </nav>
                
                <!-- Auth Button -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ route('gifts.index') }}" class="text-gray-700 hover:text-gray-900">
                            <i class="fas fa-gift mr-1"></i> My Gifts
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="btn-signin">
                                <i class="fas fa-sign-out-alt mr-1"></i> Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-signin">
                            <i class="fas fa-user mr-1"></i> Sign In
                        </a>
                    @endauth
                </div>
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden text-gray-700">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </header>
    
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white w-64 h-full overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-8">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-yellow-400 rounded-lg flex items-center justify-center">
                            <i class="fas fa-gift text-gray-900 text-sm"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-900">Wishtales</span>
                    </a>
                    <button id="close-mobile-menu" class="text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <nav class="space-y-4">
                    <a href="{{ route('home') }}" class="block text-gray-700 hover:text-gray-900 py-2">Home</a>
                    <a href="{{ route('cards.index') }}" class="block text-gray-700 hover:text-gray-900 py-2">Cards</a>
                    <a href="#how-it-works" class="block text-gray-700 hover:text-gray-900 py-2">How it works</a>
                    <a href="{{ route('contacts.index') }}" class="block text-gray-700 hover:text-gray-900 py-2">Contact</a>
                    
                    <hr class="my-4">
                    
                    @auth
                        <a href="{{ route('gifts.index') }}" class="block text-gray-700 hover:text-gray-900 py-2">My Gifts</a>
                        <a href="{{ route('events.index') }}" class="block text-gray-700 hover:text-gray-900 py-2">Upcoming Events</a>
                        <form action="{{ route('logout') }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full btn-signin text-center">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block w-full btn-signin text-center">Sign In</a>
                        <a href="{{ route('register') }}" class="block text-center text-gray-700 hover:text-gray-900 py-2 mt-2">Create Account</a>
                    @endauth
                </nav>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <main class="pt-16">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mx-4 mt-4 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mx-4 mt-4 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <!-- Brand -->
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-yellow-400 rounded-lg flex items-center justify-center">
                            <i class="fas fa-gift text-gray-900 text-sm"></i>
                        </div>
                        <span class="text-xl font-bold">Wishtales</span>
                        <span class="text-yellow-400">🎁</span>
                    </div>
                    <p class="text-gray-400 text-sm mb-4">Personalized digital cards and group gifts made easy—join thousands who love Wishtales!</p>
                    <p class="text-gray-400 text-sm">
                        <i class="fas fa-phone mr-2"></i> +1(500) 123-4567
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('cards.index') }}" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#how-it-works" class="hover:text-white transition">How Wishtales work</a></li>
                        <li><a href="{{ route('cards.index') }}" class="hover:text-white transition">Create Wishtales</a></li>
                    </ul>
                </div>
                
                <!-- Quick Links 2 -->
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('privacy-policy') }}" class="hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="{{ route('terms-of-service') }}" class="hover:text-white transition">Terms of Service</a></li>
                        <li><a href="{{ route('help-center') }}" class="hover:text-white transition">Help Center</a></li>
                    </ul>
                </div>
                
                <!-- Follow Us -->
                <div>
                    <h4 class="font-semibold mb-4">Follow Us</h4>
                    <p class="text-gray-400 text-sm mb-4">Follow us for the latest updates, tips, and inspiration from the Wishtales community.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:bg-yellow-400 hover:text-gray-900 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:bg-yellow-400 hover:text-gray-900 transition">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:bg-yellow-400 hover:text-gray-900 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:bg-yellow-400 hover:text-gray-900 transition">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <hr class="border-gray-800 mb-8">
            
            <div class="text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} Wishtales. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMobileMenu = document.getElementById('close-mobile-menu');
        
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.remove('hidden');
            });
        }
        
        if (closeMobileMenu && mobileMenu) {
            closeMobileMenu.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
            
            mobileMenu.addEventListener('click', (e) => {
                if (e.target === mobileMenu) {
                    mobileMenu.classList.add('hidden');
                }
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>
