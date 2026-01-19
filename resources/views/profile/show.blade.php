@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="p-6 lg:p-8 max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">My Profile</h1>
        <p class="text-gray-600 mt-1">Manage your account settings and preferences</p>
    </div>
    
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Cover -->
                <div class="h-24 bg-gradient-to-r from-primary to-secondary"></div>
                
                <!-- Avatar & Info -->
                <div class="relative px-6 pb-6">
                    <div class="-mt-12 mb-4">
                        <div class="w-24 h-24 rounded-full bg-white p-1 shadow-lg mx-auto">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                            @else
                                <div class="w-full h-full rounded-full bg-primary flex items-center justify-center text-white text-3xl font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                        <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                        
                        @if($user->phone)
                            <p class="text-gray-500 text-sm mt-1">
                                <i class="fas fa-phone mr-1"></i> {{ $user->phone }}
                            </p>
                        @endif
                        
                        <p class="text-gray-400 text-xs mt-2">
                            Member since {{ $user->created_at->format('F Y') }}
                        </p>
                    </div>
                    
                    <div class="mt-6">
                        <a href="{{ route('profile.edit') }}" 
                           class="block w-full bg-primary text-white text-center py-3 rounded-xl font-semibold hover:bg-primary-dark transition">
                            <i class="fas fa-edit mr-2"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mt-6">
                <h3 class="font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('profile.password') }}" 
                       class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition">
                        <span class="flex items-center text-gray-700">
                            <i class="fas fa-lock w-6 text-gray-400"></i>
                            Change Password
                        </span>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>
                    <a href="{{ route('profile.notifications') }}" 
                       class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition">
                        <span class="flex items-center text-gray-700">
                            <i class="fas fa-bell w-6 text-gray-400"></i>
                            Notifications
                        </span>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>
                    <a href="{{ route('contacts.index') }}" 
                       class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition">
                        <span class="flex items-center text-gray-700">
                            <i class="fas fa-address-book w-6 text-gray-400"></i>
                            My Contacts
                        </span>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>
                    
                    <hr class="my-2">
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="flex items-center justify-between p-3 rounded-xl hover:bg-red-50 transition w-full text-left">
                            <span class="flex items-center text-red-600">
                                <i class="fas fa-sign-out-alt w-6"></i>
                                Logout
                            </span>
                            <i class="fas fa-chevron-right text-red-400"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow p-4 text-center">
                    <div class="text-3xl font-bold text-primary">{{ $stats['cards_sent'] }}</div>
                    <div class="text-sm text-gray-500">Cards Sent</div>
                </div>
                <div class="bg-white rounded-xl shadow p-4 text-center">
                    <div class="text-3xl font-bold text-blue-500">{{ $stats['contacts'] }}</div>
                    <div class="text-sm text-gray-500">Contacts</div>
                </div>
                <div class="bg-white rounded-xl shadow p-4 text-center">
                    <div class="text-3xl font-bold text-green-500">{{ $stats['upcoming_events'] }}</div>
                    <div class="text-sm text-gray-500">Upcoming</div>
                </div>
                <div class="bg-white rounded-xl shadow p-4 text-center">
                    <div class="text-3xl font-bold text-yellow-500">{{ $stats['drafts'] }}</div>
                    <div class="text-sm text-gray-500">Drafts</div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
                    <a href="{{ route('gifts.index') }}" class="text-primary hover:text-primary-dark text-sm font-medium">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                @forelse($recentGifts as $gift)
                    <div class="flex items-center gap-4 py-4 border-b border-gray-100 last:border-0">
                        <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0">
                            <img src="{{ $gift->card->image }}" alt="{{ $gift->card->title }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-800 truncate">{{ $gift->card->title }}</p>
                            <p class="text-sm text-gray-500">
                                To: {{ $gift->recipient_name }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-medium
                                @if($gift->status === 'sent') bg-green-100 text-green-700
                                @elseif($gift->status === 'scheduled') bg-blue-100 text-blue-700
                                @elseif($gift->status === 'opened') bg-purple-100 text-purple-700
                                @else bg-gray-100 text-gray-700
                                @endif">
                                {{ ucfirst($gift->status) }}
                            </span>
                            <p class="text-xs text-gray-400 mt-1">{{ $gift->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-gift text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">No recent activity</p>
                        <a href="{{ route('cards.index') }}" class="text-primary hover:text-primary-dark text-sm mt-2 inline-block">
                            Send your first card <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                @endforelse
            </div>
            
            <!-- Danger Zone -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-red-100">
                <h3 class="text-lg font-semibold text-red-600 mb-2">Danger Zone</h3>
                <p class="text-gray-600 text-sm mb-4">Once you delete your account, there is no going back. Please be certain.</p>
                <button onclick="document.getElementById('delete-modal').classList.remove('hidden')"
                        class="bg-red-100 text-red-600 px-4 py-2 rounded-lg font-medium hover:bg-red-200 transition">
                    <i class="fas fa-trash mr-2"></i> Delete Account
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-2">Delete Account</h3>
        <p class="text-gray-600 mb-6">This action cannot be undone. Please enter your password to confirm.</p>
        
        <form action="{{ route('profile.destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" 
                       name="password" 
                       required
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>
            
            <div class="flex gap-3">
                <button type="button" 
                        onclick="document.getElementById('delete-modal').classList.add('hidden')"
                        class="flex-1 bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 bg-red-600 text-white py-3 rounded-xl font-semibold hover:bg-red-700 transition">
                    Delete Forever
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
