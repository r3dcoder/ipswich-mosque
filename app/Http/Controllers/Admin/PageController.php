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

        return redirect()->route('admin.pages.builder', $page)->with('success', 'Page created. Now build your page!');
    }

    public function edit(Page $page)
    {
        $page->load('blocks');
        return redirect()->route('admin.pages.builder', $page);
    }

    public function builder(Page $page)
    {
        $page->load('blocks');
        
        $blockTypes = $this->getBlockTypes();
        
        return view('admin.pages.builder', compact('page', 'blockTypes'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $this->validated($request);
        
        // Only update slug if it was provided in the request
        if (isset($validated['slug']) && $validated['slug']) {
            $validated['slug'] = Str::slug($validated['slug']);
        }
        // If slug is empty or not provided, keep the existing slug
        // The page already has a slug from creation

        $page->update($validated);

        // Return JSON for AJAX requests
        if ($request->expectsJson() || $request->header('Content-Type') === 'application/json') {
            return response()->json(['success' => true, 'message' => 'Page updated.']);
        }

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

    private function getBlockTypes(): array
    {
        return [
            [
                'id' => 'hero',
                'name' => 'Hero Section',
                'description' => 'Large banner with heading',
                'icon' => '🎯'
            ],
            [
                'id' => 'rich_text',
                'name' => 'Rich Text',
                'description' => 'Text content with editor',
                'icon' => '📝'
            ],
            [
                'id' => 'download',
                'name' => 'Download',
                'description' => 'File download button',
                'icon' => '📥'
            ],
            [
                'id' => 'image',
                'name' => 'Image',
                'description' => 'Single image with caption',
                'icon' => '🖼️'
            ],
            [
                'id' => 'repeater',
                'name' => 'List',
                'description' => 'Bulleted, numbered, or checklist items',
                'icon' => '📋'
            ],
        ];
    }
}
