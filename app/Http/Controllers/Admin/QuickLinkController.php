<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuickLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuickLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quickLinks = QuickLink::orderBy('sort_order')->get();
        return view('admin.quick-links.index', compact('quickLinks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.quick-links.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|string|max:255',
            'icon_type' => 'required|in:svg,image',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg+xml|max:2048',
            'color' => 'required|string|max:50',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Validate that icon is provided when icon_type is svg
        if ($validated['icon_type'] === 'svg' && empty($validated['icon'])) {
            return back()->withErrors(['icon' => 'Please select an icon when using SVG type.'])->withInput();
        }

        // Validate that image is provided when icon_type is image
        if ($validated['icon_type'] === 'image' && !$request->hasFile('image')) {
            return back()->withErrors(['image' => 'Please upload an image when using Custom Image Upload type.'])->withInput();
        }

        $validated['sort_order'] = $validated['sort_order'] ?? QuickLink::max('sort_order') + 1;
        $validated['is_active'] = $request->has('is_active');

        // Handle image upload if icon_type is 'image'
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('quick-links', 'public');
        }

        QuickLink::create($validated);

        return redirect()->route('admin.quick-links.index')
            ->with('success', 'Quick link created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuickLink $quickLink)
    {
        return view('admin.quick-links.edit', compact('quickLink'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuickLink $quickLink)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|string|max:255',
            'icon' => 'required|string|max:100',
            'color' => 'required|string|max:50',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $quickLink->update($validated);

        return redirect()->route('admin.quick-links.index')
            ->with('success', 'Quick link updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuickLink $quickLink)
    {
        $quickLink->delete();

        return redirect()->route('admin.quick-links.index')
            ->with('success', 'Quick link deleted successfully.');
    }

    /**
     * Reorder quick links
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:quick_links,id',
        ]);

        foreach ($validated['order'] as $index => $id) {
            QuickLink::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}