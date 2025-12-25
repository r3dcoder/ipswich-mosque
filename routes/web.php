<?php

use App\Http\Controllers\Admin\JummahScheduleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DuaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrayerTimesController;
use App\Http\Controllers\ProfileController;
use App\Imports\PrayerTimesImport;
use App\Models\PrayerTime;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', [HomeController::class, 'index']);



Route::get('/donate', function () {
    return view('donate');
});
Route::post('/create-checkout-session', [DonationController::class, 'createCheckoutSession']);

// routes/web.php
Route::post('/create-payment-intent', [DonationController::class, 'createPaymentIntent']);

Route::get('/donation-success', [DonationController::class, 'success'])->name('donation.success');

Route::view('/donate', 'donate');
Route::get('/prayer-times', [PrayerTimesController::class, 'index']);

Route::get('/duas', [DuaController::class, 'index'])->name('duas.index');
Route::get('/duas/{id}', [DuaController::class, 'show'])->name('duas.show');
Route::get('/duas/category/{id}', [DuaController::class, 'category'])->name('duas.category');



Route::get('/clear-cache', function() {
    \Artisan::call('config:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    return 'Caches cleared!';
});



Route::get('/import', function () {

    // 1️⃣ Delete all existing prayer times
    PrayerTime::truncate(); // ⚠️ WARNING: Deletes all rows permanently
    
    Excel::import(new PrayerTimesImport('Jan'), storage_path('app/public/prayers-timetable/Jan.xls'));
    Excel::import(new PrayerTimesImport('Fab'), storage_path('app/public/prayers-timetable/Feb.xls'));
    Excel::import(new PrayerTimesImport('Mar'), storage_path('app/public/prayers-timetable/Mar.xls'));
    Excel::import(new PrayerTimesImport('Apr'), storage_path('app/public/prayers-timetable/Apr.xls'));
    Excel::import(new PrayerTimesImport('May'), storage_path('app/public/prayers-timetable/May.xls'));
    Excel::import(new PrayerTimesImport('Jun'), storage_path('app/public/prayers-timetable/Jun.xls'));
    Excel::import(new PrayerTimesImport('Jul'), storage_path('app/public/prayers-timetable/Jul.xls'));
    Excel::import(new PrayerTimesImport('Aug'), storage_path('app/public/prayers-timetable/Aug.xls'));
    Excel::import(new PrayerTimesImport('Sep'), storage_path('app/public/prayers-timetable/Sep.xls'));
    Excel::import(new PrayerTimesImport('Oct'), storage_path('app/public/prayers-timetable/Oct.xls'));
    Excel::import(new PrayerTimesImport('Nov'), storage_path('app/public/prayers-timetable/Nov.xls'));
    Excel::import(new PrayerTimesImport('Dec'), storage_path('app/public/prayers-timetable/Dec.xls'));

    return 'Imported!';
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/pages', [DashboardController::class, 'pages'])->name('pages');
        Route::get('/duas', [DashboardController::class, 'duas'])->name('duas');
        Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
        Route::get('/payments', [DashboardController::class, 'payments'])->name('payments');
        Route::get('/contacts', [DashboardController::class, 'contacts'])->name('contacts');
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('jummah', JummahScheduleController::class)->except(['show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
