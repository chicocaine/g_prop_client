<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user-details', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'contact_number' => 'nullable|string|max:255',
            'default_address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->contact_number = $request->contact_number;
        $user->default_address = $request->default_address;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Log the profile update
        Log::create([
            'description' => "User profile updated: {$user->first_name} {$user->last_name} ({$user->email})",
            'type' => 'user',
        ]);

        return redirect()->back()->with('success', 'User details updated successfully!');
    }
}