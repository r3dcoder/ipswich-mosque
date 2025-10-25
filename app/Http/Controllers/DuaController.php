<?php

namespace App\Http\Controllers;

use App\Models\Dua;
use App\Models\DuaCategory;
use Illuminate\Http\Request;

class DuaController extends Controller
{
    public function index()
    {
        $categories = DuaCategory::with('duas')->get();

        
        return view('duas.index', [
            'categories' => $categories,
            'selectedCategory' => null,
        ]);
    }

    public function show($id)
    {
        $dua = Dua::with('category')->findOrFail($id);

        // return view('duas.show', compact('dua'));

        // Get related duas from the same category (excluding current one)
        $relatedDuas = Dua::where('dua_category_id', $dua->dua_category_id)
            ->where('id', '!=', $dua->id)
            ->take(4)
            ->get();

        // Get all categories for buttons
        $allCategories = DuaCategory::all();

        return view('duas.show', compact('dua', 'relatedDuas', 'allCategories'));
    }
    public function category($id)
    {
        $category = DuaCategory::with('duas')->findOrFail($id);
        $categories = DuaCategory::all();
        
        return view('duas.index', [
            'categories' => $categories,
            'selectedCategory' => $category,
        ]);
    }

}
