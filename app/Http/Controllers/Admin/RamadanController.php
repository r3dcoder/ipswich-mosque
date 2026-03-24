<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RamadanSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RamadanController extends Controller
{
    public function index()
    {
        $ramadans = RamadanSetting::withCount(['dailyTimes', 'events'])
            ->orderBy('year', 'desc')
            ->paginate(10);

        return view('admin.ramadan.index', compact('ramadans'));
    }

    public function create()
    {
        $ramadan = new RamadanSetting();   // empty model instance
        return view('admin.ramadan.create', compact('ramadan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year'             => ['required', 'integer', 'min:2000', Rule::unique('ramadan_settings')],
            'start_date'       => 'nullable|date',
            'title'            => 'required|string|max:255',
            'fitrana'            => 'required|string|max:255',
            'esha_and_taraweeh'            => 'required|string|max:255',
            'eid_jamat'            => 'required|string|max:255',
            'hero_message'     => 'nullable|string|max:1000',
            'countdown_target' => 'nullable|date_format:Y-m-d\TH:i',
            'timetable_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        if ($request->hasFile('timetable_image')) {
            $path = $request->file('timetable_image')->store('ramadan-timetables', 'public');
            $validated['timetable_image'] = $path;
        }

        RamadanSetting::create($validated);

        return redirect()->route('admin.ramadan.index')
            ->with('success', 'Ramadan year created successfully.');
    }

    public function show(RamadanSetting $ramadan)
    {
        $ramadan->load([
            'dailyTimes' => fn($q) => $q->orderBy('day'),
            'events'     => fn($q) => $q->orderBy('event_date'),
        ]);

        return view('admin.ramadan.show', compact('ramadan'));
    }

    public function edit(RamadanSetting $ramadan)
    {
        return view('admin.ramadan.edit', compact('ramadan'));
    }

    public function update(Request $request, RamadanSetting $ramadan)
    {
        $validated = $request->validate([
            'year'             => ['required', 'integer', 'min:2000', Rule::unique('ramadan_settings')->ignore($ramadan->id)],
            'start_date'       => 'nullable|date',
            'title'            => 'required|string|max:255',
            'fitrana'            => 'required|string|max:255',
            'esha_and_taraweeh'            => 'required|string|max:255',
            'eid_jamat'            => 'required|string|max:255',
            'hero_message'     => 'nullable|string|max:1000',
            'countdown_target' => 'nullable|date_format:Y-m-d\TH:i',
            'timetable_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if ($request->hasFile('timetable_image')) {
            if ($ramadan->timetable_image) {
                Storage::disk('public')->delete($ramadan->timetable_image);
            }
            $path = $request->file('timetable_image')->store('ramadan-timetables', 'public');
            $validated['timetable_image'] = $path;
        }

        $ramadan->update($validated);

        return redirect()->route('admin.ramadan.index')
            ->with('success', 'Ramadan settings updated successfully.');
    }

    public function destroy(RamadanSetting $ramadan)
    {
        if ($ramadan->timetable_image) {
            Storage::disk('public')->delete($ramadan->timetable_image);
        }

        $ramadan->delete();

        return redirect()->route('admin.ramadan.index')
            ->with('success', 'Ramadan year and related data deleted.');
    }
}