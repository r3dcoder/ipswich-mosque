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
        return view('duas.index', compact('categories'));
    }

    public function show($id)
    {
        $dua = Dua::with('category')->findOrFail($id);
        return view('duas.show', compact('dua'));
    }
}
