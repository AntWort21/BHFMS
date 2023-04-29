<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\FacilityDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FacilityController extends Controller
{
    public function getAllFacilityPage(){
        $facility = FacilityDetail::paginate(5)->withQueryString();;

        // dd($facility);
        return inertia('Facility/ListFacility', [
            'facilities' => $facility
        ]);
    }

    public function getFacilityDetail(){
        
        return inertia('Facility/ReadFacility', [
        ]);
    }

    public function getFacilityCreate(){
        return inertia('Facility/CreateFacility', [
        ]);
    }

    public function FacilityCreate(Request $request){
        $custom_messages = [
            'images.max' => 'Maximum number of image is 1 !',
            'images.min' => 'Minimum number of image is 1 !',
        ];

        $validation = $request->validate([
            'name' => ['required', 'max:200', 'min:3'],
            'images' => ['max:1','min:1'],
        ], $custom_messages);

        //FILE
        if (($request->file('images') !== null)) {
            foreach ($request->file('images') as $image) {

                $path = $image->getClientOriginalName();
                $path = str_replace(" ", "-", $path);
                $path = time() . '-' . $path;
                $path = 'Facility_Images/' . $path;

                Storage::putFileAs('public/',$image, $path);
                $path_in_db = '/storage/' . $path;

            }
        }

        FacilityDetail::create([
            'facility_detail_name' => $request->name,
            'facility_img_path' => $path_in_db,
        ]);

        return redirect('/facilityAll')->with('message', 'Success Creating new Facility');
    }

    public function getFacilityUpdate(Request $request){
        $currFacility = FacilityDetail::find($request->id);
        return inertia('Facility/UpdateFacility', [
            'facility' => $currFacility,
        ]);
    }

    public function FacilityUpdate(Request $request){

        // dd($request->id);
        $custom_messages = [
            'images.max' => 'Maximum number of image is 1 !',
        ];

        $validation = $request->validate([
            'name' => ['required', 'max:200', 'min:3'],
            'images' => ['max:1'],
        ], $custom_messages);

        if (($request->file('images') !== null)) {
            $currImage = FacilityDetail::where('id','=',$request->id)->first()->facility_img_path;
            $currImage_path = explode('/storage/', $currImage);

            if($currImage){
                Storage::delete('public/'.$currImage_path[1]);
            }

            foreach ($request->file('images') as $image) {

                $path = $image->getClientOriginalName();
                $path = str_replace(" ", "-", $path);
                $path = time() . '-' . $path;
                $path = 'Facility_Images/' . $path;

                Storage::putFileAs('public/',$image, $path);
                $path_in_db = '/storage/' . $path;

            }
            FacilityDetail::where('id','=',$request->id)->update([
                'facility_detail_name' => $request->name,
                'facility_img_path' => $path_in_db,
            ]);

        }else{
            FacilityDetail::where('id','=',$request->id)->update([
                'facility_detail_name' => $request->name,
            ]);
        }

        return redirect('/facilityAll')->with('message', 'Success Updating Facility');
    }

    public function FacilityDelete(Request $request){
        $currImage = FacilityDetail::where('id','=',$request->id)->first();
        $currImage_path = explode('/storage/', $currImage->facility_img_path);

        if($currImage){
            Storage::delete('public/'.$currImage_path[1]);
        }

        $currImage->delete();

        return redirect('/facilityAll')->with('message', 'Success Deleting Facility');
    }
}
