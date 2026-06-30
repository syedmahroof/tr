<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $visitors = Visitor::when($search, function ($query, $search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('visitor_id', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        })->when($status, function ($query, $status) {
            $query->where('status', $status);
        })->latest()->get();

        return Inertia::render('admin/visitors/index', [
            'visitors' => $visitors,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/visitors/create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'email'         => 'nullable|email|max:255',
            'company'       => 'nullable|string|max:255',
            'category'      => 'required|string|max:100',
            'host_employee' => 'required|string|max:255',
            'purpose'       => 'required|string|max:500',
        ]);

        $validated['visitor_id'] = 'VIS-' . strtoupper(uniqid());

        Visitor::create($validated);

        return redirect()->route('admin.visitors')->with('success', 'Visitor registered successfully.');
    }

    public function show(Visitor $visitor)
    {
        return Inertia::render('admin/visitors/show', [
            'visitor' => $visitor,
        ]);
    }

    public function edit(Visitor $visitor)
    {
        return Inertia::render('admin/visitors/edit', [
            'visitor' => $visitor,
        ]);
    }

    public function update(Request $request, Visitor $visitor)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'email'         => 'nullable|email|max:255',
            'company'       => 'nullable|string|max:255',
            'category'      => 'required|string|max:100',
            'host_employee' => 'required|string|max:255',
            'purpose'       => 'required|string|max:500',
        ]);

        $visitor->update($validated);

        return redirect()->route('admin.visitors')->with('success', 'Visitor updated successfully.');
    }

    public function destroy(Visitor $visitor)
    {
        $visitor->delete();

        return redirect()->route('admin.visitors')->with('success', 'Visitor deleted successfully.');
    }
}