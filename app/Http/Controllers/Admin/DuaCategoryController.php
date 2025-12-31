<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DuaCategory;
use Illuminate\Http\Request;

class DuaCategoryController extends Controller
{
    public function index()
    {
        $categories = DuaCategory::withCount('duas')->orderBy('name')->paginate(20);
        return view('admin.dua_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.dua_categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'category' => ['required','string','max:255'],
        ]);

        DuaCategory::create($data);

        return redirect()->route('admin.dua_categories.index')->with('success', 'Category created.');
    }

    public function edit(DuaCategory $duaCategory)
    {
        return view('admin.dua_categories.edit', compact('duaCategory'));
    }

    public function update(Request $request, DuaCategory $duaCategory)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'category' => ['nullable','string','max:255'],
        ]);

        $duaCategory->update($data);

        return redirect()->route('admin.dua_categories.index')->with('success', 'Category updated.');
    }

    public function destroy(DuaCategory $duaCategory)
    {
        // Your FK has cascadeOnDelete so duas will be removed automatically.
        $duaCategory->delete();

        return redirect()->route('admin.dua_categories.index')->with('success', 'Category deleted.');
    }
}
