<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Vehicle;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = (string) $request->query('q');

        if (! $query) {
            return Inertia::render('admin/search/index', [
                'query' => '',
                'results' => ['visitors' => [], 'vehicles' => [], 'deliveries' => []],
            ]);
        }

        // Smart exact ID match check
        $upperQuery = strtoupper($query);
        if (str_starts_with($upperQuery, 'VIS-')) {
            $visitor = Visitor::where('visitor_id', $upperQuery)->first();
            if ($visitor) {
                return redirect()->route('admin.visitors.show', $visitor);
            }
        }
        if (str_starts_with($upperQuery, 'VEH-')) {
            $vehicle = Vehicle::where('vehicle_id', $upperQuery)->first();
            if ($vehicle) {
                return redirect()->route('admin.vehicles.show', $vehicle);
            }
        }
        if (str_starts_with($upperQuery, 'DEL-')) {
            $delivery = Delivery::where('delivery_id', $upperQuery)->first();
            if ($delivery) {
                return redirect()->route('admin.deliveries.show', $delivery);
            }
        }

        // Global broad search
        $visitors = Visitor::where(function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
                ->orWhere('visitor_id', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->orWhere('company', 'like', "%{$query}%");
        })->limit(10)->get();

        $vehicles = Vehicle::where(function ($q) use ($query) {
            $q->where('owner_name', 'like', "%{$query}%")
                ->orWhere('vehicle_id', 'like', "%{$query}%")
                ->orWhere('license_plate', 'like', "%{$query}%");
        })->limit(10)->get();

        $deliveries = Delivery::where(function ($q) use ($query) {
            $q->where('from_whom', 'like', "%{$query}%")
                ->orWhere('delivery_id', 'like', "%{$query}%")
                ->orWhere('for_whom', 'like', "%{$query}%")
                ->orWhere('company', 'like', "%{$query}%");
        })->limit(10)->get();

        return Inertia::render('admin/search/index', [
            'query' => $query,
            'results' => [
                'visitors' => $visitors,
                'vehicles' => $vehicles,
                'deliveries' => $deliveries,
            ],
        ]);
    }
}
