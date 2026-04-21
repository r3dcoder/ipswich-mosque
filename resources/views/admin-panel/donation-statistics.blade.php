@extends('layouts.dashboard')

@section('title', 'Donation Statistics')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('admin.donations') }}" class="text-emerald-600 hover:text-emerald-800 mb-2 inline-flex items-center gap-1">
            ← Back to Donations
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Donation Statistics</h1>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ route('admin.donations.statistics') }}" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date', $startDate) }}"
                       class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date', $endDate) }}"
                       class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                    Update Report
                </button>
            </div>
        </form>
    </div>

    <!-- Period Comparison Cards -->
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Period Overview</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Daily Stats -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-600">Today</h3>
                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $dailyAmountChange >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $dailyAmountChange >= 0 ? '+' : '' }}{{ number_format($dailyAmountChange, 1) }}%
                </span>
            </div>
            <p class="text-2xl font-bold text-gray-900">£{{ number_format($todayAmount, 2) }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $todayCount }} donations</p>
            <div class="mt-3 pt-3 border-t border-gray-100">
                <p class="text-xs text-gray-400">Yesterday: £{{ number_format($yesterdayAmount, 2) }} ({{ $yesterdayCount }} donations)</p>
            </div>
        </div>

        <!-- Weekly Stats -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-600">This Week</h3>
                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $weeklyAmountChange >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $weeklyAmountChange >= 0 ? '+' : '' }}{{ number_format($weeklyAmountChange, 1) }}%
                </span>
            </div>
            <p class="text-2xl font-bold text-gray-900">£{{ number_format($thisWeekAmount, 2) }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $thisWeekCount }} donations</p>
            <div class="mt-3 pt-3 border-t border-gray-100">
                <p class="text-xs text-gray-400">Last Week: £{{ number_format($lastWeekAmount, 2) }} ({{ $lastWeekCount }} donations)</p>
            </div>
        </div>

        <!-- Monthly Stats -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-600">This Month</h3>
                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $monthlyAmountChange >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $monthlyAmountChange >= 0 ? '+' : '' }}{{ number_format($monthlyAmountChange, 1) }}%
                </span>
            </div>
            <p class="text-2xl font-bold text-gray-900">£{{ number_format($thisMonthAmount, 2) }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $thisMonthCount }} donations</p>
            <div class="mt-3 pt-3 border-t border-gray-100">
                <p class="text-xs text-gray-400">Last Month: £{{ number_format($lastMonthAmount, 2) }} ({{ $lastMonthCount }} donations)</p>
            </div>
        </div>

        <!-- Yearly Stats -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-600">This Year</h3>
                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $yearlyAmountChange >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $yearlyAmountChange >= 0 ? '+' : '' }}{{ number_format($yearlyAmountChange, 1) }}%
                </span>
            </div>
            <p class="text-2xl font-bold text-gray-900">£{{ number_format($thisYearAmount, 2) }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $thisYearCount }} donations</p>
            <div class="mt-3 pt-3 border-t border-gray-100">
                <p class="text-xs text-gray-400">Last Year: £{{ number_format($lastYearAmount, 2) }} ({{ $lastYearCount }} donations)</p>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Overall Summary</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-emerald-100 text-emerald-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Total Donations</h3>
                    <p class="text-2xl font-bold text-gray-900">£{{ number_format($totalAmount, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Total Count</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalDonations) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Average Donation</h3>
                    <p class="text-2xl font-bold text-gray-900">£{{ number_format($averageDonation, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-emerald-100 text-emerald-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Gift Aid Potential</h3>
                    <p class="text-2xl font-bold text-emerald-600">£{{ number_format($giftAidPotential, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Trend Chart -->
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Daily Trend (Last 30 Days)</h2>
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="relative" style="height: 300px;">
            <canvas id="dailyTrendChart"></canvas>
        </div>
    </div>

    <!-- Weekly Trend Chart -->
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Weekly Trend (Last 12 Weeks)</h2>
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="relative" style="height: 300px;">
            <canvas id="weeklyTrendChart"></canvas>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Monthly Trend Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Monthly Donation Trend</h2>
            <div class="relative" style="height: 300px;">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <!-- Category Pie Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Donations by Category</h2>
            <div class="relative" style="height: 300px;">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Second Row of Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Type Bar Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Donations by Type</h2>
            <div class="relative" style="height: 300px;">
                <canvas id="typeChart"></canvas>
            </div>
        </div>

        <!-- Status Doughnut Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Donation Status</h2>
            <div class="relative" style="height: 300px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Prepare data for charts
    const monthlyData = @json($monthlyData);
    const categoryData = @json($categoryData);
    const typeData = @json($typeData);
    const statusData = @json($statusData);
    const dailyTrendData = @json($dailyTrendData);
    const weeklyTrendData = @json($weeklyTrendData);

    // Chart.js default colors
    const colors = {
        emerald: '#10B981',
        blue: '#3B82F6',
        purple: '#8B5CF6',
        amber: '#F59E0B',
        red: '#EF4444',
        gray: '#6B7280',
        teal: '#14B8A6',
        indigo: '#6366F1',
        pink: '#EC4899',
        orange: '#F97316',
        yellow: '#EAB308',
        green: '#22C55E'
    };

    // Daily Trend Chart (Line)
    new Chart(document.getElementById('dailyTrendChart'), {
        type: 'line',
        data: {
            labels: dailyTrendData.map(d => d.date),
            datasets: [{
                label: 'Donation Amount (£)',
                data: dailyTrendData.map(d => d.amount),
                borderColor: colors.emerald,
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: colors.emerald,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4
            }, {
                label: 'Donation Count',
                data: dailyTrendData.map(d => d.count),
                borderColor: colors.blue,
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: colors.blue,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount (£)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Count'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Weekly Trend Chart (Line)
    new Chart(document.getElementById('weeklyTrendChart'), {
        type: 'line',
        data: {
            labels: weeklyTrendData.map(d => d.week),
            datasets: [{
                label: 'Donation Amount (£)',
                data: weeklyTrendData.map(d => d.amount),
                borderColor: colors.purple,
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: colors.purple,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4
            }, {
                label: 'Donation Count',
                data: weeklyTrendData.map(d => d.count),
                borderColor: colors.amber,
                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: colors.amber,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount (£)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Count'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Monthly Trend Chart (Line)
    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: monthlyData.map(d => d.month),
            datasets: [{
                label: 'Donation Amount (£)',
                data: monthlyData.map(d => d.amount),
                borderColor: colors.emerald,
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: colors.emerald,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }, {
                label: 'Donation Count',
                data: monthlyData.map(d => d.count),
                borderColor: colors.blue,
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: colors.blue,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount (£)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Count'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Category Pie Chart
    new Chart(document.getElementById('categoryChart'), {
        type: 'pie',
        data: {
            labels: Object.values(categoryData).map(d => d.label),
            datasets: [{
                data: Object.values(categoryData).map(d => d.amount),
                backgroundColor: [
                    colors.emerald, colors.blue, colors.purple, colors.amber,
                    colors.red, colors.gray, colors.teal, colors.indigo,
                    colors.pink, colors.orange
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.raw / total) * 100).toFixed(1);
                            return `${context.label}: £${context.raw.toFixed(2)} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Type Bar Chart
    new Chart(document.getElementById('typeChart'), {
        type: 'bar',
        data: {
            labels: Object.values(typeData).map(d => d.label),
            datasets: [{
                label: 'Amount (£)',
                data: Object.values(typeData).map(d => d.amount),
                backgroundColor: [colors.blue, colors.emerald],
                borderColor: [colors.blue, colors.emerald],
                borderWidth: 2
            }, {
                label: 'Count',
                data: Object.values(typeData).map(d => d.count),
                backgroundColor: [colors.purple, colors.amber],
                borderColor: [colors.purple, colors.amber],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Value'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Status Doughnut Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(statusData).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: [
                    colors.emerald, // completed
                    colors.yellow,  // pending
                    colors.red,     // failed
                    colors.gray     // cancelled
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.raw / total) * 100).toFixed(1);
                            return `${context.label}: ${context.raw} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
</script>
@endsection