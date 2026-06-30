<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $vehicles = Vehicle::when($search, function ($query, $search) {
            $query->where(function($q) use ($search) {
                $q->where('driver_name', 'like', "%{$search}%")
                  ->orWhere('vehicle_id', 'like', "%{$search}%")
                  ->orWhere('license_plate', 'like', "%{$search}%");
            });
        })->when($status, function ($query, $status) {
            $query->where('status', $status);
        })->latest()->get();

        return Inertia::render('admin/vehicles/index', [
            'vehicles' => $vehicles,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/vehicles/create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner_name'    => 'required|string|max:255',
            'owner_type'    => 'required|string|max:100',
            'license_plate' => 'required|string|max:50',
            'make'          => 'nullable|string|max:100',
            'model'         => 'nullable|string|max:100',
            'color'         => 'nullable|string|max:50',
            'notes'         => 'nullable|string|max:500',
        ]);

        $validated['vehicle_id'] = 'VEH-' . strtoupper(uniqid());
        $validated['status'] = 'active';

        Vehicle::create($validated);

        return redirect()->route('admin.vehicles')->with('success', 'Vehicle registered successfully.');
    }

    public function show(Vehicle $vehicle)
    {
        return Inertia::render('admin/vehicles/show', [
            'vehicle' => $vehicle,
        ]);
    }

    public function edit(Vehicle $vehicle)
    {
        return Inertia::render('admin/vehicles/edit', [
            'vehicle' => $vehicle,
        ]);
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'owner_name'    => 'required|string|max:255',
            'owner_type'    => 'required|string|max:100',
            'license_plate' => 'required|string|max:50',
            'make'          => 'nullable|string|max:100',
            'model'         => 'nullable|string|max:100',
            'color'         => 'nullable|string|max:50',
            'notes'         => 'nullable|string|max:500',
            'status'        => 'required|string|max:50',
        ]);

        $vehicle->update($validated);

        return redirect()->route('admin.vehicles')->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('admin.vehicles')->with('success', 'Vehicle deleted successfully.');
    }
}
