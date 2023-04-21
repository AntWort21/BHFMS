<?php

namespace App\Http\Controllers;

use App\Models\Boarding;
use App\Models\Complain;
use App\Models\ComplainType;
use App\Models\TenantBoarding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ComplainController extends Controller
{
    public function getComplainListPage()
    {
        $complainList = Complain::where('user_id', Auth::user()->id)->get();

        foreach ($complainList as $key => $complain) {
            $complainList[$key]['boarding_house_name'] = Boarding::where('id', $complain->boarding_id)->first()->boarding_name;
            $complainList[$key]['complain_type_name'] = ComplainType::where('id', $complain->complain_type_id)->first()->complain_type_name;
        }

        return Inertia::render('Complain/ComplainList', [
            'complainList' => $complainList
        ]);
    }


    public function getCreateComplainPage()
    {
        return Inertia::render('Complain/CreateComplain', [
            'allComplainType' =>  ComplainType::all()->pluck('complain_type_name')
        ]);
    }

    public function createComplain(Request $request)
    {
        $validation = $request->validate([
            'complainType' => ['required', 'max:50'],
            'description' => ['required'],
        ]);

        if ($request->hasFile('pictureFile')) {
            $file = $request->pictureFile;
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path() . '/images';
            $file->move($destinationPath, $fileName);
        }

        Complain::create([
            'user_id' => Auth::user()->id,
            'boarding_id' => TenantBoarding::where('user_id', Auth::user()->id)->first()->boarding_id,
            'complain_type_id' => ComplainType::where('complain_type_name', $request->complainType)->first()->id,
            'complain_desc' => $request->description,
            'complain_image_url' => '/images/'.$fileName ?? null
        ]);

        return redirect('/complain');
    }

    public function getComplainDetail(Request $request)
    {
        // dd($request->all(), Complain::find($request->id));
        $complain = Complain::find($request->id);
        $complainType = ComplainType::where('id', $complain->complain_type_id)->first()->complain_type_name;

        return Inertia::render('Complain/ComplainDetail', [
            'complainType' => $complainType,
            'complain' => $complain
        ]);
    }
}
