<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the user's profile.
     */
    public function show()
    {
        $user = Auth::user();
        
        // Get user stats
        $stats = [
            'cards_sent' => $user->gifts()->where('status', 'sent')->count(),
            'contacts' => $user->contacts()->count(),
            'upcoming_events' => $user->upcomingEvents()->where('event_date', '>=', now())->count(),
            'drafts' => $user->gifts()->where('status', 'draft')->count(),
        ];
        
        // Recent activity
        $recentGifts = $user->gifts()
            ->with('card', 'contact')
            ->latest()
            ->take(5)
            ->get();
        
        return view('profile.show', compact('user', 'stats', 'recentGifts'));
    }

    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'birthday' => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }
        
        $user->update($validated);
        
        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Show the password change form.
     */
    public function showChangePassword()
    {
        return view('profile.password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return redirect()->route('profile.show')
            ->with('success', 'Password changed successfully!');
    }

    /**
     * Show notification settings.
     */
    public function notifications()
    {
        $user = Auth::user();
        return view('profile.notifications', compact('user'));
    }

    /**
     * Update notification settings.
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        
        $settings = [
            'email_gift_opened' => $request->boolean('email_gift_opened'),
            'email_reminders' => $request->boolean('email_reminders'),
            'email_newsletter' => $request->boolean('email_newsletter'),
        ];
        
        $user->update(['notification_settings' => $settings]);
        
        return redirect()->route('profile.notifications')
            ->with('success', 'Notification settings updated!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);
        
        $user = Auth::user();
        
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password is incorrect.']);
        }
        
        Auth::logout();
        $user->delete();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')
            ->with('success', 'Your account has been deleted.');
    }
}
