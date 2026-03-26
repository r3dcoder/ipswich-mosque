@extends('main-layout')

@section('title', 'Prayer Times - Ipswich Mosque')

@section('header')
    <style>
        :root {
            --bg-color: #1a1a1a;
            --card-bg: #2d2d2d;
            --text-primary: #ffffff;
            --text-secondary: #b0b0b0;
            --accent-color: #4f46e5;
            --prayer-active: #10b981;
            --prayer-upcoming: #f59e0b;
            --prayer-past: #6b7280;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-primary);
            font-family: 'Instrument Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Clock Styles */
        .clock-container {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .analog-clock {
            width: 200px;
            height: 200px;
            border: 8px solid #fff;
            border-radius: 50%;
            margin: 0 auto 20px;
            position: relative;
            background: #1a1a1a;
            box-shadow: 0 0 20px rgba(79, 70, 229, 0.3);
        }

        .clock-face {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .hour-marks {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .hour-mark {
            position: absolute;
            width: 4px;
            height: 15px;
            background: #fff;
            top: 5px;
            left: 50%;
            transform-origin: bottom center;
        }

        .hour-mark.long {
            height: 25px;
            width: 6px;
        }

        .clock-center {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 12px;
            height: 12px;
            background: #fff;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
        }

        .hour-hand, .minute-hand, .second-hand {
            position: absolute;
            top: 50%;
            left: 50%;
            transform-origin: bottom center;
            transform: translateX(-50%);
            border-radius: 4px;
        }

        .hour-hand {
            width: 8px;
            height: 60px;
            background: #fff;
            z-index: 8;
        }

        .minute-hand {
            width: 6px;
            height: 80px;
            background: #ccc;
            z-index: 7;
        }

        .second-hand {
            width: 2px;
            height: 90px;
            background: #f59e0b;
            z-index: 6;
        }

        .digital-time {
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 10px;
            text-shadow: 0 0 20px rgba(79, 70, 229, 0.3);
        }

        .date-display {
            font-size: 1.1rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* Prayer Times Section */
        .prayer-times {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .section-title {
            font-size: 1.2rem;
            color: var(--text-secondary);
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .prayer-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
        }

        .prayer-item {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 12px;
            border-left: 4px solid transparent;
            transition: all 0.3s ease;
            text-align: center;
        }

        .prayer-item.active {
            background: rgba(16, 185, 129, 0.1);
            border-left-color: var(--prayer-active);
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.2);
        }

        .prayer-item.upcoming {
            background: rgba(245, 158, 11, 0.1);
            border-left-color: var(--prayer-upcoming);
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.2);
        }

        .prayer-item.past {
            opacity: 0.6;
            border-left-color: var(--prayer-past);
        }

        .prayer-name {
            font-size: 0.8rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .prayer-time {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 5px;
        }

        .prayer-jamaat {
            font-size: 0.7rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .analog-clock {
                width: 150px;
                height: 150px;
            }

            .hour-hand {
                height: 45px;
            }

            .minute-hand {
                height: 60px;
            }

            .second-hand {
                height: 70px;
            }

            .digital-time {
                font-size: 2rem;
            }

            .prayer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .prayer-grid {
                grid-template-columns: 1fr;
            }

            .clock-container {
                padding: 25px;
            }

            .prayer-times {
                padding: 20px;
            }
        }

        /* Animation for active prayer */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        .prayer-item.active {
            animation: pulse 2s infinite;
        }
    </style>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-white mb-2">Ipswich Mosque</h1>
            <p class="text-gray-400" id="dateDisplay">Loading date...</p>
        </div>

        <!-- Clock Section -->
        <div class="clock-container">
            <div class="analog-clock">
                <div class="clock-face">
                    <div class="hour-marks" id="hourMarks"></div>
                    <div class="hour-hand" id="hourHand"></div>
                    <div class="minute-hand" id="minuteHand"></div>
                    <div class="second-hand" id="secondHand"></div>
                    <div class="clock-center"></div>
                </div>
            </div>
            <div class="digital-time" id="digitalClock">00:00:00</div>
            <div class="date-display" id="clockDate">Loading...</div>
        </div>

        <!-- Prayer Times Section -->
        <div class="prayer-times">
            <div class="section-title">Today's Prayer Times</div>
            <div class="prayer-grid" id="prayerGrid">
                <!-- Prayer times will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        // Prayer times data from database
        const prayerTimes = @json($prayerTimes);

        // Islamic date mapping
        const islamicMonths = [
            'Muharram', 'Safar', 'Rabi Al-Awwal', 'Rabi Al-Thani',
            'Jumada Al-Awwal', 'Jumada Al-Thani', 'Rajab', 'Sha\'ban',
            'Ramadan', 'Shawwal', 'Dhul Qa\'dah', 'Dhul Hijjah'
        ];

        // Day names in English
        const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        // Month names in English
        const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Create hour marks for analog clock
        function createHourMarks() {
            const hourMarksContainer = document.getElementById('hourMarks');
            for (let i = 1; i <= 12; i++) {
                const mark = document.createElement('div');
                mark.className = 'hour-mark' + (i % 3 === 0 ? ' long' : '');
                mark.style.transform = `rotate(${i * 30}deg) translateX(-50%)`;
                hourMarksContainer.appendChild(mark);
            }
        }

        function updateAnalogClock() {
            const now = new Date();
            const hours = now.getHours() % 12;
            const minutes = now.getMinutes();
            const seconds = now.getSeconds();

            // Calculate angles
            const hourAngle = (hours * 30) + (minutes * 0.5);
            const minuteAngle = minutes * 6;
            const secondAngle = seconds * 6;

            // Update hands
            document.getElementById('hourHand').style.transform = `translateX(-50%) rotate(${hourAngle}deg)`;
            document.getElementById('minuteHand').style.transform = `translateX(-50%) rotate(${minuteAngle}deg)`;
            document.getElementById('secondHand').style.transform = `translateX(-50%) rotate(${secondAngle}deg)`;
        }

        function updateDigitalClock() {
            const now = new Date();
            
            // Update digital clock
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('digitalClock').textContent = `${hours}:${minutes}:${seconds}`;

            // Update date display
            const dayName = dayNames[now.getDay()];
            const day = now.getDate();
            const monthName = monthNames[now.getMonth()];
            const year = now.getFullYear();
            
            // Simple Hijri date approximation (this is a basic approximation)
            // In a real application, you'd use a proper Hijri conversion library
            const hijriDay = (day + 22) % 30 || 30; // Simple approximation
            const hijriMonth = islamicMonths[(now.getMonth() + 2) % 12];
            const hijriYear = year + 580; // Simple approximation

            document.getElementById('dateDisplay').textContent = 
                `${dayName}, ${day} ${monthName} ${year} | ${hijriDay} ${hijriMonth} ${hijriYear} AH`;

            // Update clock date
            document.getElementById('clockDate').textContent = 
                `${dayName}, ${day} ${monthName} ${year}`;

            // Update prayer times display
            updatePrayerTimes(now);
        }

        function updatePrayerTimes(currentTime) {
            const grid = document.getElementById('prayerGrid');
            grid.innerHTML = '';

            if (!prayerTimes) {
                // Handle case when no prayer times are found
                const item = document.createElement('div');
                item.className = 'prayer-item past';
                item.innerHTML = `
                    <div class="prayer-name">No Data</div>
                    <div class="prayer-time">--:--</div>
                    <div class="prayer-jamaat">Please check prayer times</div>
                `;
                grid.appendChild(item);
                return;
            }

            // Define prayer names and their corresponding fields
            const prayers = [
                { name: 'Fajr', begins: prayerTimes.fajr_begins, jamaat: prayerTimes.fajr_jamaat },
                { name: 'Zuhr', begins: prayerTimes.zuhr_begins, jamaat: prayerTimes.zuhr_jamaat },
                { name: 'Asr', begins: prayerTimes.asr_begins, jamaat: prayerTimes.asr_jamaat },
                { name: 'Maghrib', begins: prayerTimes.maghrib_begins, jamaat: prayerTimes.maghrib_jamaat },
                { name: 'Isha', begins: prayerTimes.isha_begins, jamaat: prayerTimes.isha_jamaat }
            ];

            prayers.forEach(prayer => {
                const item = document.createElement('div');
                item.className = 'prayer-item';
                
                // Create time elements
                const timeDiv = document.createElement('div');
                timeDiv.className = 'prayer-time';
                timeDiv.textContent = prayer.begins || 'N/A';

                const nameDiv = document.createElement('div');
                nameDiv.className = 'prayer-name';
                nameDiv.textContent = prayer.name;

                // Add jamaat time if available
                let jamaatText = '';
                if (prayer.jamaat) {
                    jamaatText = `Jamaat: ${prayer.jamaat}`;
                }
                
                const jamaatDiv = document.createElement('div');
                jamaatDiv.className = 'prayer-jamaat';
                jamaatDiv.textContent = jamaatText;

                // Determine status based on current time
                if (prayer.begins) {
                    const prayerTime = new Date();
                    const [prayerHour, prayerMinute] = prayer.begins.split(':').map(Number);
                    prayerTime.setHours(prayerHour, prayerMinute, 0);

                    const timeDiff = prayerTime - currentTime;
                    const fiveMinutes = 5 * 60 * 1000; // 5 minutes in milliseconds

                    if (timeDiff < 0) {
                        item.classList.add('past');
                    } else if (timeDiff <= fiveMinutes) {
                        item.classList.add('active');
                    } else {
                        item.classList.add('upcoming');
                    }
                } else {
                    item.classList.add('past');
                }

                item.appendChild(nameDiv);
                item.appendChild(timeDiv);
                item.appendChild(jamaatDiv);
                grid.appendChild(item);
            });
        }

        // Initialize
        createHourMarks();
        updateDigitalClock();
        
        // Update every second
        setInterval(() => {
            updateAnalogClock();
            updateDigitalClock();
        }, 1000);
    </script>
@endsection