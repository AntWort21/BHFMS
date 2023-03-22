<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getProfilePage()
    {
        return inertia('EditProfile', [
            'userDetails' => Auth::user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        $validation = $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email'],
            'dateOfBirth' => ['required'],
            'phoneNumber' => ['required', 'max:50']
        ]);
        User::findOrFail(Auth::user()->id)->update([
            'name' => $validation['name'],
            'email' => $validation['email'],
            'date_of_birth' => $validation['dateOfBirth'],
            'phone' => $validation['phoneNumber'],
        ]);

        return redirect('/');
    }
}
