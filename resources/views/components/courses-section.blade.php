@props([
  'page' => 'home',
  'slug' => 'courses',
])

@php
  $section = \App\Models\CourseSection::where('page', $page)
      ->where('slug', $slug)
      ->where('is_active', true)
      ->orderBy('sort_order')
      ->first();
@endphp

@if($section)
<div class="courses-section">
    <h2 class="section-title">{{ $section->title }}</h2>
    @if($section->subtitle)
        <p class="section-subtitle">{{ $section->subtitle }}</p>
    @endif

    <div class="courses-grid">
        @foreach($section->activeCourses as $course)
            <div class="course-card">
                @if($course->image_path)
                    <img src="{{ asset('storage/'.$course->image_path) }}" alt="{{ $course->title }}" class="course-img">
                @endif

                <h3>{{ $course->title }}</h3>

                @if($course->features->count())
                    <ul class="features">
                        @foreach($course->features as $f)
                            <li>{{ $f->text }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endif
