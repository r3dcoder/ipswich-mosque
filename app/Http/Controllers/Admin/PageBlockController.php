<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageBlockController extends Controller
{
    /**
     * Store a new block
     */
    public function store(Request $request, Page $page)
    {
        $request->validate([
            'type' => ['required', 'string', 'in:hero,rich_text,repeater,image,download'],
        ]);

        $type = $request->input('type');
        $nextOrder = (int) ($page->blocks()->max('sort_order') ?? 0) + 1;

        $block = $page->blocks()->create([
            'type' => $type,
            'sort_order' => $nextOrder,
            'data' => $this->defaultDataFor($type),
        ]);

        return redirect()->back()->with('success', 'Block added.');
    }

    /**
     * Show the editor for a block
     */
    public function edit(Page $page, PageBlock $block)
    {
        abort_unless($block->page_id === $page->id, 404);

        $view = 'admin.pages.blocks.editor.' . $block->type;
        
        if (!view()->exists($view)) {
            return response('Editor not found for block type: ' . $block->type, 404);
        }

        $data = $block->data ?? [];
        return view($view, compact('page', 'block', 'data'));
    }

    /**
     * Update a block
     */
    public function update(Request $request, Page $page, PageBlock $block)
    {
        abort_unless($block->page_id === $page->id, 404);

        $data = $request->input('data', []);

        // For repeater type: filter empty items and reindex
        if ($block->type === 'repeater' && isset($data['items'])) {
            $data['items'] = array_values(array_filter($data['items'], function($v) {
                return trim($v) !== '';
            }));
        }

        $block->update(['data' => $data]);

        return response()->json(['success' => true]);
    }

    /**
     * Get preview HTML for a block
     */
    public function preview(Page $page, PageBlock $block)
    {
        abort_unless($block->page_id === $page->id, 404);

        $view = 'blocks.' . $block->type;
        
        if (!view()->exists($view)) {
            return response('Preview not found for block type: ' . $block->type, 404);
        }

        $data = $block->data ?? [];
        return view($view, ['data' => $data, 'page' => $page])->render();
    }

    /**
     * Delete a block
     */
    public function destroy(Page $page, PageBlock $block)
    {
        abort_unless($block->page_id === $page->id, 404);

        // Delete uploaded files if present
        $data = $block->data ?? [];
        foreach (['bg_image_path', 'file_path', 'image_path'] as $key) {
            if (!empty($data[$key]) && Storage::disk('public')->exists($data[$key])) {
                Storage::disk('public')->delete($data[$key]);
            }
        }

        $block->delete();

        return redirect()->back()->with('success', 'Block deleted.');
    }

    /**
     * Reorder blocks
     */
    public function reorder(Request $request, Page $page)
    {
        $order = $request->input('order', []);

        foreach ($order as $index => $blockId) {
            PageBlock::where('page_id', $page->id)
                ->where('id', $blockId)
                ->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Get default data for a block type
     */
    private function defaultDataFor(string $type): array
    {
        return match ($type) {
            'hero' => [
                'heading' => '',
                'subheading' => '',
                'button_text' => '',
                'button_url' => '#',
                'bg_image_path' => '',
                'alignment' => 'left',
                'column_left' => '',
                'column_right' => '',
            ],
            'rich_text' => [
                'title' => '',
                'html' => '',
            ],
            'repeater' => [
                'title' => '',
                'style' => 'bullet',
                'items' => ['First item', 'Second item'],
            ],
            'image' => [
                'caption' => '',
                'image_path' => '',
            ],
            'download' => [
                'title' => '',
                'button_text' => 'Download',
                'file_path' => '',
            ],
            default => [],
        };
    }
}