<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Show the registration form
    public function showRegistrationForm()
    {
        return view('sign-in');
    }

    // Handle the registration form submission
    public function register(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'contact_number' => 'nullable|string|max:255',
            'default_address' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create a new user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'password' => Hash::make($request->password),
            'default_address' => $request->default_address,
        ]);

        // Log the registration
        Log::create([
            'description' => "New user registered: {$user->first_name} {$user->last_name} ({$user->email})",
            'type' => 'user',
        ]);

        // Log the user in
        Auth::login($user);

        // Redirect to a desired location, e.g., home page
        return redirect()->route('home')->with('success', 'Registration successful!');
    }
}