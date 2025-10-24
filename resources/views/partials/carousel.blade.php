<section class="professional-carousel">
  <div class="carousel-container">
    <!-- Slide 1: Ipswich Mosque -->
    <div class="carousel-slide active">
      <img src="{{ asset('images/ipswichmosque_front.jpg') }}" alt="Ipswich Mosque Front">
      <div class="carousel-caption">
        <div class="caption-box">
          <h2>Welcome to Ipswich Mosque</h2>
          <p>Serving the community with faith, education, and unity.</p>
          <a href="#donate" class="donate-btn">Donate Now</a>
        </div>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="carousel-slide">
      <img src="{{ asset('images/inside of ipswichmosque.jpg') }}" alt="Quran Education">
      <div class="carousel-caption">
        <div class="caption-box">
          <h2>Qur’an Education</h2>
          <p>Children & adult classes to learn the words of Allah.</p>
          <a href="#donate" class="donate-btn">Donate Now</a>
        </div>
      </div>
    </div>

    <!-- Slide 3 -->
    <div class="carousel-slide">
      <img src="{{ asset('images/ipswichmosque_front.jpg') }}" alt="Support Mosque">
      <div class="carousel-caption">
        <div class="caption-box">
          <h2>Support Your Mosque</h2>
          <p>Your donations help us grow and serve the ummah.</p>
          <a href={{ url('/donate') }} class="donate-btn">Donate Now</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Navigation Dots -->
  <div class="carousel-nav">
    <span class="dot active"></span>
    <span class="dot"></span>
    <span class="dot"></span>
  </div>
</section>

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

