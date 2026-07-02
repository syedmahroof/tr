<?php

namespace App\Http\Controllers;

use App\Models\Watchlist;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WatchlistController extends Controller
{
    public function index(Request $request)
    {
        $search = (string) $request->query('search');
        $status = (string) $request->query('status');

        $watchlists = Watchlist::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('reason', 'like', "%{$search}%");
        })
            ->latest()
            ->get();

        return Inertia::render('admin/security/index', [
            'watchlists' => $watchlists,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/security/create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'reason' => 'required|string|max:1000',
            'status' => 'required|string|in:active,inactive',
        ]);

        $validated['added_by'] = 'Admin'; // Could be auth()->user()->name

        Watchlist::create($validated);

        return redirect()->route('admin.security')->with('success', 'Added to watchlist successfully.');
    }

    public function edit(Watchlist $watchlist)
    {
        return Inertia::render('admin/security/edit', [
            'watchlist' => $watchlist,
        ]);
    }

    public function update(Request $request, Watchlist $watchlist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'reason' => 'required|string|max:1000',
            'status' => 'required|string|in:active,inactive',
        ]);

        $watchlist->update($validated);

        return redirect()->route('admin.security')->with('success', 'Watchlist updated successfully.');
    }

    public function destroy(Watchlist $watchlist)
    {
        $watchlist->delete();

        return redirect()->route('admin.security')->with('success', 'Removed from watchlist successfully.');
    }
}
