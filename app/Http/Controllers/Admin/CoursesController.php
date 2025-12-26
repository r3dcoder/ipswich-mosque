<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseFeature;
use App\Models\CourseSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoursesController extends Controller
{
    public function index()
    {
        $sections = CourseSection::orderBy('page')
            ->orderBy('sort_order')
            ->paginate(20);

        return view('admin.courses.index', compact('sections'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'page' => ['required','string','max:50'],
            'slug' => ['required','string','max:80'],
            'title' => ['required','string','max:255'],
            'subtitle' => ['nullable','string','max:255'],
            'sort_order' => ['required','integer','min:1'],
            'is_active' => ['nullable','boolean'],
        ]);

        $data['is_active'] = (bool)($data['is_active'] ?? false);

        $section = CourseSection::create($data);

        return redirect()
            ->route('admin.courses.edit', $section)
            ->with('success', 'Course section created.');
    }

    public function edit(CourseSection $section)
    {
        $section->load(['courses.features']);
        return view('admin.courses.edit', compact('section'));
    }

    public function update(Request $request, CourseSection $section)
    {
        $data = $request->validate([
            'page' => ['required','string','max:50'],
            'slug' => ['required','string','max:80'],
            'title' => ['required','string','max:255'],
            'subtitle' => ['nullable','string','max:255'],
            'sort_order' => ['required','integer','min:1'],
            'is_active' => ['nullable','boolean'],
        ]);

        $data['is_active'] = (bool)($data['is_active'] ?? false);

        $section->update($data);

        return back()->with('success', 'Course section updated.');
    }

    // Add course (with image upload)
    public function storeCourse(Request $request, CourseSection $section)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'image' => ['nullable','image','max:9120'], // 5MB
            'sort_order' => ['required','integer','min:1'],
            'is_active' => ['nullable','boolean'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
        }

        Course::create([
            'course_section_id' => $section->id,
            'title' => $data['title'],
            'image_path' => $imagePath,
            'sort_order' => $data['sort_order'],
            'is_active' => (bool)($data['is_active'] ?? false),
        ]);

        return back()->with('success', 'Course added.');
    }

    // Update course (optionally replace image)
    public function updateCourse(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'image' => ['nullable','image','max:5120'],
            'sort_order' => ['required','integer','min:1'],
            'is_active' => ['nullable','boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($course->image_path) {
                Storage::disk('public')->delete($course->image_path);
            }
            $course->image_path = $request->file('image')->store('courses', 'public');
        }

        $course->title = $data['title'];
        $course->sort_order = $data['sort_order'];
        $course->is_active = (bool)($data['is_active'] ?? false);
        $course->save();

        return back()->with('success', 'Course updated.');
    }

    public function destroyCourse(Course $course)
    {
        if ($course->image_path) {
            Storage::disk('public')->delete($course->image_path);
        }
        $course->delete();

        return back()->with('success', 'Course deleted.');
    }

    // Features CRUD
    public function addFeature(Request $request, Course $course)
    {
        $data = $request->validate([
            'text' => ['required','string','max:255'],
            'sort_order' => ['required','integer','min:1'],
        ]);

        CourseFeature::create([
            'course_id' => $course->id,
            'text' => $data['text'],
            'sort_order' => $data['sort_order'],
        ]);

        return back()->with('success', 'Feature added.');
    }

    public function updateFeature(Request $request, CourseFeature $feature)
    {
        $data = $request->validate([
            'text' => ['required','string','max:255'],
            'sort_order' => ['required','integer','min:1'],
        ]);

        $feature->update($data);

        return back()->with('success', 'Feature updated.');
    }

    public function destroyFeature(CourseFeature $feature)
    {
        $feature->delete();
        return back()->with('success', 'Feature deleted.');
    }

    public function destroy(CourseSection $section)
{
    // Delete related data safely
    foreach ($section->courses as $course) {
        if ($course->image_path) {
            \Storage::disk('public')->delete($course->image_path);
        }
        $course->features()->delete();
        $course->delete();
    }

    $section->delete();

    return redirect()
        ->route('admin.courses.index')
        ->with('success', 'Course section deleted.');
}

}
