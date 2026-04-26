@extends('main-layout')


@section('title', 'Prayer Times - ' . $selectedMonth . ' ' . date('Y') . ' - Ipswich Mosque')
@section('header')
    @include('partials.header')
@endsection



@push('styles')
<style>
    :root {
        --primary-green: #0a5134;
        --primary-green-dark: #084a2f;
        --secondary-green: #166f4a;
        --accent-gold: #d4af37;
        --text-dark: #1e293b;
        --text-light: #64748b;
        --bg-light: #f8fafc;
        --border-color: #e2e8f0;
    }

    /* Header Enhancement */
    .prayer-ribbon {
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
        box-shadow: 0 4px 20px rgba(10, 81, 52, 0.15);
    }

    .jummah-box {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .prayer-column {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .prayer-column:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .prayer-column.is-active {
        background: linear-gradient(135deg, #e8f5e9 0%, #f1f8e9 100%);
        border-color: var(--primary-green);
        box-shadow: 0 8px 25px rgba(10, 81, 52, 0.2);
    }

    .btn-view-timetable {
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
        box-shadow: 0 8px 25px rgba(10, 81, 52, 0.3);
        transition: all 0.3s ease;
    }

    .btn-view-timetable:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(10, 81, 52, 0.4);
    }

    /* Main Content Styling */
    .page-header {
        background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
        border-bottom: 1px solid var(--border-color);
    }

    .month-display {
        font-family: 'Playfair Display', serif;
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Table Styling */
    .prayer-table {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .table-header {
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
        color: white;
    }

    .table-subheader {
        background: #f8fafc;
        color: var(--text-dark);
        font-weight: 600;
    }

    .table-row {
        transition: all 0.3s ease;
        border-bottom: 1px solid var(--border-color);
    }

    .table-row:hover {
        background-color: #f0fdf4;
        transform: translateX(2px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .today-row {
        background: linear-gradient(135deg, #dcfce7 0%, #f0fdf4 50%, #dcfce7 100%);
        border-left: 5px solid var(--primary-green);
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(10, 81, 52, 0.15);
        position: relative;
    }

    .today-row::before {
        content: "TODAY";
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        background: var(--primary-green);
        color: white;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .prayer-time {
        font-weight: 600;
        color: var(--text-dark);
    }

    .jamaat-time {
        background: #e2e8f0;
        color: var(--text-dark);
        font-weight: 700;
        border-radius: 6px;
        padding: 2px 8px;
        display: inline-block;
    }

    /* Month Selector */
    .month-selector {
        background: white;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 8px 16px;
        font-weight: 600;
        color: var(--text-dark);
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .month-selector:hover {
        border-color: var(--primary-green);
        box-shadow: 0 8px 25px rgba(10, 81, 52, 0.15);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .month-display {
            font-size: 1.5rem;
        }
        
        .prayer-table {
            border-radius: 12px;
        }
    }

    /* Animation for active prayer */
    @keyframes pulseActive {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }

    .prayer-column.is-active {
        animation: pulseActive 2s infinite;
    }
</style>
@endpush

@section('content')
    <!-- Page Header -->
    <section class="page-header py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="month-display text-4xl md:text-6xl font-bold mb-4">
                    Prayer Times
                </h1>
                <p class="text-lg text-gray-600 mb-6">
                    {{ $selectedMonth }} {{ date('Y') }} | {{ $prayerTimes->first()->hijri_month ?? '' }} - {{ $prayerTimes->first()->hijri_year ?? '' }} A.H.
                </p>
                
                <!-- Month Selector -->
                <div class="inline-block">
                    <form method="GET" action="{{ url('/prayer-times') }}" class="flex items-center gap-4">
                        <label for="month" class="text-sm font-medium text-gray-700">Select Month:</label>
                        <select name="month" id="month" onchange="this.form.submit()" class="month-selector">
                            @foreach($months as $month)
                                <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>
                                    {{ $month }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Prayer Times Table -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="prayer-table overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <!-- Header Row -->
                        <thead>
                            <tr class="table-header">
                                <th colspan="13" class="py-6 px-4 text-2xl font-bold">
                                    {{ strtoupper($selectedMonth) }} Prayer Schedule
                                </th>
                            </tr>
                            
                            <!-- Subheader Row -->
                            <tr class="table-subheader">
                                <th class="border-r border-gray-200 px-4 py-4 text-left font-semibold">Date</th>
                                <th class="border-r border-gray-200 px-4 py-4 text-left font-semibold">Day</th>
                                <th colspan="2" class="border-r border-gray-200 px-4 py-4 text-center font-semibold">Fajr</th>
                                <th class="border-r border-gray-200 px-4 py-4 text-center font-semibold">Sunrise</th>
                                <th colspan="2" class="border-r border-gray-200 px-4 py-4 text-center font-semibold">Zuhr</th>
                                <th colspan="2" class="border-r border-gray-200 px-4 py-4 text-center font-semibold">Asr</th>
                                <th colspan="2" class="border-r border-gray-200 px-4 py-4 text-center font-semibold">Maghrib</th>
                                <th class="px-4 py-4 text-center font-semibold">Isha</th>
                            </tr>
                            
                            <!-- Time Labels Row -->
                            <tr class="bg-gray-50">
                                <th class="border-r border-gray-200 px-4 py-3 text-xs text-gray-500 uppercase tracking-wider">DD</th>
                                <th class="border-r border-gray-200 px-4 py-3 text-xs text-gray-500 uppercase tracking-wider">Day</th>
                                <th class="border-r border-gray-200 px-4 py-3 text-xs text-gray-500 uppercase tracking-wider">Begins</th>
                                <th class="border-r border-gray-200 px-4 py-3 text-xs text-gray-500 uppercase tracking-wider">Jama'at</th>
                                <th class="border-r border-gray-200 px-4 py-3 text-xs text-gray-500 uppercase tracking-wider">Rise</th>
                                <th class="border-r border-gray-200 px-4 py-3 text-xs text-gray-500 uppercase tracking-wider">Begins</th>
                                <th class="border-r border-gray-200 px-4 py-3 text-xs text-gray-500 uppercase tracking-wider">Jama'at</th>
                                <th class="border-r border-gray-200 px-4 py-3 text-xs text-gray-500 uppercase tracking-wider">Begins</th>
                                <th class="border-r border-gray-200 px-4 py-3 text-xs text-gray-500 uppercase tracking-wider">Jama'at</th>
                                <th class="border-r border-gray-200 px-4 py-3 text-xs text-gray-500 uppercase tracking-wider">Begins</th>
                                <th class="border-r border-gray-200 px-4 py-3 text-xs text-gray-500 uppercase tracking-wider">Jama'at</th>
                                <th class="px-4 py-3 text-xs text-gray-500 uppercase tracking-wider">Begins</th>
                                <th class="px-4 py-3 text-xs text-gray-500 uppercase tracking-wider">Jama'at</th>
                            </tr>
                        </thead>
                        
                        <!-- Body -->
                        <tbody>
                            @foreach($prayerTimes as $time)
                                <tr class="table-row {{ ($highlightToday && $time->date == $today) ? 'today-row' : '' }}">
                                    <td class="border-r border-gray-200 px-4 py-4 font-medium">{{ $time->date }}</td>
                                    <td class="border-r border-gray-200 px-4 py-4 text-gray-600">{{ $time->day }}</td>
                                    <td class="border-r border-gray-200 px-4 py-4">
                                        <span class="prayer-time">{{ $time->fajr_begins }}</span>
                                    </td>
                                    <td class="border-r border-gray-200 px-4 py-4">
                                        <span class="jamaat-time">{{ $time->fajr_jamaat }}</span>
                                    </td>
                                    <td class="border-r border-gray-200 px-4 py-4">
                                        <span class="prayer-time">{{ $time->sunrise }}</span>
                                    </td>
                                    <td class="border-r border-gray-200 px-4 py-4">
                                        <span class="prayer-time">{{ $time->zuhr_begins }}</span>
                                    </td>
                                    <td class="border-r border-gray-200 px-4 py-4">
                                        <span class="jamaat-time">{{ $time->zuhr_jamaat }}</span>
                                    </td>
                                    <td class="border-r border-gray-200 px-4 py-4">
                                        <span class="prayer-time">{{ $time->asr_begins }}</span>
                                    </td>
                                    <td class="border-r border-gray-200 px-4 py-4">
                                        <span class="jamaat-time">{{ $time->asr_jamaat }}</span>
                                    </td>
                                    <td class="border-r border-gray-200 px-4 py-4">
                                        <span class="prayer-time">{{ $time->maghrib_begins }}</span>
                                    </td>
                                    <td class="border-r border-gray-200 px-4 py-4">
                                        <span class="jamaat-time">{{ $time->maghrib_jamaat }}</span>
                                    </td>
                                    <td class="border-r border-gray-200 px-4 py-4">
                                        <span class="prayer-time">{{ $time->isha_begins }}</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="jamaat-time">{{ $time->isha_jamaat }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Legend -->
            <div class="mt-6 bg-white rounded-lg p-4 border border-gray-200">
                <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                    <span class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-green-100 border-2 border-green-500 rounded-full"></span>
                        Today's prayers
                    </span>
                    <span class="flex items-center gap-2">
                        <span class="px-2 py-1 bg-gray-100 rounded text-gray-700">Jama'at</span>
                        Congregation time
                    </span>
                    <span class="flex items-center gap-2">
                        <span class="px-2 py-1 bg-transparent border border-gray-300 rounded text-gray-700">Begins</span>
                        Prayer time begins
                    </span>
                </div>
            </div>
        </div>
    </section>

    @include('partials.map-section')
    @include('partials.footer')
@endsection