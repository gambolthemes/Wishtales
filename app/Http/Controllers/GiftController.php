<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use App\Models\Card;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\GiftCardMail;

class GiftController extends Controller
{
    public function index()
    {
        $gifts = Gift::with(['card', 'contact'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(20);
        
        return view('gifts.index', compact('gifts'));
    }

    public function create(Card $card)
    {
        $contacts = Contact::where('user_id', Auth::id())->get();
        
        return view('gifts.create', compact('card', 'contacts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'card_id' => 'required|exists:cards,id',
            'recipient_name' => 'required|string|max:100',
            'recipient_email' => 'required|email|max:255',
            'message' => 'nullable|string|max:1000',
            'sender_name' => 'required|string|max:100',
            'envelope_style' => 'nullable|string',
            'scheduled_at' => 'nullable|date|after:now',
            'save_contact' => 'nullable|boolean',
        ]);
        
        $gift = Gift::create([
            'user_id' => Auth::id(),
            'card_id' => $validated['card_id'],
            'recipient_name' => $validated['recipient_name'],
            'recipient_email' => $validated['recipient_email'],
            'message' => $validated['message'] ?? '',
            'sender_name' => $validated['sender_name'],
            'envelope_style' => $validated['envelope_style'] ?? 'default',
            'status' => $validated['scheduled_at'] ? 'scheduled' : 'draft',
            'scheduled_at' => $validated['scheduled_at'] ?? null,
            'customization' => $request->only(['font', 'color', 'alignment']),
        ]);
        
        // Save contact if requested
        if ($request->save_contact) {
            Contact::firstOrCreate(
                ['user_id' => Auth::id(), 'email' => $validated['recipient_email']],
                ['name' => $validated['recipient_name']]
            );
        }
        
        // Increment card uses
        $gift->card->incrementUses();
        
        return redirect()->route('gifts.preview', $gift)
            ->with('success', 'Gift card created successfully!');
    }

    public function preview(Gift $gift)
    {
        $this->authorize('view', $gift);
        
        return view('gifts.preview', compact('gift'));
    }

    public function send(Gift $gift)
    {
        $this->authorize('update', $gift);
        
        // Send email
        // Mail::to($gift->recipient_email)->send(new GiftCardMail($gift));
        
        $gift->markAsSent();
        
        return redirect()->route('gifts.index')
            ->with('success', 'Gift card sent successfully!');
    }

    public function show(Gift $gift)
    {
        // Check if the user owns this gift
        if ($gift->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('gifts.show', compact('gift'));
    }

    public function destroy(Gift $gift)
    {
        // Check if the user owns this gift
        if ($gift->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $gift->delete();
        
        return redirect()->route('gifts.index')
            ->with('success', 'Gift deleted successfully!');
    }

    // Public view for recipients
    public function view($trackingCode)
    {
        $gift = Gift::where('tracking_code', $trackingCode)->firstOrFail();
        
        if ($gift->status === 'sent') {
            $gift->markAsOpened();
        }
        
        return view('gifts.view', compact('gift'));
    }
}
