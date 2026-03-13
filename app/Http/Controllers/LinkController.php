<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    public function index()
    {
        $links = Auth::user()->links()->orderBy('order')->get();
        return view('links.index', compact('links'));
    }

    public function store(Request $request)
    {
        // Enforce plan link limit
        if (Auth::user()->hasReachedLinkLimit()) {
            return redirect()->route('links.index')->with('error', 'Link limitinize ulaştınız. Daha fazla link eklemek için planınızı yükseltin.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'password' => 'nullable|string|max:255',
        ]);

        $maxOrder = Auth::user()->links()->max('order') ?? 0;

        Auth::user()->links()->create([
            'title' => $validated['title'],
            'url' => $validated['url'],
            'starts_at' => $validated['starts_at'],
            'expires_at' => $validated['expires_at'],
            'password' => $validated['password'],
            'order' => $maxOrder + 1,
            'is_active' => true,
        ]);

        return redirect()->route('links.index')->with('success', 'Link added successfully.');
    }

    public function update(Request $request, Link $link)
    {
        Auth::user()->links()->findOrFail($link->id); // Yetki kontrolü

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'is_active' => 'boolean',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'password' => 'nullable|string|max:255',
        ]);

        if (isset($validated['is_active'])) {
             $link->is_active = $request->has('is_active');
        } else {
             $link->update($validated);
        }

        return redirect()->route('links.index')->with('success', 'Link updated successfully.');
    }

    public function toggle(Request $request, Link $link)
    {
        Auth::user()->links()->findOrFail($link->id);

        $link->update(['is_active' => !$link->is_active]);

        return response()->json(['success' => true, 'is_active' => $link->is_active]);
    }

    public function destroy(Link $link)
    {
        Auth::user()->links()->findOrFail($link->id);
        $link->delete();

        return redirect()->route('links.index')->with('success', 'Link deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $orderedIds = $request->input('ordered_ids', []);

        foreach ($orderedIds as $index => $id) {
            Auth::user()->links()->where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
