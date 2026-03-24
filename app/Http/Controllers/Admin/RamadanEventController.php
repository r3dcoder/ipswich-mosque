<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RamadanEvent;
use App\Models\RamadanSetting;
use Illuminate\Http\Request;

class RamadanEventController extends Controller
{
    public function index(RamadanSetting $ramadan)
    {
        $events = $ramadan->events()->orderBy('event_date')->get();
        return view('admin.ramadan.events.index', compact('ramadan', 'events'));
    }

    public function create(RamadanSetting $ramadan)
    {
        return view('admin.ramadan.events.create', compact('ramadan'));
    }

    public function store(Request $request, RamadanSetting $ramadan)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date'  => 'required|date',
            'start_time'  => 'nullable|date_format:H:i',
            'end_time'    => 'nullable|date_format:H:i',
            'location'    => 'nullable|string|max:255',
        ]);

        $ramadan->events()->create($validated);

        return redirect()
            ->route('admin.ramadan.events.index', $ramadan)
            ->with('success', 'Event added successfully!');
    }

    public function edit(RamadanSetting $ramadan, RamadanEvent $event)
    {
        return view('admin.ramadan.events.edit', compact('ramadan', 'event'));
    }

    public function update(Request $request, RamadanSetting $ramadan, RamadanEvent $event)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date'  => 'required|date',
            'start_time'  => 'nullable|date_format:H:i',
            'end_time'    => 'nullable|date_format:H:i',
            'location'    => 'nullable|string|max:255',
        ]);

        $event->update($validated);

        return redirect()
            ->route('admin.ramadan.events.index', $ramadan)
            ->with('success', 'Event updated successfully!');
    }

    public function destroy(RamadanSetting $ramadan, RamadanEvent $event)
    {
        $event->delete();

        return redirect()
            ->route('admin.ramadan.events.index', $ramadan)
            ->with('success', 'Event deleted successfully!');
    }
}