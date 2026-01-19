@extends('layouts.app')

@section('title', 'My Contacts')

@section('content')
<div class="p-6 lg:p-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Contacts</h1>
            <p class="text-gray-600 mt-1">Manage your recipients and never miss an occasion</p>
        </div>
        <a href="{{ route('contacts.create') }}" class="bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:bg-primary-dark transition">
            <i class="fas fa-plus mr-2"></i> Add Contact
        </a>
    </div>
    
    <!-- Search -->
    <div class="bg-white rounded-xl shadow-md p-4 mb-6">
        <div class="relative">
            <input type="text" 
                   id="search-contacts"
                   placeholder="Search contacts..." 
                   class="w-full pl-10 pr-4 py-2 bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-primary">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
    </div>
    
    <!-- Contacts Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4" id="contacts-grid">
        @forelse($contacts as $contact)
            <div class="contact-card bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition" data-name="{{ strtolower($contact->name) }}">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white text-xl font-bold">
                            {{ substr($contact->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $contact->name }}</h3>
                            @if($contact->relationship)
                                <span class="text-sm text-gray-500">{{ $contact->relationship }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <form action="{{ route('contacts.toggle-favorite', $contact) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xl {{ $contact->is_favorite ? 'text-yellow-400' : 'text-gray-300 hover:text-yellow-400' }} transition">
                            <i class="fas fa-star"></i>
                        </button>
                    </form>
                </div>
                
                <div class="space-y-2 text-sm mb-4">
                    @if($contact->email)
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-envelope w-5 text-gray-400"></i>
                            <span class="truncate">{{ $contact->email }}</span>
                        </div>
                    @endif
                    @if($contact->phone)
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-phone w-5 text-gray-400"></i>
                            <span>{{ $contact->phone }}</span>
                        </div>
                    @endif
                    @if($contact->birthday)
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-birthday-cake w-5 text-gray-400"></i>
                            <span>{{ $contact->birthday->format('M d') }}</span>
                        </div>
                    @endif
                    @if($contact->anniversary)
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-heart w-5 text-gray-400"></i>
                            <span>{{ $contact->anniversary->format('M d') }}</span>
                        </div>
                    @endif
                </div>
                
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <div class="flex space-x-2">
                        <a href="{{ route('contacts.edit', $contact) }}" class="text-gray-400 hover:text-primary transition" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="inline" onsubmit="return confirm('Delete this contact?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-500 transition" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    
                    <a href="{{ route('cards.index') }}?for={{ $contact->id }}" class="text-primary hover:text-primary-dark font-medium text-sm">
                        Send Card <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <i class="fas fa-address-book text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No contacts yet</h3>
                <p class="text-gray-500 mb-6">Add your first contact to easily send cards!</p>
                <a href="{{ route('contacts.create') }}" class="inline-block bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:bg-primary-dark transition">
                    Add Contact
                </a>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div class="mt-6">
        {{ $contacts->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Search functionality
    const searchInput = document.getElementById('search-contacts');
    const contactCards = document.querySelectorAll('.contact-card');
    
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        
        contactCards.forEach(card => {
            const name = card.dataset.name;
            if (name.includes(query)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endpush
