<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderByDesc('id')->paginate(20);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if (!$data['slug']) {
            $data['slug'] = Str::slug($data['title']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        $page = Page::create($data);

        return redirect()->route('admin.pages.edit', $page)->with('success', 'Page created.');
    }

    public function edit(Page $page)
    {
        $page->load('blocks');
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $this->validated($request);

        if ($data['slug']) {
            $data['slug'] = Str::slug($data['slug']);
        } else {
            $data['slug'] = Str::slug($data['title']);
        }

        $page->update($data);

        return back()->with('success', 'Page updated.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required','string','max:255'],
            'slug' => ['nullable','string','max:255'],
            'excerpt' => ['nullable','string'],
            'meta_title' => ['nullable','string','max:255'],
            'meta_description' => ['nullable','string'],
            'is_published' => ['nullable','boolean'],
        ]) + [
            'is_published' => $request->boolean('is_published'),
        ];
    }
}
