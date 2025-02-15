<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'greeting' => 'Hello, World!'
    ]);
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/services', function () {
    return view('services', [
        'services' => App\Models\Service::all()
    ]);
});

Route::get('/register', function () {
    return view('register');
});

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

Route::get('/orders', function () {
    return view('orders.index', [
        'orders' => App\Models\Order::all()
    ]);
});

Route::get('/orders/{id}', function ($id) {
    $order = App\Models\Order::find($id);
    return view('orders.show', [
        'order' => $order
    ]);
});

Route::get('/settings', function () {
    return view('settings');
});