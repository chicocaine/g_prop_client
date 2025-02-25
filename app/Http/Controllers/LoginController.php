<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('sign-in');
    }

    // Handle the login form submission
    public function login(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication passed, redirect to the intended page or home
            return redirect()->route('home')->with('success', 'Login successful!');
        }

        // Authentication failed, redirect back with an error message
        return redirect()->back()->withErrors(['email' => 'The provided credentials do not match our records.'])->withInput();
    }

    // Handle logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('success', 'Logout successful!');
    }
}