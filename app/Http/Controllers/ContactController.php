<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::where('user_id', Auth::id())
            ->orderBy('is_favorite', 'desc')
            ->orderBy('name')
            ->paginate(20);
        
        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'birthday' => 'nullable|date',
            'anniversary' => 'nullable|date',
            'relationship' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
        ]);
        
        $contact = Contact::create([
            'user_id' => Auth::id(),
            ...$validated,
        ]);
        
        return redirect()->route('contacts.index')
            ->with('success', 'Contact added successfully!');
    }

    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);
        
        $gifts = $contact->gifts()->with('card')->latest()->get();
        
        return view('contacts.show', compact('contact', 'gifts'));
    }

    public function edit(Contact $contact)
    {
        $this->authorize('update', $contact);
        
        return view('contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $this->authorize('update', $contact);
        
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'birthday' => 'nullable|date',
            'anniversary' => 'nullable|date',
            'relationship' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
        ]);
        
        $contact->update($validated);
        
        return redirect()->route('contacts.index')
            ->with('success', 'Contact updated successfully!');
    }

    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);
        
        $contact->delete();
        
        return redirect()->route('contacts.index')
            ->with('success', 'Contact deleted successfully!');
    }

    public function toggleFavorite(Contact $contact)
    {
        $this->authorize('update', $contact);
        
        $contact->update(['is_favorite' => !$contact->is_favorite]);
        
        return back()->with('success', 'Contact updated!');
    }
}
