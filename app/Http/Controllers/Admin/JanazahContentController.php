<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JanazahContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class JanazahContentController extends Controller
{
    /**
     * Display a listing of the content blocks, grouped by page section.
     */
    public function index(Request $request)
    {
        $query = JanazahContent::query();

        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }

        $contents = $query->orderBy('section')->orderBy('sort_order')->orderBy('id')->get();
        $sections = JanazahContent::sections();
        $bulkSections = JanazahContent::bulkSections();

        // Counts for bulk section cards
        $bulkStats = [];
        foreach ($bulkSections as $key => $meta) {
            $itemCount = JanazahContent::where('section', $meta['item_section'])->count();
            $heading = JanazahContent::where('section', $meta['heading_section'])->first();
            $bulkStats[$key] = [
                'item_count' => $itemCount,
                'heading' => $heading,
            ];
        }

        $hero = JanazahContent::where('section', 'hero')->orderBy('sort_order')->orderBy('id')->first();

        return view('admin.janazah-contents.index', compact(
            'contents',
            'sections',
            'bulkSections',
            'bulkStats',
            'hero'
        ));
    }

    /**
     * Show the form for creating a new content block.
     */
    public function create()
    {
        $sections = JanazahContent::sections();

        return view('admin.janazah-contents.create', compact('sections'));
    }

    /**
     * Store a newly created content block.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'section'    => 'required|string|in:' . implode(',', array_keys(JanazahContent::sections())),
            'title'      => 'nullable|string|max:255',
            'content'    => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_visible' => 'nullable|boolean',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_visible'] = $request->boolean('is_visible', true);

        JanazahContent::create($validated);

        return redirect()
            ->route('admin.janazah-contents.index')
            ->with('success', 'Janazah content added successfully.');
    }

    /**
     * Show the form for editing the specified content block.
     */
    public function edit(JanazahContent $janazahContent)
    {
        $sections = JanazahContent::sections();

        return view('admin.janazah-contents.edit', compact('janazahContent', 'sections'));
    }

    /**
     * Update the specified content block.
     */
    public function update(Request $request, JanazahContent $janazahContent)
    {
        $validated = $request->validate([
            'section'    => 'required|string|in:' . implode(',', array_keys(JanazahContent::sections())),
            'title'      => 'nullable|string|max:255',
            'content'    => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_visible' => 'nullable|boolean',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_visible'] = $request->boolean('is_visible', true);

        $janazahContent->update($validated);

        return redirect()
            ->route('admin.janazah-contents.index')
            ->with('success', 'Janazah content updated successfully.');
    }

    /**
     * Remove the specified content block.
     */
    public function destroy(JanazahContent $janazahContent)
    {
        $janazahContent->delete();

        return redirect()
            ->route('admin.janazah-contents.index')
            ->with('success', 'Janazah content deleted successfully.');
    }

    /**
     * Toggle the visible status.
     */
    public function toggleVisible(JanazahContent $janazahContent)
    {
        $janazahContent->update(['is_visible' => !$janazahContent->is_visible]);

        return back()->with('success', 'Visibility updated successfully.');
    }

    /**
     * Bulk-edit a whole page section (heading + all steps) on one form.
     */
    public function editSection(string $sectionKey)
    {
        $bulkSections = JanazahContent::bulkSections();

        if (!isset($bulkSections[$sectionKey])) {
            abort(404);
        }

        $meta = $bulkSections[$sectionKey];
        $heading = JanazahContent::where('section', $meta['heading_section'])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->first();
        $items = JanazahContent::where('section', $meta['item_section'])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.janazah-contents.edit-section', compact(
            'sectionKey',
            'meta',
            'heading',
            'items'
        ));
    }

    /**
     * Save an entire section (heading + all items) in one go.
     * Items without an id are created; missing existing ids are deleted.
     */
    public function updateSection(Request $request, string $sectionKey)
    {
        $bulkSections = JanazahContent::bulkSections();

        if (!isset($bulkSections[$sectionKey])) {
            abort(404);
        }

        $meta = $bulkSections[$sectionKey];
        $isMainHeading = !empty($meta['heading_is_main']);

        $validated = $request->validate([
            'heading_title'   => 'nullable|string|max:255',
            'heading_content' => 'nullable|string',
            'heading_visible' => 'nullable|boolean',
            'items'           => 'nullable|array',
            'items.*.id'      => [
                'nullable',
                'integer',
                Rule::exists('janazah_contents', 'id')->where(fn ($q) => $q->where('section', $meta['item_section'])),
            ],
            'items.*.title'      => 'nullable|string|max:255',
            'items.*.content'    => 'nullable|string',
            'items.*.sort_order' => 'nullable|integer|min:0',
            'items.*.is_visible' => 'nullable|boolean',
            'items.*.delete'     => 'nullable|boolean',
        ]);

        $itemsInput = $validated['items'] ?? [];

        DB::transaction(function () use ($meta, $isMainHeading, $validated, $itemsInput, $request) {
            // Upsert heading row
            $headingData = [
                'section'    => $meta['heading_section'],
                'title'      => $validated['heading_title'] ?? $meta['default_title'],
                'content'    => $validated['heading_content'] ?? ($isMainHeading ? null : ($meta['default_subtitle'] ?? null)),
                'sort_order' => 0,
                'is_visible' => $request->boolean('heading_visible', true),
            ];

            $heading = JanazahContent::where('section', $meta['heading_section'])->first();
            if ($heading) {
                $heading->update($headingData);
            } else {
                JanazahContent::create($headingData);
            }

            $keptIds = [];

            foreach (array_values($itemsInput) as $index => $row) {
                // Skip fully empty new rows
                $title = trim((string) ($row['title'] ?? ''));
                $content = trim((string) ($row['content'] ?? ''));
                $shouldDelete = !empty($row['delete']);

                if (!empty($row['id']) && $shouldDelete) {
                    JanazahContent::where('id', $row['id'])
                        ->where('section', $meta['item_section'])
                        ->delete();
                    continue;
                }

                if ($title === '' && $content === '' && empty($row['id'])) {
                    continue;
                }

                $payload = [
                    'section'    => $meta['item_section'],
                    'title'      => $title !== '' ? $title : null,
                    'content'    => $content !== '' ? $content : null,
                    'sort_order' => isset($row['sort_order']) && $row['sort_order'] !== ''
                        ? (int) $row['sort_order']
                        : ($index + 1),
                    'is_visible' => filter_var($row['is_visible'] ?? false, FILTER_VALIDATE_BOOLEAN),
                ];

                if (!empty($row['id'])) {
                    $item = JanazahContent::where('id', $row['id'])
                        ->where('section', $meta['item_section'])
                        ->first();

                    if ($item) {
                        $item->update($payload);
                        $keptIds[] = $item->id;
                    }
                } else {
                    $item = JanazahContent::create($payload);
                    $keptIds[] = $item->id;
                }
            }
        });

        return redirect()
            ->route('admin.janazah-contents.edit-section', $sectionKey)
            ->with('success', $meta['label'] . ' saved successfully.');
    }
}
