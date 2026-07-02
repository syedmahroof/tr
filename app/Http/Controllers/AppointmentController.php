<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $search = (string) $request->query('search');
        $status = (string) $request->query('status');

        $appointments = Appointment::with('host')
            ->when($search, function ($query, $search) {
                $query->where('visitor_name', 'like', "%{$search}%")
                    ->orWhere('visitor_email', 'like', "%{$search}%")
                    ->orWhere('purpose', 'like', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy('date_time', 'asc')
            ->paginate(10)->withQueryString();

        return Inertia::render('admin/appointments/index', [
            'appointments' => $appointments,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    public function create()
    {
        $employees = User::select('id', 'name', 'department')->get();

        return Inertia::render('admin/appointments/create', [
            'employees' => $employees,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'visitor_name' => 'required|string|max:255',
            'visitor_email' => 'nullable|email|max:255',
            'visitor_company' => 'nullable|string|max:255',
            'host_id' => 'required|exists:users,id',
            'date_time' => 'required|date',
            'purpose' => 'required|string|max:500',
        ]);

        $validated['status'] = 'scheduled';

        Appointment::create($validated);

        return redirect()->route('admin.appointments')->with('success', 'Appointment scheduled successfully.');
    }

    public function edit(Appointment $appointment)
    {
        $employees = User::select('id', 'name', 'department')->get();

        return Inertia::render('admin/appointments/edit', [
            'appointment' => $appointment,
            'employees' => $employees,
        ]);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'visitor_name' => 'required|string|max:255',
            'visitor_email' => 'nullable|email|max:255',
            'visitor_company' => 'nullable|string|max:255',
            'host_id' => 'required|exists:users,id',
            'date_time' => 'required|date',
            'purpose' => 'required|string|max:500',
            'status' => 'required|string|in:scheduled,completed,cancelled',
        ]);

        $appointment->update($validated);

        return redirect()->route('admin.appointments')->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments')->with('success', 'Appointment deleted successfully.');
    }
}
