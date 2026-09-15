<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmergencyContact;
use Illuminate\Http\Request;

class EmergencyContactController extends Controller
{
    /**
     * Display a listing of emergency contacts.
     */
    public function index()
    {
        $contacts = EmergencyContact::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.emergency-contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new contact.
     */
    public function create()
    {
        return view('admin.emergency-contacts.create');
    }

    /**
     * Store a newly created contact.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'role_in_committee' => 'nullable|string|max:255',
            'phone_number'      => 'required|string|max:50',
            'sort_order'        => 'nullable|integer|min:0',
            'is_visible'        => 'nullable|boolean',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_visible'] = $request->boolean('is_visible', true);

        EmergencyContact::create($validated);

        return redirect()
            ->route('admin.emergency-contacts.index')
            ->with('success', 'Emergency contact added successfully.');
    }

    /**
     * Show the form for editing the specified contact.
     */
    public function edit(EmergencyContact $emergencyContact)
    {
        return view('admin.emergency-contacts.edit', compact('emergencyContact'));
    }

    /**
     * Update the specified contact.
     */
    public function update(Request $request, EmergencyContact $emergencyContact)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'role_in_committee' => 'nullable|string|max:255',
            'phone_number'      => 'required|string|max:50',
            'sort_order'        => 'nullable|integer|min:0',
            'is_visible'        => 'nullable|boolean',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_visible'] = $request->boolean('is_visible', true);

        $emergencyContact->update($validated);

        return redirect()
            ->route('admin.emergency-contacts.index')
            ->with('success', 'Emergency contact updated successfully.');
    }

    /**
     * Remove the specified contact.
     */
    public function destroy(EmergencyContact $emergencyContact)
    {
        $emergencyContact->delete();

        return redirect()
            ->route('admin.emergency-contacts.index')
            ->with('success', 'Emergency contact deleted successfully.');
    }

    /**
     * Toggle the visible status.
     */
    public function toggleVisible(EmergencyContact $emergencyContact)
    {
        $emergencyContact->update(['is_visible' => !$emergencyContact->is_visible]);

        return back()->with('success', 'Visibility updated successfully.');
    }
}
