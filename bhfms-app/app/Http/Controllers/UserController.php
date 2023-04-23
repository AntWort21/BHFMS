<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'phoneNumber' => ['required', 'max:50'],
            'profilePicture' => ['mimes:jpeg,png,jpg,gif,svg']
        ]);

        if ($request->hasFile('profilePicture')) {
            $file = $request->file('profilePicture');
            $fileName = $file->getClientOriginalName();
            $destinationPath = storage_path('app/public/images');
            $file->move($destinationPath, $fileName);
        }

        User::findOrFail(Auth::user()->id)->update([
            'name' => $validation['name'],
            'email' => $validation['email'],
            'date_of_birth' => $validation['dateOfBirth'],
            'phone' => $validation['phoneNumber'],
            'profile_picture' => '/storage/images/'.$fileName ?? null
        ]);

        return redirect('/profile');
    }
}
