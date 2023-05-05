<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
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
            'email' => ['required', 'email','unique:users,email,' . Auth::user()->id],
            'dateOfBirth' => ['required'],
            'phoneNumber' => ['required', 'max:50'],
            'profilePicture' => ['mimes:jpeg,png,jpg,gif,svg']
        ]);

        if ($request->hasFile('profilePicture')) {
            $file = $request->file('profilePicture');
            $file_name = $file->getClientOriginalName();
            $file_name = str_replace(" ", "-", $file_name);
            $file_name = time() . '-' . $file_name;
            $file_name = Auth::user()->id . $file_name;
            $file_name = 'images/' . $file_name;
            Storage::putFileAs('public/',$file, $file_name);
            $path_in_db = '/storage/' . $file_name;
        }

        User::findOrFail(Auth::user()->id)->update([
            'name' => $validation['name'],
            'email' => $validation['email'],
            'date_of_birth' => $validation['dateOfBirth'],
            'phone' => $validation['phoneNumber'],
            'profile_picture' => $path_in_db ?? null
        ]);

        return redirect('/profile');
    }

    public function getAllUserPage(){
        $users = User::paginate(5)->withQueryString();;

        return inertia('User/ListUser', [
            'users' => $users
        ]);
    }

    public function getUserDetail(Request $request){
        $curr_user = User::find($request->id);
        $curr_role = $curr_user->role()->first()->user_role_name;
        return inertia('User/ReadUser', [
            'user' => $curr_user,
            'currRole'=>$curr_role,
        ]);
    }

    public function getUserUpdate(Request $request){
        $curr_user = User::find($request->id);
        $curr_role = $curr_user->user_role_id;
        $all_role = UserRole::get();
        $curr_DOB = Carbon::parse($curr_user->date_of_birth)->format('Y-m-d');
        return inertia('User/UpdateUser', [
            'user' => $curr_user,
            'all_role'=>$all_role,
            'currRole'=>$curr_role,
            'currDOB'=>$curr_DOB,
        ]);
    }

    public function UserUpdate(Request $request){
        $custom_messages = [
            'images.max' => 'Maximum number of image is 1 !',
        ];

        $validation = $request->validate([
            'name' => ['required', 'max:200', 'min:3'],
            'gender'=>['required'],
            'status'=>['required'],
            'user_role'=>['required'],
            'email'=>['required', 'email','unique:users,email,' . $request->id],
            'dob'=>['required'],
            'phone' => ['required'],
            'images' => ['max:1','mimes:jpeg,png,jpg,gif,svg'],
        ], $custom_messages);

        if (($request->file('images') !== null)) {
            $curr_image = User::where('id','=',$request->id)->first()->profile_picture;
            $curr_image_path = explode('/storage/', $curr_image);

            if($curr_image){
                Storage::delete('public/'.$curr_image_path[1]);
            }
            $user_id = User::where('id','=',$request->id)->get()->id;

            foreach ($request->file('images') as $image) {

                $path = $image->getClientOriginalName();
                $path = str_replace(" ", "-", $path);
                $path = time() . '-' . $path;
                $path = $user_id . $path;
                $path = 'images/' . $path;

                Storage::putFileAs('public/',$image, $path);
                $path_in_db = '/storage/' . $path;

            }
            User::where('id','=',$request->id)->update([
                'user_name' => $validation['name'],
                'gender'=>$validation['gender'],
                'user_status'=>$validation['status'],
                'user_role_id'=>$validation['user_role'],
                'email'=>$validation['email'],
                'date_of_birth'=>$validation['dob'],
                'phone' => $validation['phone'],
                'profile_picture' => $path_in_db,
            ]);

        }else{
            User::where('id','=',$request->id)->update([
                'user_name' => $validation['name'],
                'gender'=>$validation['gender'],
                'user_status'=>$validation['status'],
                'user_role_id'=>$validation['user_role'],
                'email'=>$validation['email'],
                'date_of_birth'=>$validation['dob'],
                'phone' => $validation['phone'],
            ]);
        }

        return redirect('/userAll')->with('message', 'Success Updating User');
    }

    public function UserDelete(Request $request){
        $curr_image = User::where('id','=',$request->id)->first();
        $curr_image->profile_picture == null ? null :$curr_image_path = explode('/storage/', $curr_image->profile_picture);

        if($curr_image->profile_picture != null){
            Storage::delete('public/'.$curr_image_path[1]);
        }

        User::where('id','=',$request->id)->update([
            'user_status'=>"banned",
        ]);

        return redirect('/userAll')->with('message', 'Success Deleting / Banning User');
    }
}
