<div class="header">
    <div class="overlay"></div>

    <div class="prayer-times-section   ">
        <div class="prayer-left">

            <p class="date"> {{ $dailyPrayerHeader['date'] }} · {{ $dailyPrayerHeader['hijri_date'] }}</p>
            <p class="juma">JUM'A 1.30PM PRAYER TIMES</p>
            
        </div>
         @if(!empty($dailyPrayerHeader))
            <div class="prayer-right text-xl   rounded-sm shadow-sm">
                <table class="w-full text-center border border-gray-100 ">
                    <thead class="  text-white">
                        <tr>
                            <th></th>
                            @foreach($dailyPrayerHeader['prayers'] as $name => $times)
                                <th  class="{{ $dailyPrayerHeader['highlighted'] === $name ? 'bg-teal-100 rounded-2xl text-white' : '' }}">{{ $name }}</th>
                            @endforeach
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-semibold">Begins</td>
                            @foreach($dailyPrayerHeader['prayers'] as $times)
                                <td>{{ $times['Begins'] }}</td>
                            @endforeach

                        </tr>
                        
                        <tr>
                            <td class="font-semibold">Jamā‘ah</td>
                            @foreach($dailyPrayerHeader['prayers'] as $times)
                                <td>{{ $times['Jamaat'] }}</td>
                            @endforeach
                            
                        </tr>
                    </tbody>
                    
                </table>
                <a href={{ url('/prayer-times') }}><p class="text-[10px]">Full Timetable & Calendar</p></a>

            </div>
        @endif

    </div>



    <nav class="items-center">
        <div class="logo">
            <img src="{{ asset("images/logo.png") }}" alt="logo" />
            <h1>Ipswich Mosque</h1>

        </div>
        <ul class="">
            <li>
                <a href={{ url('/') }}>Home</a>
            </li>
            <li>
                <a href="#">Services</a>
            </li>
            <li>
                <a href="#">Blog</a>
            </li>
            <li>
                <a href="#">Contact Us</a>
            </li>
            <li>
                <a href={{ url('/donate') }} class="donate-btn flex gap-1">
                    <div>Donate</div>
                </a>

            </li>
        </ul>
        <div class="hamburger">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
    </nav>
    <div class="menubar">


        <ul>
            <li>
                <div class="logo">
                    <img src="{{ asset("images/logo.png") }}" alt="logo" />
                </div>
            </li>
            <li>
                <a href="#">Home</a>
            </li>
            <li>
                <a href="#">Services</a>
            </li>
            <li>
                <a href="#">Blog</a>
            </li>
            <li>
                <a href="#">Contact Us</a>
            </li>
            <li>
                <a href="#" class="donate-btn">Donate</a>
            </li>
        </ul>
    </div>
</div>

<script>
    const mobileNav = document.querySelector(".hamburger");
    const navbar = document.querySelector(".menubar");
    const overlay = document.querySelector(".overlay");


    const toggleNav = () => {
        navbar.classList.toggle("active");
        mobileNav.classList.toggle("hamburger-active");
        overlay.classList.toggle("active");

    };
    mobileNav.addEventListener("click", () => toggleNav());
    overlay.addEventListener("click", () => toggleNav());

</script>