<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/services', function () {
    return view('services');
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
