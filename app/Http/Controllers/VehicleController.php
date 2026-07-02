<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $search = (string) $request->query('search');
        $status = (string) $request->query('status');

        try {
            $vehicles = Vehicle::when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('owner_name', 'like', "%{$search}%")
                        ->orWhere('vehicle_id', 'like', "%{$search}%")
                        ->orWhere('license_plate', 'like', "%{$search}%");
                });
            })->when($status, function ($query, $status) {
                $query->where('status', $status);
            })->latest()->paginate(10)->withQueryString();

            return Inertia::render('admin/vehicles/index', [
                'vehicles' => VehicleResource::collection($vehicles),
                'filters' => $request->only(['search', 'status']),
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching vehicles: '.$e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while loading vehicles.');
        }
    }

    public function create()
    {
        return Inertia::render('admin/vehicles/create');
    }

    public function store(StoreVehicleRequest $request)
    {
        try {
            $validated = $request->validated();

            $validated['vehicle_id'] = 'VEH-'.strtoupper(uniqid());
            $validated['status'] = 'active';

            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')->store('vehicles', 'public');
            }

            Vehicle::create($validated);

            return redirect()->route('admin.vehicles')->with('success', 'Vehicle registered successfully.');
        } catch (\Exception $e) {
            Log::error('Error registering vehicle: '.$e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while registering the vehicle.');
        }
    }

    public function show(Vehicle $vehicle)
    {
        try {
            return Inertia::render('admin/vehicles/show', [
                'vehicle' => new VehicleResource($vehicle),
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching vehicle: '.$e->getMessage());

            return redirect()->route('admin.vehicles')->with('error', 'An error occurred while loading the vehicle details.');
        }
    }

    public function edit(Vehicle $vehicle)
    {
        try {
            return Inertia::render('admin/vehicles/edit', [
                'vehicle' => new VehicleResource($vehicle),
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading vehicle edit form: '.$e->getMessage());

            return redirect()->route('admin.vehicles')->with('error', 'An error occurred while loading the vehicle edit form.');
        }
    }

    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        try {
            $validated = $request->validated();

            if ($request->hasFile('photo')) {
                if ($vehicle->photo) {
                    Storage::disk('public')->delete($vehicle->photo);
                }
                $validated['photo'] = $request->file('photo')->store('vehicles', 'public');
            }

            $vehicle->update($validated);

            return redirect()->route('admin.vehicles')->with('success', 'Vehicle updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating vehicle: '.$e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while updating the vehicle.');
        }
    }

    public function updateStatus(Request $request, Vehicle $vehicle)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|string|max:50',
            ]);

            $vehicle->update(['status' => $validated['status']]);

            return redirect()->back()->with('success', 'Vehicle status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating vehicle status: '.$e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while updating the vehicle status.');
        }
    }

    public function destroy(Vehicle $vehicle)
    {
        try {
            if ($vehicle->photo) {
                Storage::disk('public')->delete($vehicle->photo);
            }

            $vehicle->delete();

            return redirect()->route('admin.vehicles')->with('success', 'Vehicle deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting vehicle: '.$e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while deleting the vehicle.');
        }
    }
}
