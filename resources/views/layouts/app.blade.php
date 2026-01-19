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
                        'primary': '#FF6B9D',
                        'primary-dark': '#E91E63',
                        'secondary': '#FFB6C1',
                        'accent': '#FFA07A',
                        'background': '#FFF0F5',
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
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #FFB6C1 0%, #FFC0CB 50%, #FFE4E1 100%);
        }
        
        .category-pill:hover {
            background-color: #FF6B9D;
            color: white;
        }
        
        .category-pill.active {
            background-color: #FF6B9D;
            color: white;
        }
        
        .premium-badge {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
        }
        
        .sidebar-link:hover, .sidebar-link.active {
            background-color: #FFF0F5;
            color: #FF6B9D;
        }
        
        .envelope-animation {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
        }
        
        @media (min-width: 768px) {
            .card-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-background min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg fixed h-full z-50 hidden lg:block">
            <div class="p-6">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2 mb-8">
                    <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center">
                        <i class="fas fa-gift text-white text-lg"></i>
                    </div>
                    <span class="text-2xl font-bold text-gray-800">WishTales</span>
                </a>
                
                <!-- Search -->
                <form action="{{ route('cards.index') }}" method="GET" class="mb-6">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               placeholder="Search cards..." 
                               value="{{ request('search') }}"
                               class="w-full pl-10 pr-4 py-2 bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-primary">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </form>
                
                <!-- Navigation -->
                <nav class="space-y-2">
                    <a href="{{ route('home') }}" 
                       class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="fas fa-home w-5"></i>
                        <span>Home</span>
                    </a>
                    <a href="{{ route('cards.index') }}" 
                       class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('cards.index') ? 'active' : '' }}">
                        <i class="fas fa-store w-5"></i>
                        <span>Shop</span>
                    </a>
                    <a href="{{ route('ai.generator') }}" 
                       class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('ai.generator') ? 'active' : '' }}">
                        <i class="fas fa-wand-magic-sparkles w-5"></i>
                        <span>AI Generator</span>
                    </a>
                    <a href="{{ route('pricing') }}" 
                       class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('pricing*') ? 'active' : '' }}">
                        <i class="fas fa-crown w-5 text-yellow-500"></i>
                        <span>Pricing</span>
                    </a>
                </nav>
                
                <!-- Divider -->
                <hr class="my-6 border-gray-200">
                
                <!-- User Navigation -->
                <nav class="space-y-2">
                    @auth
                        <a href="{{ route('gifts.index') }}" 
                           class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('gifts.*') ? 'active' : '' }}">
                            <i class="fas fa-gift w-5"></i>
                            <span>My Gifts</span>
                        </a>
                        <a href="{{ route('events.index') }}" 
                           class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('events.*') ? 'active' : '' }}">
                            <i class="fas fa-calendar w-5"></i>
                            <span>Upcoming</span>
                        </a>
                        <a href="{{ route('inbox') }}" 
                           class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('inbox') ? 'active' : '' }}">
                            <i class="fas fa-inbox w-5"></i>
                            <span>Inbox</span>
                        </a>
                        <a href="{{ route('contacts.index') }}" 
                           class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('contacts.*') ? 'active' : '' }}">
                            <i class="fas fa-address-book w-5"></i>
                            <span>Contacts</span>
                        </a>
                        
                        <hr class="my-4 border-gray-200">
                        
                        <a href="{{ route('profile.show') }}" 
                           class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <i class="fas fa-user w-5"></i>
                            <span>Profile</span>
                        </a>
                        <a href="{{ route('billing.history') }}" 
                           class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('billing.*') ? 'active' : '' }}">
                            <i class="fas fa-credit-card w-5"></i>
                            <span>Billing</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition w-full text-left hover:bg-red-50 hover:text-red-600">
                                <i class="fas fa-sign-out-alt w-5"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" 
                           class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition">
                            <i class="fas fa-sign-in-alt w-5"></i>
                            <span>Login</span>
                        </a>
                        <a href="{{ route('register') }}" 
                           class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition">
                            <i class="fas fa-user-plus w-5"></i>
                            <span>Sign Up</span>
                        </a>
                    @endauth
                </nav>
            </div>
            
            <!-- User Profile -->
            @auth
                <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-gray-200 bg-white">
                    <a href="{{ route('profile.show') }}" class="flex items-center space-x-3 hover:bg-gray-50 p-2 rounded-lg -m-2 transition">
                        <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800 text-sm">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">View Profile</p>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                    </a>
                </div>
            @endauth
        </aside>
        
        <!-- Mobile Header -->
        <div class="lg:hidden fixed top-0 left-0 right-0 bg-white shadow-md z-50 px-4 py-3">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                        <i class="fas fa-gift text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-800">WishTales</span>
                </a>
                <button id="mobile-menu-btn" class="text-gray-600">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu Overlay -->
        <div id="mobile-menu" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
            <div class="w-64 bg-white h-full overflow-y-auto">
                <div class="p-6">
                    <button id="close-mobile-menu" class="absolute top-4 right-4 text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    
                    <!-- Mobile Navigation (same as sidebar) -->
                    <nav class="space-y-2 mt-8">
                        <a href="{{ route('home') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition">
                            <i class="fas fa-home w-5"></i>
                            <span>Home</span>
                        </a>
                        <a href="{{ route('cards.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition">
                            <i class="fas fa-store w-5"></i>
                            <span>Shop</span>
                        </a>
                        <a href="{{ route('ai.generator') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition">
                            <i class="fas fa-wand-magic-sparkles w-5"></i>
                            <span>AI Generator</span>
                        </a>
                        
                        <hr class="my-4">
                        
                        @auth
                            <a href="{{ route('gifts.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition">
                                <i class="fas fa-gift w-5"></i>
                                <span>My Gifts</span>
                            </a>
                            <a href="{{ route('events.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition">
                                <i class="fas fa-calendar w-5"></i>
                                <span>Upcoming</span>
                            </a>
                            <a href="{{ route('contacts.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition">
                                <i class="fas fa-address-book w-5"></i>
                                <span>Contacts</span>
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition w-full text-left">
                                    <i class="fas fa-sign-out-alt w-5"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition">
                                <i class="fas fa-sign-in-alt w-5"></i>
                                <span>Login</span>
                            </a>
                            <a href="{{ route('register') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition">
                                <i class="fas fa-user-plus w-5"></i>
                                <span>Sign Up</span>
                            </a>
                        @endauth
                    </nav>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 pt-16 lg:pt-0">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 m-4 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 m-4 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            
            @yield('content')
        </main>
    </div>
    
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
