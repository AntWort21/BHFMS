<?php

namespace App\Http\Controllers;

// use App\Models\Boarding;

use App\Models\Boarding;
use App\Models\BoardingImage;
use App\Models\BoardingType;
use App\Models\Facility;
use App\Models\FacilityDetail;
use App\Models\ManagerBoarding;
use App\Models\OwnerBoarding;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BoardingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexAdmin(Request $request)
    {

        $Boarding_data = Boarding::join('owner_boardings','boardings.id','=','owner_boardings.boarding_id')
            ->join('users','users.id','=','owner_boardings.user_id')
            ->when($request->search, function($query, $search){
            if($search=='all'){
                $query;
            }else{
                $query->where('status','=',$search);
            }

        })->paginate(5)->withQueryString();

        $all_boarding_count = Boarding::join('owner_boardings','boardings.id',"=",'owner_boardings.boarding_id')->get();
        $all = $all_boarding_count->count();
        $apv = $all_boarding_count->where('status','=','approved')->count();
        $dcl = $all_boarding_count->where('status','=','declined')->count();
        $pending = $all_boarding_count->where('status','=','pending')->count();
        $ban = $all_boarding_count->where('status','=','banned')->count();

        return Inertia::render('Boarding/BoardingManagementAdmin', [
            'all_count' => $all,
            'approved' => $apv,
            'pending' => $pending,
            'declined' => $dcl,
            'banned' => $ban,
            'boardings' => $Boarding_data,
        ]);
    }

    public function indexManager(Request $request)
    {
        $Boarding_data = Boarding::join('manager_boardings','manager_boardings.boarding_id','=','boardings.id')
            ->join('owner_boardings','boardings.id',"=",'owner_boardings.boarding_id')
            ->join('users','users.id',"=","owner_boardings.user_id")
            ->where('manager_boardings.user_id','=',auth()->id())
            ->when($request->search, function($query, $search){
            if($search=='all'){
                $query;

            }else{
                $query->where('status','=',$search);
            }

        })->paginate(5)->withQueryString();

        $all_boarding_count = ManagerBoarding::join('boardings','boardings.id','manager_boardings.boarding_id')
        ->join('owner_boardings','boardings.id',"=",'owner_boardings.boarding_id')
        ->where('manager_boardings.user_id','=',auth()->id())->get();
        $all = $all_boarding_count->count();
        $apv = $all_boarding_count->where('status','=','approved')->count();
        $dcl = $all_boarding_count->where('status','=','declined')->count();
        $pending = $all_boarding_count->where('status','=','pending')->count();
        $ban = $all_boarding_count->where('status','=','banned')->count();

        return Inertia::render('Boarding/BoardingManagementManager', [
            'all_count' => $all,
            'approved' => $apv,
            'pending' => $pending,
            'declined' => $dcl,
            'banned' => $ban,
            'boardings' => $Boarding_data,
        ]);
    }

    public function indexOwner(Request $request)
    {

        $Boarding_data = Boarding::join('owner_boardings','boardings.id','=','owner_boardings.boarding_id')
            ->join('users','users.id','=','owner_boardings.user_id')
            ->where('owner_boardings.user_id','=',auth()->id())
            ->when($request->search, function($query, $search){
            if($search=='all'){
                $query;

            }else{
                $query->where('status','=',$search);
            }

        })->paginate(5)->withQueryString();


        $all_boarding_count = OwnerBoarding::where('user_id','=',auth()->id())->get();
        $all = $all_boarding_count->count();
        $apv = $all_boarding_count->where('status','=','approved')->count();
        $dcl = $all_boarding_count->where('status','=','declined')->count();
        $pending = $all_boarding_count->where('status','=','pending')->count();
        $ban = $all_boarding_count->where('status','=','banned')->count();

        return Inertia::render('Boarding/BoardingManagementOwner', [
            'all_count' => $all,
            'approved' => $apv,
            'pending' => $pending,
            'declined' => $dcl,
            'banned' => $ban,
            'boardings' => $Boarding_data,
        ]);
    }

    public function getAllBoardingHouse()
    {
        $allBoardingHouse = Boarding::paginate(18);

        foreach ($allBoardingHouse as $key => $boardingHouse) {
            $allBoardingHouse[$key]->imageUrl = BoardingImage::where('boarding_id', $boardingHouse->id)->first()->image;
        }

        return Inertia::render('Boarding/AllBoardingHouse', ['allBoardingHouse' => $allBoardingHouse]);
    }

    public function getBoardingHouseDetail(Request $request)
    {
        $selectedBoardingHouseDetail = Boarding::where('id', $request->id)->first();
        $boardingHouseImages = BoardingImage::where('boarding_id', $request->id)->get()->pluck('image');

        $ownerId = OwnerBoarding::where('boarding_id', $request->id)->first()->user_id;

        $owner = User::where('id', $ownerId)->first();

        $facilityList = Facility::where('boarding_id', $request->id)->get();
        foreach ($facilityList as $key => $facility) {
            $facilityList[$key]->facility_detail_name = FacilityDetail::where('id', $facility->facility_id)->first()->facility_detail_name;
        }

        return Inertia::render('Boarding/SelectedBoardingHouse', [
            'boardingHouseDetail' => $selectedBoardingHouseDetail,
            'images' => $boardingHouseImages,
            'ownerName' => $owner->user_name,
            'ownerPicture' => $owner->profile_picture,
            'facilityList' => $facilityList->pluck('facility_detail_name')
        ]);
    }

    //Show the form for creating a new resource.
    public function getCreateOwnerBoarding()
    {
        $Manager_data = User::where('user_role_id','=','4')->get();
        return Inertia::render('Boarding/CreateBoarding', [
            'facilities' => FacilityDetail::get(),
            'types' => BoardingType::get(),
            'managers' => $Manager_data,
        ]);
    }

    public function createOwnerBoarding(Request $request)
    {
        $custom_messages = [
            'images.min' => 'Need at least 1 image !',
            'images.max' => 'Maximum 5 images !'
          ];

        $validation = $request->validate([
            'name' => ['required', 'max:50'],
            'address' => ['required'],
            'type' => ['required'],
            'rooms' => ['required','numeric','min:1'],
            'price' => ['required','numeric','min:1'],
            'facility'=>['min:1'],
            'description' => ['required', 'max:200','min:5'],
            'images' => ['min:1','max:5'],
        ], $custom_messages);


        $BoardingNow = Boarding::create([
            'boarding_name' => $request['name'],
            'address' => $request['address'],
            'latitude' => $request['lat'],
            'longitude' => $request['lng'],
            'type_id' => $request['type'],
            'rooms' => $request['rooms'],
            'shared_bathroom' => $request['sharedBathroom'],
            'price' => $request['price'],
            'boarding_desc' => $request['description'],
        ]);

        $BoardingNow->facilities()->attach($request['facility']);

        $OwnerBoardingNow = OwnerBoarding::create([
            'boarding_id'=>$BoardingNow->id,
            'user_id'=>$request->user()->id,
            'status'=>'pending',
        ]);


        if(isset($request['manager']) && $request['manager']!== null){
            $ManagerBoardingNow = ManagerBoarding::create([
                'user_id'=>$request['manager']['id'],
                'boarding_id'=>$BoardingNow->id,
            ]);
        }

        //FILES
        if(($request->file('images') !== null)){
            foreach($request->file('images') as $image){

                $path = $image->getClientOriginalName();
                $path = str_replace(" ", "-", $path);
                $path = time() . '-' . $path;
                $path = 'Boarding_House_Images/' . $path;

                $img = new BoardingImage();

                Storage::putFileAs('public/',$image, $path);
                $img->image = $path;
                $img->boarding_id = $BoardingNow->id;
                $img->save();
            }
        }

        return redirect('/boardingOwner')->with('message', 'Success Adding new Boarding House');
    }

    public function getReadBoarding(Request $request)
    {
        $currBoarding = Boarding::where('id','=',$request->id)->get()->first();
        $currFacilities = ($currBoarding->facilities()->exists()) ? $currBoarding->facilities()->get(): null;
        $currType = $currBoarding->boardingType()->get()->first();
        $currManager = $currBoarding->managerBoardings()->get()->first();
        $currImages = $currBoarding->images()->get();

        return Inertia::render('Boarding/ReadBoarding', [
            'currImages' => $currImages,
            'currBoarding' => $currBoarding,
            'currFacilities' => $currFacilities,
            'currType' => $currType,
            'currManager'=>$currManager,
        ]);
    }

    public function getUpdateBoarding(Request $request)
    {
        $Manager_data = User::where('user_role_id','=','4')->get();
        $currBoarding = Boarding::where('id','=',$request->id)->get()->first();
        $currFacilities = ($currBoarding->facilities()->exists()) ? $currBoarding->facilities()->get(): null;

        $currManager = $currBoarding->managerBoardings()->get()->first();

        $currImages = $currBoarding->images()->get();

        $shared_bathroom = $currBoarding['shared_bathroom'] == 1 ? true: false;

        return Inertia::render('Boarding/UpdateBoarding', [
            'currImages' => $currImages,
            'currBoarding' => $currBoarding,
            'currFacilities' => $currFacilities,
            'currManager'=>$currManager,
            'facilities' => FacilityDetail::get(),
            'types' => BoardingType::get(),
            'managers' => $Manager_data,
            'shared_bathroom_bool' => $shared_bathroom,
        ]);
    }

    public function updateBoarding(Request $request){

        $max_pic = 5 - (int)$request['max_image'];
        $total_pic = (int)$request['max_image'] + (int)count($request['images']);
        $custom_messages = [
            'images.max' => 'Maximum number of image is 5, you have '.$total_pic.' image in this Boarding House, Please Upload Again !',
          ];

        $validation = $request->validate([
            'name' => ['required', 'max:50'],
            'address' => ['required'],
            'type' => ['required'],
            'rooms' => ['required','numeric','min:1'],
            'price' => ['required','numeric','min:1'],
            'facility'=>['min:1'],
            'description' => ['required', 'max:200','min:5'],
            'images' => ['max:'.$max_pic],
        ], $custom_messages);



        //Change from model into array of facility
        $facility_id = [];
        foreach($request['facility'] as $fac) {
            array_push($facility_id,$fac['id']);
        }


        Boarding::findOrFail($request->id)->update([
            'boarding_name' => $request['name'],
            'address' => $request['address'],
            'latitude' => $request['lat'],
            'longitude' => $request['lng'],
            'type_id' => $request['type'],
            'rooms' => $request['rooms'],
            'shared_bathroom' => $request['sharedBathroom'],
            'price' => $request['price'],
            'boarding_desc' => $request['description'],
        ]);

        Boarding::findOrFail($request->id)->facilities()->sync($facility_id);

        $currOwner = OwnerBoarding::where('boarding_id','=',$request->id)->get()->first();

        $currManager = ManagerBoarding::where([['boarding_id','=',$request->id]])->get()->first();


        if(isset($request['manager']) && $request['manager']!== null){
            if($currManager){
                //current Manager Exists, update record
                $currManager->update([
                    'user_id'  => $request['manager']['id'],
                ]);
            }else{
                //current Manager doesnt exist, create new
                ManagerBoarding::create([
                    'boarding_id'=> $request->id,
                    'user_id'  => $request['manager']['id'],
                ]);

            }
        }else if($currManager){
            //Current Manager Exists, Delete Record because empty request
            $currManager->delete();
        }


        //FILES
        if(($request->file('images') !== null)){
            foreach($request->file('images') as $image){

                $path = $image->getClientOriginalName();
                $path = str_replace(" ", "-", $path);
                $path = time() . '-' . $path;
                $path = 'Boarding_House_Images/' . $path;

                $img = new BoardingImage();

                Storage::putFileAs('public/',$image, $path);
                $img->image = $path;
                $img->boarding_id = $request->id;
                $img->save();
            }
        }

        // return redirect();
        if(Auth::user()->user_role_id==1){
            return redirect('/boardingAdmin')->with('message', 'Success Updating Boarding House');
        }else if (Auth::user()->user_role_id==3){
            return redirect('/boardingOwner')->with('message', 'Success Updating Boarding House');
        }

    }
    public function deleteBoarding(Request $request)
    {

        OwnerBoarding::where('boarding_id','=',$request->id)->first()->update([
            'status'=>'banned',
        ]);

        if(Auth::user()->user_role_id==1){
            return redirect('/boardingAdmin')->with('message', 'Success Deleting Boarding House');
        }else if (Auth::user()->user_role_id==3){
            return redirect('/boardingOwner')->with('message', 'Success Deleting Boarding House');
        }

    }

}
