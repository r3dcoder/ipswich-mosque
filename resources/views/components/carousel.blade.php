@php
use Illuminate\Support\Str;
@endphp


@props([
  'page' => 'home',
  'interval' => 5000,
])

@php
  $slides = \App\Models\CarouselSlide::where('page', $page)
      ->where('is_active', true)
      ->orderBy('sort_order')
      ->get();

  $id = 'carousel_' . $page . '_' . uniqid();
@endphp

@if($slides->count())
<section class="professional-carousel" data-carousel-id="{{ $id }}" data-interval="{{ $interval }}">
  <div class="carousel-container">
    @foreach($slides as $i => $s)
      <div class="carousel-slide {{ $i === 0 ? 'active' : '' }}">
        <img src="{{ asset('storage/'.$s->image_path) }}" alt="{{ $s->title }}">
        <div class="carousel-caption">
          <div class="caption-box">
            <h2>{{ $s->title }}</h2>
            @if($s->subtitle)<p>{{ $s->subtitle }}</p>@endif


            @if(!empty($s->button_url))
                <a data-key="{{ $s->title }}" href="{{ Str::startsWith($s->button_url, ['http://', 'https://', '/'])
                            ? $s->button_url
                            : '/'.$s->button_url }}"
                  class="donate-btn">
                    {{ $s->button_text ?: 'Learn More' }}
                </a>
            @endif

          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="carousel-nav">
    @foreach($slides as $i => $s)
      <span class="dot {{ $i === 0 ? 'active' : '' }}"></span>
    @endforeach
  </div>
</section>
@endif



<script>
const slides = document.querySelectorAll(".carousel-slide");
const dots = document.querySelectorAll(".dot");
let index = 0;

function showSlide(n) {
  slides.forEach((slide, i) => {
    slide.classList.remove("active");
    dots[i].classList.remove("active");
  });
  slides[n].classList.add("active");
  dots[n].classList.add("active");
}

function nextSlide() {
  index = (index + 1) % slides.length;
  showSlide(index);
}

dots.forEach((dot, i) => {
  dot.addEventListener("click", () => {
    index = i;
    showSlide(index);
  });
});

setInterval(nextSlide, 5000); // auto-slide every 5s
</script>