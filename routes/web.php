<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;


Route::get('/', [LoginController::class, 'index'])->name('home');


Route::get('/about', function () {
    return view('about');
});

Route::get('/services', function () {
    return view('services', [
        'services' => App\Models\Service::all()
    ]);
});

Route::get('/sign-in', function () {
    return view('pages.sign-in');
});
Route::post('/sign-in', [LoginController::class, 'login'])->name('login');

Route::get('/register', function () {
    return view('pages.sign-up');
});
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', function () {
    return view('login');
});

Route::get('/pricing', function () {
    return view('pricing');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/commissions', function () {
    return view('commissions.index', [
        'orders' => App\Models\Commission::all()
    ]);
});

Route::get('/commissions/{id}', function ($id) {
    $order = App\Models\Commission::find($id);
});

Route::get('/settings', function () {
    return view('settings');
});

Route::get('/user/{id}', [UserController::class, 'show'])->name('user.details');
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [CommissionController::class, 'index'])->name('dashboard');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/inbox', [CommissionController::class, 'showInbox'])->name('inbox');
    Route::get('/inbox-content', [CommissionController::class, 'getInboxContent'])->name('inbox.content');
    Route::get('/commissions/pending-cancelled', [CommissionController::class, 'showPendingAndCancelled'])->name('commissions.pending-cancelled');
    Route::get('/archive', [CommissionController::class, 'showArchived'])->name('commissions.archive');
    Route::get('/commissions/{commissionId}/messages', [CommissionController::class, 'getMessages'])->name('commissions.messages');
    Route::post('/commissions/{commissionId}/messages', [CommissionController::class, 'storeMessage'])->name('commissions.storeMessage');
    Route::post('/commissions', [CommissionController::class, 'store'])->name('commissions.store');
    Route::post('/commissions/{commission}/mark-read', [CommissionController::class, 'markMessagesAsRead']);
    Route::get('/commissions/{commissionId}/latest-messages', [CommissionController::class, 'getLatestMessages'])->name('commissions.latestMessages');

Route::middleware(['auth'])->group(function () {
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/global-search', [SearchController::class, 'globalSearch'])->name('global-search');
});

});