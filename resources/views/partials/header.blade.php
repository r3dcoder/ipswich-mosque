 
<header class="header-root">
    <div class="prayer-ribbon">
        <div class="ribbon-container">
            <div class="jummah-box">
                <span class="jummah-label">Jummah Prayer</span>
                <span class="jummah-time">
                    @if(isset($dailyPrayerHeader['jummah']) && $dailyPrayerHeader['jummah'])
                        {{ $dailyPrayerHeader['jummah']->zuhr_jamaat ?? '1:15 PM' }}
                    @else
                        1:15 PM
                    @endif
                </span>
            </div>
            
            <div class="prayer-grid-table">
                @if(isset($dailyPrayerHeader['prayers']))
                    @foreach($dailyPrayerHeader['prayers'] as $name => $times)
                        <div class="prayer-column {{ (isset($dailyPrayerHeader['highlighted']) && $dailyPrayerHeader['highlighted'] == $name) ? 'is-active' : '' }}">
                            <div class="p-name">
                                @if($name === 'Sunrise')
                                    <span class="sunrise-icon">🌅</span>
                                @endif
                                {{ $name }}
                            </div>
                            <div class="time-group">
                                <span class="t-begin">{{ $times['Begins'] }}</span>
                                @if($times['Jamaat'])
                                    <span class="t-jamaat">Jamā'a {{ $times['Jamaat'] }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            
            <div class="prayer-actions">
                <a href="{{ url('/prayer-times') }}" class="btn-view-timetable">View Full Timetable</a>
            </div>
        </div>
    </div>

    @php
        $headerSettings = \App\Models\MosqueSetting::getSettings();
    @endphp

    <nav class="header-nav">
        <div class="main-nav-container">
            <a href="{{ url('/') }}" class="logo-wrap">
                @if($headerSettings->logo_url)
                    <img src="{{ $headerSettings->logo_url }}" alt="{{ $headerSettings->name ?? 'Ipswich Mosque' }} Logo" />
                @else
                    <img src="{{ asset('images/logo.png') }}" alt="logo" />
                @endif
                <h1>{{ $headerSettings->name ?? 'Ipswich Mosque' }}</h1>
            </a>

            <div class="nav-spacer"></div>

            <ul class="nav-links-wrap">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="dropdown-item">
                    <a href="javascript:void(0)" class="drop-trigger">Our Services ▼</a>
                    <div class="dropdown-content">
                        <a href="{{ url('/ramadan') }}">Ramadan</a>
                        <a href="{{ url('/services/marriage') }}">Marriage (Nikah)</a>
                        <a href="{{ url('/services/janazah') }}">Funeral (Janazah)</a>
                        <a href="{{ url('/services/visit') }}">Visit Mosque</a>
                     </div>
                </li>
                <li>
                    <a href="{{ url('/khutbah') }}" class="khutbah-nav-link">
                        <span class="nav-link-text">Khutbah</span>
                        @if(isset($liveStream) && $liveStream)
                            <span class="live-indicator">
                                <span class="live-dot"></span>
                                LIVE
                            </span>
                        @endif
                    </a>
                </li>
                <li class="dropdown-item">
                    <a href="javascript:void(0)" class="drop-trigger">Community ▼</a>
                    <div class="dropdown-content">
                        <a href="{{ route('notices.index') }}">Notice Board</a>
                        <a href="{{ route('newsletters.index') }}">Newsletter</a>
                        <a href="{{ url('/people') }}">Our People</a>
                    </div>
                </li>
                <li><a href="{{ url('/duas') }}">Duas</a></li>
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
            <li><a href="{{ url('/') }}">🏠 Home</a></li>
            
            <!-- Services Dropdown -->
            <li class="mobile-dropdown">
                <div class="mobile-dropdown-trigger" onclick="toggleMobileDropdown(this)">
                    <span>🕌 Our Services</span>
                    <span class="dropdown-arrow">▼</span>
                </div>
                <ul class="mobile-dropdown-content">
                    <li><a href="{{ url('/ramadan') }}">Ramadan</a></li>
                    <li><a href="{{ url('/services/marriage') }}">Marriage (Nikah)</a></li>
                    <li><a href="{{ url('/services/janazah') }}">Funeral (Janazah)</a></li>
                    <li><a href="{{ url('/services/visit') }}">Visit Mosque</a></li>
                </ul>
            </li>
            
            <li><a href="{{ url('/khutbah') }}">📖 Khutbah</a></li>
            
            <!-- Community Dropdown -->
            <li class="mobile-dropdown">
                <div class="mobile-dropdown-trigger" onclick="toggleMobileDropdown(this)">
                    <span>👥 Community</span>
                    <span class="dropdown-arrow">▼</span>
                </div>
                <ul class="mobile-dropdown-content">
                    <li><a href="{{ route('notices.index') }}">Notice Board</a></li>
                    <li><a href="{{ route('newsletters.index') }}">Newsletter</a></li>
                    <li><a href="{{ url('/people') }}">Our People</a></li>
                </ul>
            </li>
            
            <li><a href="{{ url('/duas') }}">🤲 Duas</a></li>
            <li><a href="{{ url('/contact') }}">📧 Contact Us</a></li>
            <li><a href="{{ url('/donate') }}" class="mobile-donate">💚 Donate Now</a></li>
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
                // Prevent body scroll when menu is open
                document.body.style.overflow = menu.classList.contains('is-visible') ? 'hidden' : '';
            });
        }

        if(overlay) {
            overlay.addEventListener('click', function() {
                toggle.classList.remove('is-open');
                menu.classList.remove('is-visible');
                this.classList.remove('is-visible');
                document.body.style.overflow = '';
            });
        }
    });

    // Mobile dropdown toggle function
    function toggleMobileDropdown(element) {
        const parent = element.parentElement;
        const isOpen = parent.classList.contains('is-open');
        
        // Close all other dropdowns
        document.querySelectorAll('.mobile-dropdown.is-open').forEach(function(dropdown) {
            if (dropdown !== parent) {
                dropdown.classList.remove('is-open');
            }
        });
        
        // Toggle current dropdown
        parent.classList.toggle('is-open', !isOpen);
    }
</script>
