<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    public function register()
    {
        $validation = Request::validate([
            'firstName' => ['required', 'max:50'],
            'lastName' => ['required', 'max:50'],
            'gender' => ['required', 'in:Male,Female'],
            'dateOfBirth' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'alpha_num', 'min:6'],
            'confirmPassword' => ['required', 'same:password']
        ]);

        User::create([
            'name' => $validation['firstName'] . " " . $validation['lastName'],
            'gender' => $validation['gender'],
            'email' => $validation['email'],
            'date_of_birth' => $validation['dateOfBirth'],
            'phone' => null,
            'user_role_id' => isset($validation['userRoleId']) ? $validation['userRoleId'] : 2,
            'profile_picture' => $validation['profilePicture'] ?? null,
            'password' => bcrypt($validation['password']),
        ]);

        return redirect('/login');
    }
    public function login()
    {
        $validation = Request::validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'alpha_num']
        ]);

        if (Auth::attempt($validation)) {
            Request::session()->regenerate();

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        Request::session()->invalidate();
        Request::session()->regenerateToken();
        return redirect('/login');
    }
}
