@extends('layouts.dashboard')

@section('title', 'Manage Courses')
@section('header', 'Manage Courses')

@section('content')
<div class="max-w-6xl">

    @if (session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-800 border border-red-200">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    {{-- Update section --}}
    <form method="POST" action="{{ route('admin.courses.update', $section) }}"
          class="bg-white border rounded-xl p-6 space-y-4 mb-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Page</label>
                <input name="page" value="{{ old('page',$section->page) }}" class="w-full rounded-lg border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Slug</label>
                <input name="slug" value="{{ old('slug',$section->slug) }}" class="w-full rounded-lg border-gray-300">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Title</label>
            <input name="title" value="{{ old('title',$section->title) }}" class="w-full rounded-lg border-gray-300">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Subtitle</label>
            <input name="subtitle" value="{{ old('subtitle',$section->subtitle) }}" class="w-full rounded-lg border-gray-300">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
            <div>
                <label class="block text-sm font-medium mb-1">Sort Order</label>
                <input type="number" min="1" name="sort_order" value="{{ old('sort_order',$section->sort_order) }}"
                       class="w-full rounded-lg border-gray-300">
            </div>
            <div class="flex items-center gap-2 mt-6 md:mt-0">
                <input type="hidden" name="is_active" value="0">
                <input id="is_active" type="checkbox" name="is_active" value="1" class="rounded border-gray-300"
                       @checked(old('is_active',$section->is_active))>
                <label for="is_active" class="text-sm">Active</label>
            </div>
        </div>

        <div class="flex justify-end">
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
                Update Section
            </button>
        </div>
    </form>

    {{-- Add course --}}
    <div class="bg-white border rounded-xl p-6 mb-8">
        <h3 class="text-base font-semibold mb-1">Add Course</h3>

        <form method="POST"
              action="{{ route('admin.courses.courses.store', $section) }}"
              enctype="multipart/form-data"
              class="grid grid-cols-1 lg:grid-cols-12 gap-4">
            @csrf

            <div class="lg:col-span-5">
                <label class="block text-sm font-medium mb-1">Title</label>
                <input name="title" class="w-full rounded-lg border-gray-300" required>
            </div>

            <div class="lg:col-span-4">
                <label class="block text-sm font-medium mb-1">Image Upload</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full rounded-lg border-gray-300 bg-white"
                       onchange="previewImage(event, 'preview-new-course')">
                <img id="preview-new-course" class="mt-3 h-24 w-40 object-cover rounded-lg border hidden" alt="Preview">
            </div>

            <div class="lg:col-span-2">
                <label class="block text-sm font-medium mb-1">Order</label>
                <input type="number" min="1" name="sort_order" value="1" class="w-full rounded-lg border-gray-300">
            </div>

            <div class="lg:col-span-1 flex items-center gap-2 mt-6">
                <input type="hidden" name="is_active" value="0">
                <input id="course_active_new" type="checkbox" name="is_active" value="1" class="rounded border-gray-300" checked>
                <label for="course_active_new" class="text-sm">On</label>
            </div>

            <div class="lg:col-span-12">
                <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
                    Add Course
                </button>
            </div>
        </form>
    </div>

    {{-- Courses list --}}
    <div class="bg-white border rounded-xl overflow-hidden">
        <div class="p-6 border-b">
            <h3 class="text-base font-semibold">Courses (use ↑ ↓ to reorder)</h3>
        </div>

        <div class="divide-y" id="courseList">
            @forelse($section->courses as $course)
                <div class="p-6" data-course-id="{{ $course->id }}">

                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <button type="button"
                                    class="px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50"
                                    onclick="moveCourse({{ $course->id }}, -1)">↑</button>
                            <button type="button"
                                    class="px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50"
                                    onclick="moveCourse({{ $course->id }}, 1)">↓</button>
                            <span class="text-xs text-gray-500">Order: {{ $course->sort_order }}</span>
                        </div>

                        <form method="POST"
                              action="{{ route('admin.courses.courses.destroy', $course) }}"
                              onsubmit="return confirm('Delete this course?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-2 rounded-lg border border-red-200 text-red-700 hover:bg-red-50 text-sm">
                                Delete Course
                            </button>
                        </form>
                    </div>

                    {{-- Update course --}}
                    <form method="POST"
                          action="{{ route('admin.courses.courses.update', $course) }}"
                          enctype="multipart/form-data"
                          class="mt-4 grid grid-cols-1 md:grid-cols-12 gap-4">
                        @csrf
                        @method('PUT')

                        <div class="md:col-span-4">
                            <label class="block text-sm font-medium mb-1">Title</label>
                            <input name="title" value="{{ $course->title }}" class="w-full rounded-lg border-gray-300" required>
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium mb-1">Replace Image</label>
                            <input type="file" name="image" accept="image/*"
                                   class="w-full rounded-lg border-gray-300 bg-white"
                                   onchange="previewImage(event, 'preview-{{ $course->id }}')">
                            <img id="preview-{{ $course->id }}" class="mt-3 h-24 w-40 object-cover rounded-lg border hidden" alt="Preview">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1">Order</label>
                            <input type="number" min="1" name="sort_order" value="{{ $course->sort_order }}"
                                   class="w-full rounded-lg border-gray-300" required>
                        </div>

                        <div class="md:col-span-2 flex items-center gap-2 mt-6">
                            <input type="hidden" name="is_active" value="0">
                            <input id="active_{{ $course->id }}" type="checkbox" name="is_active" value="1"
                                   class="rounded border-gray-300" @checked($course->is_active)>
                            <label for="active_{{ $course->id }}" class="text-sm">Active</label>
                        </div>

                        <div class="md:col-span-1 flex items-end">
                            <button class="w-full px-3 py-2 rounded-lg border text-sm hover:bg-gray-50">
                                Save
                            </button>
                        </div>
                    </form>

                    {{-- Current image --}}
                    @if($course->image_path)
                        <img src="{{ asset('storage/'.$course->image_path) }}"
                             class="mt-3 h-24 w-40 object-cover rounded-lg border"
                             alt="{{ $course->title }}">
                    @endif

                    {{-- Features --}}
                    <div class="mt-6">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold">Features</h4>

                            <button type="button"
                                    class="px-3 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800"
                                    onclick="toggleFeatureForm({{ $course->id }})">
                                + Add Feature
                            </button>
                        </div>

                        {{-- AJAX add feature form (hidden) --}}
                        <div id="featureFormWrap-{{ $course->id }}" class="hidden mb-4">
                            <div class="flex flex-col md:flex-row gap-2 bg-gray-50 border rounded-xl p-3">
                                <input id="featureText-{{ $course->id }}"
                                       class="flex-1 rounded-lg border-gray-300 text-sm"
                                       placeholder="New bullet point">

                                <div class="flex gap-2">
                                    <button type="button"
                                            class="px-3 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800"
                                            onclick="addFeatureAjax({{ $course->id }})">
                                        Save
                                    </button>

                                    <button type="button"
                                            class="px-3 py-2 rounded-lg border text-sm hover:bg-gray-50"
                                            onclick="toggleFeatureForm({{ $course->id }})">
                                        Cancel
                                    </button>
                                </div>
                            </div>

                            <p id="featureErr-{{ $course->id }}" class="text-sm text-red-600 mt-2 hidden"></p>
                        </div>

                        {{-- Existing features list --}}
                        <div class="space-y-3" id="featureList-{{ $course->id }}">
                            @forelse($course->features as $f)
                                <div class="flex flex-col md:flex-row md:items-center gap-2">
                                    <form method="POST"
                                          action="{{ route('admin.courses.features.update', $f) }}"
                                          class="flex-1 flex flex-col md:flex-row gap-2">
                                        @csrf
                                        @method('PUT')

                                        <input name="text" value="{{ $f->text }}"
                                               class="flex-1 rounded-lg border-gray-300 text-sm" required>

                                        <input type="number" min="1" name="sort_order" value="{{ $f->sort_order }}"
                                               class="w-28 rounded-lg border-gray-300 text-sm" required>

                                        <button class="px-3 py-2 rounded-lg border text-sm hover:bg-gray-50">
                                            Update
                                        </button>
                                    </form>

                                    <form method="POST"
                                          action="{{ route('admin.courses.features.destroy', $f) }}"
                                          onsubmit="return confirm('Delete this feature?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-2 rounded-lg border border-red-200 text-red-700 hover:bg-red-50 text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div class="text-sm text-gray-600 bg-gray-50 border rounded-xl p-4">
                                    No features yet. Click <b>+ Add Feature</b>.
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            @empty
                <div class="p-6 text-center text-gray-600">
                    No courses yet. Add one above.
                </div>
            @endforelse
        </div>
    </div>

</div>

<script>
  function csrf() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  }

  function previewImage(e, imgId) {
    const file = e.target.files?.[0];
    const img = document.getElementById(imgId);
    if (!img) return;

    if (!file) {
      img.src = '';
      img.classList.add('hidden');
      return;
    }
    img.src = URL.createObjectURL(file);
    img.classList.remove('hidden');
  }

  function toggleFeatureForm(courseId) {
    const el = document.getElementById(`featureFormWrap-${courseId}`);
    if (!el) return;

    el.classList.toggle('hidden');

    const err = document.getElementById(`featureErr-${courseId}`);
    if (err) { err.classList.add('hidden'); err.textContent = ''; }

    if (!el.classList.contains('hidden')) {
      const input = document.getElementById(`featureText-${courseId}`);
      if (input) input.focus();
    }
  }

  function escapeHtml(str) {
    return String(str)
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;')
      .replaceAll("'", '&#039;');
  }

  async function addFeatureAjax(courseId) {
    const input = document.getElementById(`featureText-${courseId}`);
    const err = document.getElementById(`featureErr-${courseId}`);
    const list = document.getElementById(`featureList-${courseId}`);

    if (!input || !list) return;

    const text = (input.value || '').trim();
    if (!text) {
      if (err) { err.textContent = 'Please write a feature.'; err.classList.remove('hidden'); }
      return;
    }

    if (err) { err.classList.add('hidden'); err.textContent = ''; }

    try {
      const res = await fetch(`{{ route('admin.courses.features.ajax', ['course' => 'COURSE_ID']) }}`.replace('COURSE_ID', courseId), {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrf(),
          'Accept': 'application/json',
        },
        body: JSON.stringify({ text })
      });

      const data = await res.json();
      if (!res.ok || !data.ok) {
        throw new Error(data?.message || 'Failed to add feature.');
      }

      const f = data.feature;

      const wrapper = document.createElement('div');
      wrapper.className = 'flex flex-col md:flex-row md:items-center gap-2';

      wrapper.innerHTML = `
        <form method="POST" action="${f.update_url}" class="flex-1 flex flex-col md:flex-row gap-2">
          <input type="hidden" name="_token" value="${csrf()}">
          <input type="hidden" name="_method" value="PUT">

          <input name="text" value="${escapeHtml(f.text)}"
                 class="flex-1 rounded-lg border-gray-300 text-sm" required>

          <input type="number" min="1" name="sort_order" value="${f.sort_order}"
                 class="w-28 rounded-lg border-gray-300 text-sm" required>

          <button class="px-3 py-2 rounded-lg border text-sm hover:bg-gray-50">
            Update
          </button>
        </form>

        <form method="POST" action="${f.delete_url}" onsubmit="return confirm('Delete this feature?')">
          <input type="hidden" name="_token" value="${csrf()}">
          <input type="hidden" name="_method" value="DELETE">
          <button class="px-3 py-2 rounded-lg border border-red-200 text-red-700 hover:bg-red-50 text-sm">
            Delete
          </button>
        </form>
      `;

      list.appendChild(wrapper);
      input.value = '';
      toggleFeatureForm(courseId);

    } catch (e) {
      if (err) { err.textContent = e.message; err.classList.remove('hidden'); }
    }
  }

  async function moveCourse(courseId, delta) {
    const container = document.querySelector(`[data-course-id="${courseId}"]`);
    if (!container) return;

    const parent = document.getElementById('courseList');
    const blocks = Array.from(parent.querySelectorAll('[data-course-id]'));
    const idx = blocks.findIndex(el => el.getAttribute('data-course-id') == courseId);
    const newIdx = idx + delta;

    if (newIdx < 0 || newIdx >= blocks.length) return;

    if (delta < 0) parent.insertBefore(container, blocks[newIdx]);
    else parent.insertBefore(blocks[newIdx], container);

    const ordered = Array.from(parent.querySelectorAll('[data-course-id]'))
      .map(el => parseInt(el.getAttribute('data-course-id'), 10));

    try {
      const res = await fetch(`{{ route('admin.courses.courses.reorder', $section) }}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrf(),
          'Accept': 'application/json',
        },
        body: JSON.stringify({ ordered_ids: ordered })
      });

      if (!res.ok) {
        const data = await res.json().catch(()=> ({}));
        throw new Error(data?.message || 'Failed to save order.');
      }
    } catch (e) {
      alert(e.message);
      location.reload();
    }
  }
</script>
@endsection
