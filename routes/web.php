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

Route::get('/services/{id}', function ($id) {
    $service = App\Models\Service::find($id);
    return view('service', [
        'service' => $service
    ]);
});

Route::get('/pricing', function () {
    return view('pricing');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/messages', function () {
    return view('messages');
});

Route::get('/commissions', function () {
    return view('commissions');
});

Route::get('/settings', function () {
    return view('settings');
});

Route::get('/activity', function () {
    return view('activity');
});
