<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
        $search = (string) $request->query('search');
        $status = (string) $request->query('status');

        $deliveries = Delivery::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('from_whom', 'like', "%{$search}%")
                    ->orWhere('delivery_id', 'like', "%{$search}%")
                    ->orWhere('for_whom', 'like', "%{$search}%");
            });
        })->when($status, function ($query, $status) {
            $query->where('status', $status);
        })->latest()->paginate(10)->withQueryString();

        return Inertia::render('admin/deliveries/index', [
            'deliveries' => $deliveries,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/deliveries/create');
    }

    public function history()
    {
        $deliveries = Delivery::latest('updated_at')->paginate(10)->withQueryString();

        return Inertia::render('admin/deliveries/history', [
            'deliveries' => $deliveries,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'from_whom' => 'required|string|max:255',
            'for_whom' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'package_details' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
        ]);

        $validated['delivery_id'] = 'DEL-'.strtoupper(uniqid());
        $validated['status'] = 'arrived';
        $validated['arrived_at'] = now();

        Delivery::create($validated);

        return redirect()->route('admin.deliveries')->with('success', 'Delivery registered successfully.');
    }

    public function show(Delivery $delivery)
    {
        return Inertia::render('admin/deliveries/show', [
            'delivery' => $delivery,
        ]);
    }

    public function edit(Delivery $delivery)
    {
        return Inertia::render('admin/deliveries/edit', [
            'delivery' => $delivery,
        ]);
    }

    public function update(Request $request, Delivery $delivery)
    {
        $validated = $request->validate([
            'from_whom' => 'required|string|max:255',
            'for_whom' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'package_details' => 'nullable|string|max:1000',
            'status' => 'required|string|in:arrived,received,collected',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Automatically set timestamps if status changes
        if ($validated['status'] === 'received' && ! $delivery->received_at) {
            $validated['received_at'] = now();
        } elseif ($validated['status'] === 'collected' && ! $delivery->collected_at) {
            $validated['collected_at'] = now();
        }

        $delivery->update($validated);

        return redirect()->route('admin.deliveries')->with('success', 'Delivery updated successfully.');
    }

    public function destroy(Delivery $delivery)
    {
        $delivery->delete();

        return redirect()->route('admin.deliveries')->with('success', 'Delivery deleted successfully.');
    }
}
