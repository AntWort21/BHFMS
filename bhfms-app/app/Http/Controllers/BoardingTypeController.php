<?php

namespace App\Http\Controllers;

use App\Models\BoardingType;
use Illuminate\Http\Request;

class BoardingTypeController extends Controller
{
    public function getAllBoardingTypePage(){
        $boardingTypes = BoardingType::paginate(5)->withQueryString();
        return inertia('BoardingType/ListBoardingType', [
            'boardingTypes' => $boardingTypes
        ]);
    }

    public function getBoardingTypeCreate(){
        return inertia('BoardingType/CreateBoardingType', [
        ]);
    }

    public function BoardingTypeCreate(Request $request){
        $validation = $request->validate([
            'name' => ['required', 'max:200', 'min:3','unique:boarding_types,boarding_type_name,'],
        ]);

        BoardingType::create([
            'boarding_type_name' => $request->name,
        ]);

        return redirect('/boardingTypeAll')->with('message', 'Success Creating new Boarding Type');
    }

    public function getBoardingTypeUpdate(Request $request){
        $currBoardingType = BoardingType::find($request->id);
        return inertia('BoardingType/UpdateBoardingType', [
            'boardingType' => $currBoardingType,
        ]);
    }

    public function BoardingTypeUpdate(Request $request){

        $validation = $request->validate([
            'name' => ['required', 'max:200', 'min:3','unique:boarding_types,boarding_type_name,' . $request->id],
        ]);

        BoardingType::where('id','=',$request->id)->update([
            'boarding_type_name' => $request->name,
        ]);

        return redirect('/boardingTypeAll')->with('message', 'Success Updating Boarding Type');
    }

    public function BoardingTypeDelete(Request $request){
        $currImage = BoardingType::where('id','=',$request->id)->first();
        $currImage_path = explode('/storage/', $currImage->BoardingType_img_path);

        if($currImage){
            Storage::delete('public/'.$currImage_path[1]);
        }

        $currImage->delete();

        return redirect('/BoardingTypeAll')->with('message', 'Success Deleting BoardingType');
    }
}
