<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getRegisterPage()
    {
        return inertia('Auth/Register');
    }

    public function getLoginPage()
    {
        return inertia('Auth/Login');
    }

    public function register(Request $request)
    {
        $validation = $request->validate([
            'firstName' => ['required', 'max:50'],
            'lastName' => ['required', 'max:50'],
            'gender' => ['required', 'in:Male,Female'],
            'dateOfBirth' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'alpha_num', 'min:6'],
            'confirmPassword' => ['required', 'same:password']
        ]);

        User::create([
            'user_name' => $validation['firstName'] . " " . $validation['lastName'],
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
    public function login(Request $request)
    {
        $validation = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'alpha_num']
        ]);

        if (Auth::attempt($validation)) {
            $request->session()->regenerate();

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
