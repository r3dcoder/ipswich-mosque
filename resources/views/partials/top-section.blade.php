<div class="hero-section bg-white">
    <div class="container">
        <div class="hero-content flex flex-row justify-between items-center">
            <div class="welcome-message w-1/2 p-6">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Welcome to the Ipswich Mosque</h1>
                <p class="text-lg text-gray-600 mb-6">Join us in making a difference. Your support can change lives.</p>
                <a href="#" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Donate Now</a>
            </div>
            <div class="slider-container w-1/2 relative rounded-2xl overflow-hidden">
                <div class="slider overflow-hidden">
                    <div class="slide flex items-center" style="width: 100%; display: none;">
                        <img src="{{ asset('images/ipswichmosque_front.jpg') }}" alt="Slide 1"
                            class=" w-full h-auto object-cover">
                        <div
                            class="slider-caption absolute bottom-4 left-4 text-white bg-black bg-opacity-50 p-2 rounded">
                            <p>Caption for Slide 1</p>
                        </div>
                    </div>
                    <div class="slide flex items-center" style="width: 100%; display: none;">
                        <img src="{{ asset('images/inside of ipswichmosque.jpg') }}" alt="Slide 2"
                            class="w-full h-auto object-cover">
                        <div
                            class="slider-caption absolute bottom-4 left-4 text-white bg-black bg-opacity-50 p-2 rounded">
                            <p>Caption for Slide 2</p>
                        </div>
                    </div>
                    <div class="slide flex items-center" style="width: 100%; display: block;">
                        <img src="{{ asset('images/slide3.jpg') }}" alt="Slide 3"
                            class="w-full h-auto object-cover rounded-2xl">
                        <div
                            class="slider-caption absolute bottom-4 left-4 text-white bg-black bg-opacity-50 p-2 rounded">
                            <p>Caption for Slide 3</p>
                        </div>
                    </div>
                </div>
                <button
                    class="slider-btn prev absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-800 text-white px-3 py-2 items-center rounded-full hover:bg-gray-600">
                    <div class="-mt-1">
                        ←
                    </div>
                </button>
                <button
                    class="px-3 py-2 slider-btn next absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full hover:bg-gray-600">
                    
                    <div class="-mt-1">
                    →
                    </div></button>
            </div>
        </div>
    </div>
</div>

<style>
    .hero-section {
        padding: 60px 0;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .hero-content {
        gap: 20px;
    }

    .welcome-message h1 {
        color: #333;
    }

    .welcome-message p {
        line-height: 1.6;
    }

    .welcome-message a {
        display: inline-block;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .slider-container {
        position: relative;
        height: 400px;
    }

    .slider {
        position: relative;
        height: 100%;
    }

    .slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        transition: opacity 0.5s ease-in-out;
    }

    .slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .slider-caption {
        font-size: 14px;
    }

    .slider-btn {
        cursor: pointer;
        z-index: 10;
        border: none;
        font-size: 18px;
    }

    .slider-btn:hover {
        background-color: #555;
    }

    @media (max-width: 768px) {
        .hero-content {
            flex-direction: column;
        }

        .welcome-message,
        .slider-container {
            width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slides = document.querySelectorAll('.slide');
        const prevBtn = document.querySelector('.prev');
        const nextBtn = document.querySelector('.next');
        let currentSlide = 0;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.display = i === index ? 'flex' : 'none';
            });
        }

        prevBtn.addEventListener('click', () => {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        });

        nextBtn.addEventListener('click', () => {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        });

        showSlide(currentSlide);

        setInterval(() => {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }, 5000); // Auto slide every 5 seconds
    });
</script>