<?php

namespace App\Http\Controllers;

use App\Models\Boarding;
use App\Models\Complain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ComplainController extends Controller
{
    public function getCreateComplainPage()
    {
        return Inertia::render('Complain/CreateComplain');
    }

    public function createComplain(Request $request)
    {
        dd($request->all());
        $validation = $request->validate([
            'complainType' => ['required', 'max:50'],
            'description' => ['required', 'email'],
        ]);

        foreach ($request->pictureFiles as $pictureFile) {
            $file = $pictureFile;
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path() . '/images';
            $file->move($destinationPath, $fileName);
        }

        Complain::create([
            'user_id' => Auth::user()->id,
            'boarding_id' => Boarding::where()
        ]);

        return redirect('/profile');
    }
}
