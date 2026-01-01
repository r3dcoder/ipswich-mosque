<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PublicPageController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::where('slug', $slug)
            ->where('is_published', true)
            ->with('blocks')
            ->firstOrFail();

        return view('pages.dynamic', compact('page'));
    }
}
