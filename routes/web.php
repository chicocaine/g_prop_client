<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;





Route::get('/', function () {
    return view('home', [
        'greeting' => 'Hello, World!'
    ]);
}) ->name('home');

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
    return view('commissions.show', [
        'order' => $order
    ]);
});

Route::get('/settings', function () {
    return view('settings');
});

Route::get('/user/{id}', [UserController::class, 'show'])->name('user.details');
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/commision', [DashboardController::class,'show'])->name('dashboard');