<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseFeature;
use App\Models\CourseSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CoursesController extends Controller
{
    public function index()
    {
        $sections = CourseSection::orderBy('page')->orderBy('sort_order')->paginate(20);
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
        $section->load(['courses' => function($q) {
            $q->orderBy('sort_order')->with(['features' => function($f){
                $f->orderBy('sort_order');
            }]);
        }]);

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

    // ✅ Delete section + all courses + images + features
    public function destroy(CourseSection $section)
    {
        $section->load('courses.features');

        foreach ($section->courses as $course) {
            if ($course->image_path) {
                Storage::disk('public')->delete($course->image_path);
            }
            $course->features()->delete();
            $course->delete();
        }

        $section->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course section deleted.');
    }

    // ✅ Add course (image upload)
    public function storeCourse(Request $request, CourseSection $section)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'image' => ['nullable','image','max:5120'],
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

    // ✅ Update course (replace image optional)
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
        $course->features()->delete();
        $course->delete();

        return back()->with('success', 'Course deleted.');
    }

    // ✅ Features normal CRUD
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

    // ✅ NEW: Reorder courses (Up/Down uses this)
    public function reorderCourses(Request $request, CourseSection $section)
    {
        $data = $request->validate([
            'ordered_ids' => ['required','array','min:1'],
            'ordered_ids.*' => ['integer'],
        ]);

        $ids = $data['ordered_ids'];

        $count = Course::where('course_section_id', $section->id)->whereIn('id', $ids)->count();
        if ($count !== count($ids)) {
            abort(422, 'Invalid course IDs for this section.');
        }

        DB::transaction(function () use ($ids) {
            foreach ($ids as $i => $id) {
                Course::where('id', $id)->update(['sort_order' => $i + 1]);
            }
        });

        return response()->json(['ok' => true]);
    }

    // ✅ NEW: Reorder features (ready for drag later)
    public function reorderFeatures(Request $request, Course $course)
    {
        $data = $request->validate([
            'ordered_ids' => ['required','array','min:1'],
            'ordered_ids.*' => ['integer'],
        ]);

        $ids = $data['ordered_ids'];

        $count = CourseFeature::where('course_id', $course->id)->whereIn('id', $ids)->count();
        if ($count !== count($ids)) {
            abort(422, 'Invalid feature IDs for this course.');
        }

        DB::transaction(function () use ($ids) {
            foreach ($ids as $i => $id) {
                CourseFeature::where('id', $id)->update(['sort_order' => $i + 1]);
            }
        });

        return response()->json(['ok' => true]);
    }

    // ✅ NEW: AJAX add feature (no reload)
    public function addFeatureAjax(Request $request, Course $course)
    {
        $data = $request->validate([
            'text' => ['required','string','max:255'],
        ]);

        $nextOrder = (int)($course->features()->max('sort_order') ?? 0) + 1;

        $feature = CourseFeature::create([
            'course_id' => $course->id,
            'text' => $data['text'],
            'sort_order' => $nextOrder,
        ]);

        return response()->json([
            'ok' => true,
            'feature' => [
                'id' => $feature->id,
                'text' => $feature->text,
                'sort_order' => $feature->sort_order,
                'update_url' => route('admin.courses.features.update', $feature),
                'delete_url' => route('admin.courses.features.destroy', $feature),
            ],
        ]);
    }
}
