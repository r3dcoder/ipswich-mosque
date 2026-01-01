<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageBlockController extends Controller
{
    // Add new block
    public function store(Request $request, Page $page)
    {
        $type = $request->validate([
            'type' => ['required','string','max:50'],
        ])['type'];

        $nextOrder = (int) ($page->blocks()->max('sort_order') ?? 0) + 1;

        $page->blocks()->create([
            'type' => $type,
            'sort_order' => $nextOrder,
            'data' => $this->defaultDataFor($type),
        ]);

        return back()->with('success', 'Block added.');
    }

    // Update block (including upload)
    public function update(Request $request, Page $page, PageBlock $block)
    {
        abort_unless($block->page_id === $page->id, 404);

        $data = $block->data ?? [];

        // Common fields
        if ($block->type === 'hero') {
            $payload = $request->validate([
                'heading' => ['required','string','max:255'],
                'subheading' => ['nullable','string','max:1000'],
                'button_text' => ['nullable','string','max:50'],
                'button_url' => ['nullable','string','max:255'],
                'bg_image' => ['nullable','image','max:5120'],
            ]);

            $data['heading'] = $payload['heading'];
            $data['subheading'] = $payload['subheading'] ?? '';
            $data['button_text'] = $payload['button_text'] ?? '';
            $data['button_url'] = $payload['button_url'] ?? '';

            if ($request->hasFile('bg_image')) {
                if (!empty($data['bg_image_path'])) Storage::disk('public')->delete($data['bg_image_path']);
                $data['bg_image_path'] = $request->file('bg_image')->store('pages', 'public');
            }
        }

        if ($block->type === 'rich_text') {
            $payload = $request->validate([
                'title' => ['nullable','string','max:255'],
                'html' => ['required','string'],
            ]);

            $data['title'] = $payload['title'] ?? '';
            $data['html'] = $payload['html'];
        }

        if ($block->type === 'download') {
            $payload = $request->validate([
                'title' => ['nullable','string','max:255'],
                'button_text' => ['nullable','string','max:50'],
                'file' => ['nullable','file','max:10240'], // pdf, doc, etc
            ]);

            $data['title'] = $payload['title'] ?? '';
            $data['button_text'] = $payload['button_text'] ?? 'Download';

            if ($request->hasFile('file')) {
                if (!empty($data['file_path'])) Storage::disk('public')->delete($data['file_path']);
                $data['file_path'] = $request->file('file')->store('pages', 'public');
            }
        }

        if ($block->type === 'image') {
            $payload = $request->validate([
                'caption' => ['nullable','string','max:255'],
                'image' => ['nullable','image','max:5120'],
            ]);

            $data['caption'] = $payload['caption'] ?? '';

            if ($request->hasFile('image')) {
                if (!empty($data['image_path'])) Storage::disk('public')->delete($data['image_path']);
                $data['image_path'] = $request->file('image')->store('pages', 'public');
            }
        }

        if ($block->type === 'repeater') {
            $payload = $request->validate([
                'title' => ['nullable','string','max:255'],
                'items' => ['nullable','array'],
                'items.*' => ['nullable','string','max:255'],
            ]);

            $data['title'] = $payload['title'] ?? '';
            $data['items'] = array_values(array_filter($payload['items'] ?? [], fn($v) => trim((string)$v) !== ''));
        }

        if ($block->type === 'eid_times') {
            $payload = $request->validate([
                'title' => ['nullable','string','max:255'],
                'rows' => ['nullable','array'],
                'rows.*.label' => ['required_with:rows','string','max:50'],
                'rows.*.time' => ['required_with:rows','string','max:10'],
            ]);

            $data['title'] = $payload['title'] ?? 'EID JAMAT';
            $data['rows'] = array_values($payload['rows'] ?? []);
        }

        $block->update(['data' => $data]);

        return back()->with('success', 'Block updated.');
    }

    public function destroy(Page $page, PageBlock $block)
    {
        abort_unless($block->page_id === $page->id, 404);

        // delete uploaded files if present
        $data = $block->data ?? [];
        foreach (['bg_image_path','file_path','image_path'] as $key) {
            if (!empty($data[$key])) Storage::disk('public')->delete($data[$key]);
        }

        $block->delete();
        return back()->with('success', 'Block deleted.');
    }

    public function reorder(Request $request, Page $page)
    {
        $payload = $request->validate([
            'order' => ['required','array'],
            'order.*' => ['integer'],
        ]);

        foreach ($payload['order'] as $i => $id) {
            PageBlock::where('page_id', $page->id)->where('id', $id)->update(['sort_order' => $i + 1]);
        }

        return response()->json(['ok' => true]);
    }

    private function defaultDataFor(string $type): array
    {
        return match ($type) {
            'hero' => [
                'heading' => 'Page Title',
                'subheading' => '',
                'button_text' => '',
                'button_url' => '',
                'bg_image_path' => null,
            ],
            'rich_text' => [
                'title' => '',
                'html' => '<p>Write content here...</p>',
            ],
            'download' => [
                'title' => 'Download',
                'button_text' => 'Download',
                'file_path' => null,
            ],
            'image' => [
                'caption' => '',
                'image_path' => null,
            ],
            'repeater' => [
                'title' => 'List',
                'items' => ['Item 1', 'Item 2'],
            ],
            'eid_times' => [
                'title' => 'EID JAMAT',
                'rows' => [
                    ['label' => '1st Jamat', 'time' => '08:00'],
                    ['label' => '2nd Jamat', 'time' => '09:00'],
                ],
            ],
            default => [],
        };
    }
}
