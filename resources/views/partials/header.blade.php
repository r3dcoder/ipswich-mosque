<link rel="stylesheet" href="{{ secure_asset('css/header.css') }}">

<header class="header-root">
    <div class="prayer-ribbon">
        <div class="ribbon-container">
            <div class="jummah-box">
                <span class="jummah-label">Jummah Prayer</span>
                <span class="jummah-time">{{ $dailyPrayerHeader['jummah']->time1 ?? '1.15 PM' }}</span>
            </div>
            
            <div class="prayer-grid-table">
                @if(isset($dailyPrayerHeader['prayers']))
                    @foreach($dailyPrayerHeader['prayers'] as $name => $times)
                        <div class="prayer-column {{ (isset($dailyPrayerHeader['highlighted']) && $dailyPrayerHeader['highlighted'] == $name) ? 'is-active' : '' }}">
                            <div class="p-name">{{ $name }}</div>
                            <div class="time-group">
                                <span class="t-begin">{{ $times['Begins'] }}</span>
                                <span class="t-jamaat">Jamā‘ah {{ $times['Jamaat'] }}</span> 
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <nav class="header-nav">
        <div class="main-nav-container">
            <a href="{{ url('/') }}" class="logo-wrap">
                <img src="{{ asset('images/logo.png') }}" alt="logo" />
                <h1>Ipswich Mosque</h1>
            </a>

            <div class="nav-spacer"></div>

            <ul class="nav-links-wrap">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/ramadan') }}">Ramadan</a></li>
                <li class="dropdown-item">
                    <a href="javascript:void(0)" class="drop-trigger">Services ▼</a>
                    <div class="dropdown-content">
                        <a href="{{ url('/services/marriage') }}">Marriage</a>
                        <a href="{{ url('/services/janaza') }}">Janaza</a>
                        <a href="{{ url('/services/visit') }}">Visit Mosque</a>
                    </div>
                </li>
                <li><a href="{{ url('/duas') }}">Duas</a></li>
                <li><a href="{{ url('/team') }}">Our Team</a></li>
                <li><a href="{{ url('/contact') }}">Contact Us</a></li>
                <li><a href="{{ url('/donate') }}" class="btn-donate-green">Donate Now</a></li>
            </ul>

            <div class="hamburger-icon" id="mobile-toggle">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>

    <div class="mobile-drawer" id="mobile-menu">
        <ul class="mobile-nav-list">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/ramadan') }}">Ramadan</a></li>
            <li><a href="{{ url('/services/marriage') }}">Marriage Service</a></li>
            <li><a href="{{ url('/services/janaza') }}">Janaza Service</a></li>
            <li><a href="{{ url('/duas') }}">Duas</a></li>
            <li><a href="{{ url('/team') }}">Our Team</a></li>
            <li><a href="{{ url('/contact') }}">Contact Us</a></li>
            <li><a href="{{ url('/donate') }}" class="mobile-donate">Donate Now</a></li>
        </ul>
    </div>

    <div class="nav-overlay" id="overlay"></div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('mobile-toggle');
        const menu = document.getElementById('mobile-menu');
        const overlay = document.getElementById('overlay');

        if(toggle) {
            toggle.addEventListener('click', function() {
                this.classList.toggle('is-open');
                menu.classList.toggle('is-visible');
                overlay.classList.toggle('is-visible');
            });
        }

        if(overlay) {
            overlay.addEventListener('click', function() {
                toggle.classList.remove('is-open');
                menu.classList.remove('is-visible');
                this.classList.remove('is-visible');
            });
        }
    });
</script>