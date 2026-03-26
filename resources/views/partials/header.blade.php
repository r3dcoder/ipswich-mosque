@php
    $dailyPrayerHeader = $dailyPrayerHeader ?? [];
@endphp

<style>
    .dropdown { position: relative; }
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #fff;
        min-width: 160px;
        box-shadow: 0px 8px 16px rgba(0,0,0,0.1);
        z-index: 100;
        border-radius: 4px;
        top: 100%;
    }
    .dropdown-content a {
        color: #000 !important;
        padding: 12px 16px !important;
        display: block !important;
        text-decoration: none;
        font-size: 14px;
    }
    .dropdown-content a:hover { background-color: #f1f1f1; }
    .dropdown:hover .dropdown-content { display: block; }

    /* Mobile Menu Dropdown Adjustment */
    .mobile-sub { padding-left: 20px !important; font-size: 0.9rem !important; opacity: 0.8; }
</style>

<div class="header">
    <div class="overlay"></div>

    <div class="prayer-times-section">
        <div class="prayer-left">
             <p class="date">
                {{ $dailyPrayerHeader['date'] ?? '' }}
                ·
                {{ $dailyPrayerHeader['hijri_date'] ?? '' }}
            </p>
            <p class="juma"><span class="font-medium">Jummah Khutbah: </span>{{ $dailyPrayerHeader['jummah']->khutbah_formatted ?? '—' }}</p>
            <p class="juma"><span class="font-medium">And Salah: </span>{{ $dailyPrayerHeader['jummah']->salah_formatted ?? '—' }}</p>
            <p class="juma"><span class="font-medium"> </span>{{ $dailyPrayerHeader['jummah']->note ?? '' }}</p>
        </div>

         @if(!empty($dailyPrayerHeader))
            <div class="prayer-right text-xl rounded-sm shadow-sm">
                <table class="w-full text-center border border-gray-100">
                    <thead class="text-white">
                        <tr>
                            <th></th>
                            @foreach($dailyPrayerHeader['prayers'] as $name => $times)
                                <th class="{{ ($dailyPrayerHeader['highlighted'] ?? '') === $name ? 'bg-teal-100 rounded-2xl text-white' : '' }}">{{ $name }}</th>
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
                <a href="{{ url('/prayer-times') }}"><p class="text-[10px]">Full Timetable & Calendar</p></a>
            </div>
        @endif
    </div>

    <nav class="items-center">
        <a href="{{ url('/') }}">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="logo" />
                <h1>Ipswich Mosque.</h1>
             </div>
        </a>
        
        <ul>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/ramadan') }}">Ramadan</a></li>
            
            <li class="dropdown">
                <a href="#">Services ▼</a>
                <div class="dropdown-content">
                    <a href="{{ url('/services/marriage') }}">Marriage</a>
                    <a href="{{ url('/services/janaza') }}">Janaza</a>
                    <a href="{{ url('/services/visit') }}">Visit Mosque</a>
                </div>
            </li>

            <li><a href="{{ url('/duas') }}">Duas</a></li>
            <li><a href="{{ url('/people') }}">Our Team</a></li>
            <li><a href="{{ url('/contact') }}">Contact Us</a></li>
            <li>
                <a href="{{ url('/donate') }}" class="donate-btn flex gap-1">
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
                <a href="{{ url('/') }}">
                    <div class="logo">
                        <img src="{{ asset('images/logo.png') }}" alt="logo" />
                    </div>
                </a>
            </li>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/ramadan') }}">Ramadan</a></li>
            
            <li><a href="#" style="font-weight: bold; color: #0a5134;">Services:</a></li>
            <li><a href="{{ url('/services/marriage') }}" class="mobile-sub">Marriage</a></li>
            <li><a href="{{ url('/services/janaza') }}" class="mobile-sub">Janaza</a></li>
            <li><a href="{{ url('/services/visit') }}" class="mobile-sub">Visit Mosque</a></li>

            <li><a href="{{ url('/duas') }}">Duas</a></li>
            <li><a href="{{ url('/people') }}">Our Team</a></li>
            <li><a href="{{ url('/contact') }}">Contact Us</a></li>
            <li><a href="{{ url('/donate') }}" class="donate-btn">Donate</a></li>
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