<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarouselSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselSlideController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page'); // optional filter

        $slides = CarouselSlide::query()
            ->when($page, fn($q) => $q->where('page', $page))
            ->orderBy('page')
            ->orderBy('sort_order')
            ->paginate(20)
            ->withQueryString();

        return view('admin.carousel-slides.index', compact('slides', 'page'));
    }

    public function create()
    {
        return view('admin.carousel-slides.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'page'        => ['required', 'string', 'max:50'],
            'title'       => ['required', 'string', 'max:255'],
            'subtitle'    => ['nullable', 'string', 'max:255'],
            'image'       => ['required', 'image', 'max:40096'],
            'button_text' => ['nullable', 'string', 'max:50'],
            'button_url'  => ['nullable', 'string', 'max:255'],
            'sort_order'  => ['required', 'integer', 'min:1', 'max:9999'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = (bool)($data['is_active'] ?? false);

        $data['image_path'] = $request->file('image')->store('carousel', 'public');

        unset($data['image']);

        CarouselSlide::create($data);

        return redirect()->route('admin.carousel-slides.index')->with('success', 'Slide created.');
    }

    public function edit(CarouselSlide $carousel_slide)
    {
        return view('admin.carousel-slides.edit', ['slide' => $carousel_slide]);
    }

    public function update(Request $request, CarouselSlide $carousel_slide)
    {
        $data = $request->validate([
            'page'        => ['required', 'string', 'max:50'],
            'title'       => ['required', 'string', 'max:255'],
            'subtitle'    => ['nullable', 'string', 'max:255'],
            'image'       => ['nullable', 'image', 'max:4096'],
            'button_text' => ['nullable', 'string', 'max:50'],
            'button_url'  => ['nullable', 'string', 'max:255'],
            'sort_order'  => ['required', 'integer', 'min:1', 'max:9999'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = (bool)($data['is_active'] ?? false);

        if ($request->hasFile('image')) {
            // delete old
            if ($carousel_slide->image_path) {
                Storage::disk('public')->delete($carousel_slide->image_path);
            }
            $data['image_path'] = $request->file('image')->store('carousel', 'public');
        }

        unset($data['image']);

        $carousel_slide->update($data);

        return redirect()->route('admin.carousel-slides.index')->with('success', 'Slide updated.');
    }

    public function destroy(CarouselSlide $carousel_slide)
    {
        if ($carousel_slide->image_path) {
            Storage::disk('public')->delete($carousel_slide->image_path);
        }

        $carousel_slide->delete();

        return back()->with('success', 'Slide deleted.');
    }
}
