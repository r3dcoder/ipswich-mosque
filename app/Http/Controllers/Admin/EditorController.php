<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditorController extends Controller
{
    /**
     * Upload an image used by the page builder (rich text / column / image-text blocks).
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp,svg', 'max:5120'],
        ]);

        $path = $request->file('file')->store('pages', 'public');

        return response()->json([
            'location' => asset('storage/' . $path),
            'url' => asset('storage/' . $path),
            'path' => $path,
        ]);
    }
}

