<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider and all of them will
 * | be assigned to the "web" middleware group. Make something great!
 * |
 */

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/menu', [PageController::class, 'menu'])->name('menu');
Route::get('/events', [EventController::class, 'index'])->name('events');
Route::get('/faqs', [PageController::class, 'faqs'])->name('faqs');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Blog Routes
use App\Http\Controllers\BlogController;

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

use App\Http\Controllers\ContactController;

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Event Booking Routes
use App\Http\Controllers\EventBookingController;

Route::get('/booking/{event?}', [EventBookingController::class, 'create'])->name('events.book');
Route::post('/events/booking', [EventBookingController::class, 'store'])->name('events.booking.store');
Route::post('/events/booking/ajax', [EventBookingController::class, 'ajaxStore'])->name('events.booking.ajax');
Route::post('/events/booking/validate-step1', [EventBookingController::class, 'validateStep1'])->name('events.booking.validate.step1');
Route::post('/events/booking/validate-step2', [EventBookingController::class, 'validateStep2'])->name('events.booking.validate.step2');

use App\Http\Controllers\CartController;

Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('cart-count', [CartController::class, 'getCartCount'])->name('cart.count');
Route::patch('update-cart', [CartController::class, 'update'])->name('cart.update');
Route::delete('remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');

use App\Http\Controllers\CheckoutController;

Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
