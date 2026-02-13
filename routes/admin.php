<?php

use App\Http\Controllers\Admin\{
    AuthController,
    DashboardController,
    ProfileController,
    SiteSettingController,
    ServiceController,
    MenuCategoryController,
    MenuItemController,
    EventController,
    TeamMemberController,
    TestimonialController,
    FaqController,
    BookingController,
    ContactController,
    OrderController,
    BlogController,
    QuotationController,
    HeroBannerController
};
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | Admin Routes
 * |--------------------------------------------------------------------------
 */

// Guest routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

// Authenticated routes
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    // Site Settings
    Route::get('site-settings', [SiteSettingController::class, 'edit'])->name('site-settings.edit');
    Route::put('site-settings', [SiteSettingController::class, 'update'])->name('site-settings.update');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::post('/change-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // Resource Routes
    Route::resource('services', ServiceController::class)->except(['show']);
    Route::resource('menu-categories', MenuCategoryController::class)->except(['show']);
    Route::get('menu-items/export-excel', [MenuItemController::class, 'exportExcel'])->name('menu-items.export-excel');
    Route::get('menu-items/export-pdf', [MenuItemController::class, 'exportPdf'])->name('menu-items.export-pdf');
    Route::get('menu-items/import', [MenuItemController::class, 'import'])->name('menu-items.import');
    Route::post('menu-items/import', [MenuItemController::class, 'processImport'])->name('menu-items.process-import');
    // Route::delete('menu-items/delete-imported', [MenuItemController::class, 'deleteAllImported'])->name('menu-items.delete-imported');
    Route::get('menu-items/template', [MenuItemController::class, 'downloadTemplate'])->name('menu-items.template');
    Route::resource('menu-items', MenuItemController::class)->except(['show']);
    Route::resource('events', EventController::class)->except(['show']);
    Route::resource('team-members', TeamMemberController::class)->except(['show']);
    Route::resource('testimonials', TestimonialController::class)->except(['show']);
    Route::resource('faqs', FaqController::class)->except(['show']);
    Route::resource('blogs', BlogController::class)->except(['show']);
    Route::resource('hero-banners', HeroBannerController::class);

    // Quotations
    Route::get('client-quotations', [App\Http\Controllers\Admin\QuotationController::class, 'clientIndex'])->name('client-quotations.index');
    Route::post('quotations/generate/{booking}', [App\Http\Controllers\Admin\QuotationController::class, 'generateFromBooking'])->name('quotations.generate');
    Route::get('quotations/{quotation}/download-pdf', [App\Http\Controllers\Admin\QuotationController::class, 'downloadPDF'])->name('quotations.download-pdf');
    Route::get('quotations/{quotation}/pdf', [App\Http\Controllers\Admin\QuotationController::class, 'downloadPDF'])->name('quotations.pdf');
    Route::get('quotations/{quotation}/whatsapp', [App\Http\Controllers\Admin\QuotationController::class, 'shareWhatsApp'])->name('quotations.whatsapp');
    Route::post('quotations/{quotation}/email', [App\Http\Controllers\Admin\QuotationController::class, 'sendEmail'])->name('quotations.email');
    Route::resource('quotations', App\Http\Controllers\Admin\QuotationController::class);

    // Customers
    Route::resource('customers', App\Http\Controllers\Admin\CustomerController::class);

    // Route::resource('orders', OrderController::class)->except(['create', 'store', 'edit', 'update']);

    // Bookings & Contacts (view only)
    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::delete('bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::patch('contacts/{contact}/mark-read', [ContactController::class, 'markAsRead'])->name('contacts.mark-read');
});
