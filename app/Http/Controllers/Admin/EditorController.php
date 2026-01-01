<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditorController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => ['required','image','max:5120'],
        ]);

        $path = $request->file('file')->store('editor', 'public');

        return response()->json([
            'location' => asset('storage/'.$path),
        ]);
    }
}
