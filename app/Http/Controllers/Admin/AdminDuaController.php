<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dua;
use App\Models\DuaCategory;
use Illuminate\Http\Request;

class AdminDuaController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $categoryId = $request->query('category');

        $categories = DuaCategory::orderBy('name')->get();

        $duas = Dua::with('category')
            ->when($q, function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                      ->orWhere('keywords', 'like', "%{$q}%");
            })
            ->when($categoryId, fn($query) => $query->where('dua_category_id', $categoryId))
            ->orderBy('id', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.duas.index', compact('duas', 'categories', 'q', 'categoryId'));
    }

    public function create()
    {
        $categories = DuaCategory::orderBy('name')->get();
        return view('admin.duas.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'dua_category_id' => ['required','exists:dua_categories,id'],
            'title' => ['required','string','max:255'],
            'arabic' => ['required','string'],
            'pronunciation' => ['nullable','string'],
            'translation' => ['required','string'],
            'keywords' => ['nullable','string','max:255'],
        ]);

        Dua::create($data);

        return redirect()->route('admin.duas.index')->with('success', 'Dua created.');
    }

    public function edit(Dua $dua)
    {
        $categories = DuaCategory::orderBy('name')->get();
        return view('admin.duas.edit', compact('dua', 'categories'));
    }

    public function update(Request $request, Dua $dua)
    {
        $data = $request->validate([
            'dua_category_id' => ['required','exists:dua_categories,id'],
            'title' => ['required','string','max:255'],
            'arabic' => ['required','string'],
            'pronunciation' => ['nullable','string'],
            'translation' => ['required','string'],
            'keywords' => ['nullable','string','max:255'],
        ]);

        $dua->update($data);

        return redirect()->route('admin.duas.index')->with('success', 'Dua updated.');
    }

    public function destroy(Dua $dua)
    {
        $dua->delete();
        return redirect()->route('admin.duas.index')->with('success', 'Dua deleted.');
    }
}
