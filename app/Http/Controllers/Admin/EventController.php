<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderByDesc('starts_at')->paginate(20);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'starts_at' => ['required','date'],
            'location' => ['nullable','string','max:255'],
            'description' => ['nullable','string'],
            'sort_order' => ['nullable','integer','min:1'],
            'is_active' => ['nullable','boolean'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 1;
        $data['is_active'] = $request->boolean('is_active');

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Event created.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'starts_at' => ['required','date'],
            'location' => ['nullable','string','max:255'],
            'description' => ['nullable','string'],
            'sort_order' => ['nullable','integer','min:1'],
            'is_active' => ['nullable','boolean'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 1;
        $data['is_active'] = $request->boolean('is_active');

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event updated.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted.');
    }
}
