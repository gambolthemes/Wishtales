<?php

namespace App\Http\Controllers;

use App\Models\UpcomingEvent;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpcomingEventController extends Controller
{
    public function index()
    {
        $events = UpcomingEvent::with('contact')
            ->where('user_id', Auth::id())
            ->upcoming()
            ->paginate(20);
        
        return view('events.index', compact('events'));
    }

    public function create()
    {
        $contacts = Contact::where('user_id', Auth::id())->get();
        
        return view('events.create', compact('contacts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'event_date' => 'required|date',
            'event_type' => 'required|in:birthday,anniversary,holiday,custom',
            'contact_id' => 'nullable|exists:contacts,id',
            'is_recurring' => 'nullable|boolean',
            'remind_days_before' => 'nullable|integer|min:1|max:30',
        ]);
        
        UpcomingEvent::create([
            'user_id' => Auth::id(),
            ...$validated,
            'is_recurring' => $request->boolean('is_recurring'),
            'remind_days_before' => $validated['remind_days_before'] ?? 3,
        ]);
        
        return redirect()->route('events.index')
            ->with('success', 'Event created successfully!');
    }

    public function edit(UpcomingEvent $event)
    {
        $this->authorize('update', $event);
        
        $contacts = Contact::where('user_id', Auth::id())->get();
        
        return view('events.edit', compact('event', 'contacts'));
    }

    public function update(Request $request, UpcomingEvent $event)
    {
        $this->authorize('update', $event);
        
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'event_date' => 'required|date',
            'event_type' => 'required|in:birthday,anniversary,holiday,custom',
            'contact_id' => 'nullable|exists:contacts,id',
            'is_recurring' => 'nullable|boolean',
            'remind_days_before' => 'nullable|integer|min:1|max:30',
        ]);
        
        $event->update([
            ...$validated,
            'is_recurring' => $request->boolean('is_recurring'),
        ]);
        
        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully!');
    }

    public function destroy(UpcomingEvent $event)
    {
        $this->authorize('delete', $event);
        
        $event->delete();
        
        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully!');
    }
}
