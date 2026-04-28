<?php

use App\Http\Controllers\Admin\AdminDuaController;
use App\Http\Controllers\Admin\CarouselSlideController;
use App\Http\Controllers\Admin\CoursesController;
use App\Http\Controllers\Admin\EditorController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FuneralBookingController as AdminFuneralBookingController;
use App\Http\Controllers\Admin\GiftAidController;
use App\Http\Controllers\Admin\JummahScheduleController;
use App\Http\Controllers\Admin\KhutbahController as AdminKhutbahController;
use App\Http\Controllers\Admin\MarriageBookingController as AdminMarriageBookingController;
use App\Http\Controllers\Admin\MosqueSettingController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\PageBlockController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PrayerTimeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RamadanController;
use App\Http\Controllers\Admin\RamadanEventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DuaController;
use App\Http\Controllers\FuneralController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KhutbahController;
use App\Http\Controllers\MarriageBookingController;
use App\Http\Controllers\PrayerTimesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPageController;
use App\Imports\PrayerTimesImport;
use App\Models\PrayerTime;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Admin\DuaCategoryController;
 
 
Route::get('/', [HomeController::class, 'index']);


Route::get('/clear-cache', function() {
    \Artisan::call('config:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    return 'Caches cleared!';
});

Route::get('/donate', function () {
    return view('donate');
});

// Donation payment routes
Route::post('/create-payment-intent', [DonationController::class, 'createPaymentIntent']);
Route::get('/donation-success', [DonationController::class, 'success'])->name('donation.success');
Route::post('/stripe-webhook', [DonationController::class, 'handleWebhook']);
Route::post('/confirm-payment', [DonationController::class, 'confirmPayment']);

Route::get('/ramadan', function () {
    return view('ramadan');
});


Route::get('/prayer-timing-screen', function () {
    return view('prayer-timing-screen');
});

Route::get('/people', function () {
    return view('people');
});

// Contact Routes
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// Marriage Booking Routes
Route::get('/services/marriage', [MarriageBookingController::class, 'show'])->name('marriage.show');
Route::post('/services/marriage/booking', [MarriageBookingController::class, 'store'])->name('marriage.booking.store');
// Route::get('/services/janaza', function () { return view('services.janaza'); })->name('janaza.show');
Route::get('/services/visit', function () { return view('services.visit'); })->name('visit.show');

// Route::get('/services/janazah', [MarriageBookingController::class, 'show'])->name('marriage.show');
Route::get('/khutbah', [KhutbahController::class, 'index'])->name('khutbah.index');

Route::get('/services/janazah', [FuneralController::class, 'show'])->name('janazah.show');
Route::post('/services/janazah', [FuneralController::class, 'store'])->name('janazah.store');


// Admin Contact Routes
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('contacts', \App\Http\Controllers\Admin\ContactController::class)
             ->except(['create', 'edit', 'update'])
             ->names([
                 'index'   => 'contacts.index',
                 'show'    => 'contacts.show',
                 'destroy' => 'contacts.destroy',
             ]);
        
        Route::post('contacts/{contact}/mark-as-read', [\App\Http\Controllers\Admin\ContactController::class, 'markAsRead'])
             ->name('contacts.markAsRead');
        
        Route::get('contacts/unread/count', [\App\Http\Controllers\Admin\ContactController::class, 'getUnreadCount'])
             ->name('contacts.unreadCount');
    });

Route::post('/create-checkout-session', [DonationController::class, 'createCheckoutSession']);

Route::get('/donation-success', [DonationController::class, 'success'])->name('donation.success');
Route::get('/prayer-times', [PrayerTimesController::class, 'index']);
Route::get('/prayer-timing-screen', [PrayerTimesController::class, 'timingScreen']);

Route::get('/duas', [DuaController::class, 'index'])->name('duas.index');
Route::get('/duas/{id}', [DuaController::class, 'show'])->name('duas.show');
Route::get('/duas/category/{id}', [DuaController::class, 'category'])->name('duas.category');

// Public Notice Board Routes
Route::get('/notices', [App\Http\Controllers\NewsletterSubscriptionController::class, 'notices'])->name('notices.index');
Route::get('/notices/{notice}', [App\Http\Controllers\NewsletterSubscriptionController::class, 'showNotice'])->name('notices.show');

// Public Newsletter Routes
Route::get('/newsletters', [App\Http\Controllers\NewsletterSubscriptionController::class, 'newsletters'])->name('newsletters.index');
Route::get('/newsletters/{newsletter}', [App\Http\Controllers\NewsletterSubscriptionController::class, 'showNewsletter'])->name('newsletters.show');

// Public Newsletter Subscription Routes
Route::post('/newsletter/subscribe', [App\Http\Controllers\NewsletterSubscriptionController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [App\Http\Controllers\NewsletterSubscriptionController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
Route::get('/newsletter/resubscribe/{token}', [App\Http\Controllers\NewsletterSubscriptionController::class, 'resubscribe'])->name('newsletter.resubscribe');


Route::get('/{slug}', [PublicPageController::class, 'show'])
    ->where('slug', '^(?!admin|login|register|storage|api|css|js|services|import).*$')
    ->name('page.show');

 


Route::get('/import', function () {

    // 1️⃣ Delete all existing prayer times
    PrayerTime::truncate(); // ⚠️ WARNING: Deletes all rows permanently
    
    Excel::import(new PrayerTimesImport('Jan'), public_path('prayers-timetable/Jan.xls'));
    Excel::import(new PrayerTimesImport('Feb'), public_path('prayers-timetable/Feb.xls'));
    Excel::import(new PrayerTimesImport('Mar'), public_path('prayers-timetable/Mar.xls'));
    Excel::import(new PrayerTimesImport('Apr'), public_path('prayers-timetable/Apr.xls'));
    Excel::import(new PrayerTimesImport('May'), public_path('prayers-timetable/May.xls'));
    Excel::import(new PrayerTimesImport('Jun'), public_path('prayers-timetable/Jun.xls'));
    Excel::import(new PrayerTimesImport('Jul'), public_path('prayers-timetable/Jul.xls'));
    Excel::import(new PrayerTimesImport('Aug'), public_path('prayers-timetable/Aug.xls'));
    Excel::import(new PrayerTimesImport('Sep'), public_path('prayers-timetable/Sep.xls'));
    Excel::import(new PrayerTimesImport('Oct'), public_path('prayers-timetable/Oct.xls'));
    Excel::import(new PrayerTimesImport('Nov'), public_path('prayers-timetable/Nov.xls'));
    Excel::import(new PrayerTimesImport('Dec'), public_path('prayers-timetable/Dec.xls'));

    return 'Imported!';
});

Route::get('/dashboard', function () {
    return redirect()->route('admin');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'home'])->name('admin');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/pages', [AdminController::class, 'pages'])->name('pages');
        Route::get('/duas', [AdminController::class, 'duas'])->name('duas');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::get('/payments', [AdminController::class, 'payments'])->name('payments');
        Route::get('/donations', [AdminController::class, 'donations'])->name('donations');
        Route::get('/donations/statistics', [AdminController::class, 'donationStatistics'])->name('donations.statistics');
        // Note: contacts routes are defined earlier as resource routes (admin.contacts.index, etc.)
        // Ramadan CRUD
  
    });
});

 
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('ramadan', RamadanController::class)->names('ramadan'); // 👈 this is key
    
        Route::resource('ramadan.events', RamadanEventController::class)
             ->names([
                 'index'   => 'ramadan.events.index',
                 'create'  => 'ramadan.events.create',
                 'store'   => 'ramadan.events.store',
                 'edit'    => 'ramadan.events.edit',
                 'update'  => 'ramadan.events.update',
                 'destroy' => 'ramadan.events.destroy',
             ])
             ->parameters([
                 'ramadan' => 'ramadan',
                 'events'  => 'event'
             ]);
    
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('jummah', JummahScheduleController::class)->except(['show']);
    
    Route::resource('carousel-slides', CarouselSlideController::class)->except(['show']);

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Sections
    Route::get('courses', [CoursesController::class, 'index'])->name('courses.index');
    Route::get('courses/create', [CoursesController::class, 'create'])->name('courses.create');
    Route::post('courses', [CoursesController::class, 'store'])->name('courses.store');
    Route::get('courses/{section}/edit', [CoursesController::class, 'edit'])->name('courses.edit');
    Route::put('courses/{section}', [CoursesController::class, 'update'])->name('courses.update');
    Route::delete('courses/{section}', [CoursesController::class, 'destroy'])->name('courses.destroy');

    // Courses inside a section
    Route::post('courses/{section}/courses', [CoursesController::class, 'storeCourse'])->name('courses.courses.store');
    Route::put('courses/course/{course}', [CoursesController::class, 'updateCourse'])->name('courses.courses.update');
    Route::delete('courses/course/{course}', [CoursesController::class, 'destroyCourse'])->name('courses.courses.destroy');

    // Features
    Route::post('courses/course/{course}/features', [CoursesController::class, 'addFeature'])->name('courses.features.store');
    Route::put('courses/feature/{feature}', [CoursesController::class, 'updateFeature'])->name('courses.features.update');
    Route::delete('courses/feature/{feature}', [CoursesController::class, 'destroyFeature'])->name('courses.features.destroy');

    // NEW: reorder + ajax
    Route::post('courses/{section}/courses/reorder', [CoursesController::class, 'reorderCourses'])
        ->name('courses.courses.reorder');

    Route::post('courses/course/{course}/features/reorder', [CoursesController::class, 'reorderFeatures'])
        ->name('courses.features.reorder');

    Route::post('courses/course/{course}/features/ajax', [CoursesController::class, 'addFeatureAjax'])
        ->name('courses.features.ajax');
        
});


Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dua categories
    Route::get('dua-categories', [DuaCategoryController::class, 'index'])->name('dua_categories.index');
    Route::get('dua-categories/create', [DuaCategoryController::class, 'create'])->name('dua_categories.create');
    Route::post('dua-categories', [DuaCategoryController::class, 'store'])->name('dua_categories.store');
    Route::get('dua-categories/{duaCategory}/edit', [DuaCategoryController::class, 'edit'])->name('dua_categories.edit');
    Route::put('dua-categories/{duaCategory}', [DuaCategoryController::class, 'update'])->name('dua_categories.update');
    Route::delete('dua-categories/{duaCategory}', [DuaCategoryController::class, 'destroy'])->name('dua_categories.destroy');

    // Duas
    Route::get('duas', [AdminDuaController::class, 'index'])->name('duas.index');
    Route::get('duas/create', [AdminDuaController::class, 'create'])->name('duas.create');
    Route::post('duas', [AdminDuaController::class, 'store'])->name('duas.store');
    Route::get('duas/{dua}/edit', [AdminDuaController::class, 'edit'])->name('duas.edit');
    Route::put('duas/{dua}', [AdminDuaController::class, 'update'])->name('duas.update');
    Route::delete('duas/{dua}', [AdminDuaController::class, 'destroy'])->name('duas.destroy');
});

 
Route::middleware(['auth','admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('events', EventController::class)->except(['show']);
    });

    Route::middleware(['auth','admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('prayer-times', PrayerTimeController::class)->except(['show']);
        Route::get('prayer-times/import', [PrayerTimeController::class, 'import'])->name('prayer-times.import');
        Route::post('prayer-times/import', [PrayerTimeController::class, 'importStore'])->name('prayer-times.import.store');

        // Admin User Management
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::get('users/{user}/password', [UserController::class, 'editPassword'])->name('users.password');
        Route::put('users/{user}/password', [UserController::class, 'updatePassword'])->name('users.password.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
    Route::prefix('admin')->middleware('auth')->group(function () {
});
    

    Route::middleware(['auth','admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('pages', PageController::class)->except(['show']);
        Route::post('pages/{page}/blocks', [PageBlockController::class, 'store'])->name('pages.blocks.store');
        Route::put('pages/{page}/blocks/{block}', [PageBlockController::class, 'update'])->name('pages.blocks.update');
        Route::delete('pages/{page}/blocks/{block}', [PageBlockController::class, 'destroy'])->name('pages.blocks.destroy');

        // reorder blocks (drag drop)
        Route::post('pages/{page}/blocks/reorder', [PageBlockController::class, 'reorder'])->name('pages.blocks.reorder');

    });
    Route::post('editor/upload', [EditorController::class, 'upload'])->name('admin.editor.upload');
    

// Admin People Routes
Route::prefix('admin/people')->middleware(['auth', 'verified'])->name('admin.people.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\PeopleController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\Admin\PeopleController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\Admin\PeopleController::class, 'store'])->name('store');
    Route::get('/{person}/edit', [\App\Http\Controllers\Admin\PeopleController::class, 'edit'])->name('edit');
    Route::put('/{person}', [\App\Http\Controllers\Admin\PeopleController::class, 'update'])->name('update');
    Route::delete('/{person}', [\App\Http\Controllers\Admin\PeopleController::class, 'destroy'])->name('destroy');
});

// Admin Marriage Booking Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('marriage-bookings', [AdminMarriageBookingController::class, 'index'])->name('marriage-bookings.index');
    Route::get('marriage-bookings/{marriageBooking}', [AdminMarriageBookingController::class, 'show'])->name('marriage-bookings.show');
    Route::put('marriage-bookings/{marriageBooking}', [AdminMarriageBookingController::class, 'update'])->name('marriage-bookings.update');
    Route::delete('marriage-bookings/{marriageBooking}', [AdminMarriageBookingController::class, 'destroy'])->name('marriage-bookings.destroy');
    Route::post('marriage-bookings/{marriageBooking}/mark-as-read', [AdminMarriageBookingController::class, 'markAsRead'])->name('marriage-bookings.mark-as-read');
    Route::get('marriage-bookings/unread/count', [AdminMarriageBookingController::class, 'getUnreadCount'])->name('marriage-bookings.unreadCount');
});

// Admin Funeral Booking Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('funeral-bookings', [AdminFuneralBookingController::class, 'index'])->name('funeral-bookings.index');
    Route::get('funeral-bookings/{funeralBooking}', [AdminFuneralBookingController::class, 'show'])->name('funeral-bookings.show');
    Route::put('funeral-bookings/{funeralBooking}', [AdminFuneralBookingController::class, 'update'])->name('funeral-bookings.update');
    Route::delete('funeral-bookings/{funeralBooking}', [AdminFuneralBookingController::class, 'destroy'])->name('funeral-bookings.destroy');
    Route::post('funeral-bookings/{funeralBooking}/mark-as-read', [AdminFuneralBookingController::class, 'markAsRead'])->name('funeral-bookings.mark-as-read');
    Route::get('funeral-bookings/unread/count', [AdminFuneralBookingController::class, 'getUnreadCount'])->name('funeral-bookings.unreadCount');
});

// Admin Khutbah Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('khutbahs', [AdminKhutbahController::class, 'index'])->name('khutbahs.index');
    Route::get('khutbahs/create', [AdminKhutbahController::class, 'create'])->name('khutbahs.create');
    Route::post('khutbahs', [AdminKhutbahController::class, 'store'])->name('khutbahs.store');
    Route::get('khutbahs/{khutbah}/edit', [AdminKhutbahController::class, 'edit'])->name('khutbahs.edit');
    Route::put('khutbahs/{khutbah}', [AdminKhutbahController::class, 'update'])->name('khutbahs.update');
    Route::delete('khutbahs/{khutbah}', [AdminKhutbahController::class, 'destroy'])->name('khutbahs.destroy');
    Route::post('khutbahs/{khutbah}/toggle-featured', [AdminKhutbahController::class, 'toggleFeatured'])->name('khutbahs.toggle-featured');
    Route::post('khutbahs/{khutbah}/toggle-active', [AdminKhutbahController::class, 'toggleActive'])->name('khutbahs.toggle-active');
});

// Admin Mosque Settings Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('mosque-settings', [MosqueSettingController::class, 'edit'])->name('mosque-settings.edit');
    Route::put('mosque-settings', [MosqueSettingController::class, 'update'])->name('mosque-settings.update');
});

// Admin Notice Board Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('notices', NoticeController::class)->except(['show']);
    Route::post('notices/{notice}/toggle-pin', [NoticeController::class, 'togglePin'])->name('notices.toggle-pin');
});

// Admin Newsletter Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('newsletter', [NewsletterController::class, 'index'])->name('newsletter.index');
    Route::get('newsletter/create', [NewsletterController::class, 'create'])->name('newsletter.create');
    Route::post('newsletter/send', [NewsletterController::class, 'send'])->name('newsletter.send');
    Route::get('newsletter/export', [NewsletterController::class, 'export'])->name('newsletter.export');
    Route::delete('newsletter/{subscriber}', [NewsletterController::class, 'destroy'])->name('newsletter.destroy');
});

// Admin Gift Aid Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('gift-aid', [GiftAidController::class, 'index'])->name('gift-aid.index');
    Route::get('gift-aid/create', [GiftAidController::class, 'create'])->name('gift-aid.create');
    Route::post('gift-aid', [GiftAidController::class, 'store'])->name('gift-aid.store');
    Route::get('gift-aid/report', [GiftAidController::class, 'report'])->name('gift-aid.report');
    Route::get('gift-aid/export', [GiftAidController::class, 'export'])->name('gift-aid.export');
    Route::get('gift-aid/{declaration}', [GiftAidController::class, 'show'])->name('gift-aid.show');
    Route::get('gift-aid/{declaration}/edit', [GiftAidController::class, 'edit'])->name('gift-aid.edit');
    Route::put('gift-aid/{declaration}', [GiftAidController::class, 'update'])->name('gift-aid.update');
    Route::post('gift-aid/{declaration}/cancel', [GiftAidController::class, 'cancel'])->name('gift-aid.cancel');
});

require __DIR__.'/auth.php';
