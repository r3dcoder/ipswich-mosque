<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menuItems = MenuItem::with('children')
            ->parents()
            ->orderBy('sort_order')
            ->get();

        $allParents = MenuItem::parents()
            ->orderBy('sort_order')
            ->get();

        return view('admin.menu-items.index', compact('menuItems', 'allParents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $group = $request->get('group', 'services');
        
        $parents = MenuItem::where('menu_group', $group)
            ->parents()
            ->orderBy('sort_order')
            ->get();

        return view('admin.menu-items.create', compact('group', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'menu_group' => 'required|in:services,community,main',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
            'open_in_new_tab' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $menuItem = new MenuItem();
        $menuItem->title = $request->title;
        $menuItem->url = $request->url;
        $menuItem->parent_id = $request->parent_id;
        $menuItem->menu_group = $request->menu_group;
        $menuItem->sort_order = $request->sort_order ?? 0;
        $menuItem->is_active = $request->has('is_active');
        $menuItem->open_in_new_tab = $request->has('open_in_new_tab');
        $menuItem->save();

        return redirect()->route('admin.menu-items.index', ['group' => $request->menu_group])
            ->with('success', 'Menu item created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuItem $menuItem)
    {
        $parents = MenuItem::where('menu_group', $menuItem->menu_group)
            ->parents()
            ->where('id', '!=', $menuItem->id)
            ->orderBy('sort_order')
            ->get();

        return view('admin.menu-items.edit', compact('menuItem', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'menu_group' => 'required|in:services,community,main',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
            'open_in_new_tab' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $menuItem->title = $request->title;
        $menuItem->url = $request->url;
        $menuItem->parent_id = $request->parent_id;
        $menuItem->menu_group = $request->menu_group;
        $menuItem->sort_order = $request->sort_order ?? 0;
        $menuItem->is_active = $request->has('is_active');
        $menuItem->open_in_new_tab = $request->has('open_in_new_tab');
        $menuItem->save();

        return redirect()->route('admin.menu-items.index', ['group' => $request->menu_group])
            ->with('success', 'Menu item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuItem $menuItem)
    {
        $group = $menuItem->menu_group;
        $menuItem->delete();

        return redirect()->route('admin.menu-items.index', ['group' => $group])
            ->with('success', 'Menu item deleted successfully.');
    }

    /**
     * Reorder menu items.
     */
    public function reorder(Request $request)
    {
        $order = $request->input('order', []);
        
        foreach ($order as $index => $id) {
            MenuItem::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(MenuItem $menuItem)
    {
        $menuItem->is_active = !$menuItem->is_active;
        $menuItem->save();

        return redirect()->back()
            ->with('success', 'Menu item status updated successfully.');
    }
}