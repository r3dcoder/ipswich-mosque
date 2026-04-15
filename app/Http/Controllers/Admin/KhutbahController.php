<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Khutbah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KhutbahController extends Controller
{
    /**
     * Display a listing of the khutbahs.
     */
    public function index(Request $request)
    {
        $query = Khutbah::query();

        // Filter by category
        if ($request->filled('category')) {
            $query->category($request->category);
        }

        // Filter by active/inactive
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'featured');
        }

        $khutbahs = $query->ordered()->paginate(12);

        // Get stats
        $stats = [
            'total' => Khutbah::count(),
            'active' => Khutbah::active()->count(),
            'featured' => Khutbah::featured()->count(),
        ];

        $categories = Khutbah::categories();

        return view('admin.khutbahs.index', compact('khutbahs', 'stats', 'categories'));
    }

    /**
     * Show the form for creating a new khutbah.
     */
    public function create()
    {
        $categories = Khutbah::categories();
        return view('admin.khutbahs.create', compact('categories'));
    }

    /**
     * Store a newly created khutbah in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_url' => 'required|url',
            'speaker' => 'nullable|string|max:100',
            'category' => 'required|string|in:' . implode(',', array_keys(Khutbah::categories())),
            'delivered_date' => 'nullable|date',
            'duration' => 'nullable|integer|min:1|max:300',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        
        // Extract YouTube ID from URL
        $youtubeId = $this->extractYouTubeId($request->youtube_url);
        if (!$youtubeId) {
            return redirect()->back()->withErrors(['youtube_url' => 'Invalid YouTube URL'])->withInput();
        }

        $data['youtube_id'] = $youtubeId;
        $data['youtube_url'] = $request->youtube_url;
        $data['thumbnail_url'] = "https://img.youtube.com/vi/{$youtubeId}/maxresdefault.jpg";
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $request->input('sort_order', 0);

        Khutbah::create($data);

        return redirect()->route('admin.khutbahs.index')->with('success', 'Khutbah added successfully.');
    }

    /**
     * Show the form for editing the specified khutbah.
     */
    public function edit(Khutbah $khutbah)
    {
        $categories = Khutbah::categories();
        return view('admin.khutbahs.edit', compact('khutbah', 'categories'));
    }

    /**
     * Update the specified khutbah in storage.
     */
    public function update(Request $request, Khutbah $khutbah)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_url' => 'required|url',
            'speaker' => 'nullable|string|max:100',
            'category' => 'required|string|in:' . implode(',', array_keys(Khutbah::categories())),
            'delivered_date' => 'nullable|date',
            'duration' => 'nullable|integer|min:1|max:300',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        
        // Check if YouTube URL changed
        if ($request->youtube_url !== $khutbah->youtube_url) {
            $youtubeId = $this->extractYouTubeId($request->youtube_url);
            if (!$youtubeId) {
                return redirect()->back()->withErrors(['youtube_url' => 'Invalid YouTube URL'])->withInput();
            }
            $data['youtube_id'] = $youtubeId;
            $data['thumbnail_url'] = "https://img.youtube.com/vi/{$youtubeId}/maxresdefault.jpg";
        }

        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');

        $khutbah->update($data);

        return redirect()->route('admin.khutbahs.index')->with('success', 'Khutbah updated successfully.');
    }

    /**
     * Remove the specified khutbah from storage.
     */
    public function destroy(Khutbah $khutbah)
    {
        $khutbah->delete();

        return redirect()->route('admin.khutbahs.index')->with('success', 'Khutbah deleted successfully.');
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Khutbah $khutbah)
    {
        $khutbah->update(['is_featured' => !$khutbah->is_featured]);

        return back()->with('success', 'Featured status updated.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(Khutbah $khutbah)
    {
        $khutbah->update(['is_active' => !$khutbah->is_active]);

        return back()->with('success', 'Active status updated.');
    }

    /**
     * Extract YouTube ID from URL.
     */
    private function extractYouTubeId(string $url): ?string
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        preg_match($pattern, $url, $matches);
        
        return $matches[1] ?? null;
    }
}