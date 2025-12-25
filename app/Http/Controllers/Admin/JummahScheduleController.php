<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JummahSchedule;
use Illuminate\Http\Request;

class JummahScheduleController extends Controller
{
    public function index()
    {
        $schedules = JummahSchedule::orderByDesc('effective_from')->paginate(20);

        return view('admin.jummah.index', compact('schedules'));
    }

    public function create()
    {
        return view('admin.jummah.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'effective_from' => ['required', 'date'],
            'effective_till' => ['nullable', 'date', 'after_or_equal:effective_from'],
            'khutbah_time'   => ['nullable', 'date_format:H:i'],
            'salah_time'     => ['nullable', 'date_format:H:i'],
            'note'           => ['nullable', 'string', 'max:255'],
            'is_active'      => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        JummahSchedule::create($data);

        return redirect()->route('admin.jummah.index')->with('success', 'Jummah schedule added.');
    }

    public function edit(JummahSchedule $jummah)
    {
        return view('admin.jummah.edit', [
            'schedule' => $jummah,
        ]);
    }

    public function update(Request $request, JummahSchedule $jummah)
    {
        $data = $request->validate([
            'effective_from' => ['required', 'date'],
            'effective_till' => ['nullable', 'date', 'after_or_equal:effective_from'],
            'khutbah_time'   => ['nullable', 'date_format:H:i'],
            'salah_time'     => ['nullable', 'date_format:H:i'],
            'note'           => ['nullable', 'string', 'max:255'],
            'is_active'      => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        $jummah->update($data);

        return redirect()->route('admin.jummah.index')->with('success', 'Jummah schedule updated.');
    }

    public function destroy(JummahSchedule $jummah)
    {
        $jummah->delete();

        return redirect()->route('admin.jummah.index')->with('success', 'Jummah schedule deleted.');
    }
}
