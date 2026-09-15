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
            'type' => ['required', 'string', 'in:hero,rich_text,repeater,image,download,columns,image_text'],
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

        // Column / image-text blocks: normalise structure before saving
        if ($block->type === 'columns') {
            $data = $this->normaliseColumns($data);
        }

        if ($block->type === 'image_text') {
            $data = $this->normaliseImageText($data);
        }

        $block->update(['data' => $data]);

        return response()->json(['success' => true]);
    }

    /**
     * Make sure the columns payload always matches the chosen column count/layout.
     */
    private function normaliseColumns(array $data): array
    {
        $count = (int) ($data['count'] ?? 2);

        if (!in_array($count, PageBlock::columnCounts(), true)) {
            $count = 2;
        }

        $layouts = PageBlock::columnLayouts($count);
        $layout = $data['layout'] ?? array_key_first($layouts);

        if (!isset($layouts[$layout])) {
            $layout = array_key_first($layouts);
        }

        $items = array_values(array_filter((array) ($data['items'] ?? []), 'is_array'));

        // Pad or trim the item list so it always matches the column count
        while (count($items) < $count) {
            $items[] = ['html' => '', 'image_path' => '', 'image_alt' => '', 'image_position' => 'top'];
        }

        $items = array_slice($items, 0, $count);

        $items = array_map(function (array $item) {
            $position = $item['image_position'] ?? 'top';

            return [
                'html' => (string) ($item['html'] ?? ''),
                'image_path' => (string) ($item['image_path'] ?? ''),
                'image_alt' => (string) ($item['image_alt'] ?? ''),
                'image_position' => in_array($position, ['top', 'bottom', 'left', 'right'], true) ? $position : 'top',
            ];
        }, $items);

        $gap = $data['gap'] ?? 'md';
        $align = $data['vertical_align'] ?? 'top';

        return [
            'heading' => (string) ($data['heading'] ?? ''),
            'count' => $count,
            'layout' => $layout,
            'gap' => array_key_exists($gap, PageBlock::gapOptions()) ? $gap : 'md',
            'vertical_align' => array_key_exists($align, PageBlock::alignOptions()) ? $align : 'top',
            'stack_on_mobile' => (bool) ($data['stack_on_mobile'] ?? true),
            'items' => $items,
        ];
    }

    /**
     * Keep the image + text payload to a known shape.
     */
    private function normaliseImageText(array $data): array
    {
        $width = (int) ($data['image_width'] ?? 45);
        $width = max(20, min(70, $width));

        $align = $data['vertical_align'] ?? 'center';
        $gap = $data['gap'] ?? 'md';

        return [
            'image_path' => (string) ($data['image_path'] ?? ''),
            'image_alt' => (string) ($data['image_alt'] ?? ''),
            'image_position' => ($data['image_position'] ?? 'left') === 'right' ? 'right' : 'left',
            'image_width' => (string) $width,
            'vertical_align' => in_array($align, ['top', 'center', 'bottom'], true) ? $align : 'center',
            'rounded' => (bool) ($data['rounded'] ?? true),
            'gap' => array_key_exists($gap, PageBlock::gapOptions()) ? $gap : 'md',
            'html' => (string) ($data['html'] ?? ''),
        ];
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
            'columns' => [
                'heading' => '',
                'count' => 2,
                'layout' => '50-50',
                'gap' => 'md',
                'vertical_align' => 'top',
                'stack_on_mobile' => true,
                'items' => [
                    ['html' => '', 'image_path' => '', 'image_alt' => '', 'image_position' => 'top'],
                    ['html' => '', 'image_path' => '', 'image_alt' => '', 'image_position' => 'top'],
                ],
            ],
            'image_text' => [
                'image_path' => '',
                'image_alt' => '',
                'image_position' => 'left',
                'image_width' => '45',
                'vertical_align' => 'center',
                'rounded' => true,
                'gap' => 'md',
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