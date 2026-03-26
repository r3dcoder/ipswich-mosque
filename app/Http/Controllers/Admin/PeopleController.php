<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PeopleController extends Controller
{
    public function index()
    {
        $people = People::orderBy('name')->paginate(10);
        return view('admin.people.index', compact('people'));
    }

    public function create()
    {
        return view('admin.people.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|url',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'role' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        People::create($request->all());

        return redirect()->route('admin.people.index')
            ->with('success', 'Person created successfully.');
    }

    public function edit(People $person)
    {
        return view('admin.people.edit', compact('person'));
    }

    public function update(Request $request, People $person)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|url',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'role' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $person->update($request->all());

        return redirect()->route('admin.people.index')
            ->with('success', 'Person updated successfully.');
    }

    public function destroy(People $person)
    {
        $person->delete();

        return redirect()->route('admin.people.index')
            ->with('success', 'Person deleted successfully.');
    }
}