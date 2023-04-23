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

        // dd($Boarding_data);

        // $Boarding_data_count = Boarding::join('owner_boardings','owner_boardings.boarding_id','=','boardings.id')
        // ->select('status', DB::raw('count(*) as total'))
        // ->groupBy('status')
        // ->orderBy('status', 'asc')
        // ->get();
        // idx 0 -> pending
        // idx 1 -> approved
        // idx 2 -> declined

        // dd($Boarding_data_count);

        $all_boarding_count = Boarding::get();
        $all = $all_boarding_count->count();
        $apv = $all_boarding_count->where('status','=','approved')->count();
        $dcl = $all_boarding_count->where('status','=','declined')->count();
        $pending = $all_boarding_count->where('status','=','pending')->count();

        return Inertia::render('Boarding/BoardingManagementAdmin', [
            'all_count' => $all,
            'approved' => $apv,
            'pending' => $pending,
            'declined' => $dcl,
            'boardings' => $Boarding_data,
        ]);
    }

    public function indexManager(Request $request)
    {
        
        $Boarding_data = Boarding::join('manager_boardings','manager_boardings.boarding_id','=','boardings.id')
            ->join('owner_boardings','manager_boardings.owner_boarding_id',"=",'owner_boardings.id')
            ->join('users','users.id',"=","owner_boardings.user_id")
            ->where('manager_boardings.manager_boarding_id','=',auth()->id())
            ->when($request->search, function($query, $search){
            if($search=='all'){
                $query;
                
            }else{
                $query->where('status','=',$search);
            }
            
        })->paginate(5)->withQueryString();

        $all_boarding_count = ManagerBoarding::where('manager_boardings.manager_boarding_id','=',auth()->id())->get();
        $all = $all_boarding_count->count();
        $apv = $all_boarding_count->where('status','=','approved')->count();
        $dcl = $all_boarding_count->where('status','=','declined')->count();
        $pending = $all_boarding_count->where('status','=','pending')->count();

        return Inertia::render('Boarding/BoardingManagementManager', [
            'all_count' => $all,
            'approved' => $apv,
            'pending' => $pending,
            'declined' => $dcl,
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
        
        // foreach ($Boarding_data as $key => $bhouse) {
        //     // if(BoardingImage::where('boarding_id','=',$bhouse->boarding_id)->get()->isNotEmpty())
        //     $Boarding_data[$key]->imageUrl = BoardingImage::where('boarding_id','=',$bhouse->boarding_id)->first();
        //     // else
        //         // $Boarding_data[$key]->imageUrl->image = null;
        // }

        $all_boarding_count = OwnerBoarding::where('user_id','=',auth()->id())->get();
        $all = $all_boarding_count->count();
        $apv = $all_boarding_count->where('status','=','approved')->count();
        $dcl = $all_boarding_count->where('status','=','declined')->count();
        $pending = $all_boarding_count->where('status','=','pending')->count();

        // dd($Boarding_data[0]->images_limit_one['image']);
        // dd($Boarding_data);

        return Inertia::render('Boarding/BoardingManagementOwner', [
            'all_count' => $all,
            'approved' => $apv,
            'pending' => $pending,
            'declined' => $dcl,
            'boardings' => $Boarding_data,
        ]);
    }

    public function getAllBoardingHouse()
    {
        $allBoardingHouse = Boarding::all();

        foreach ($allBoardingHouse as $key => $boardingHouse) {
            $allBoardingHouse[$key]->imageUrl = BoardingImage::where('boarding_id', $boardingHouse->id)->first()->image;
        }

        return Inertia::render('Boarding/AllBoardingHouse', ['allBoardingHouse' => $allBoardingHouse]);
    }

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
        // dd($request); 
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
                'owner_boarding_id' =>$OwnerBoardingNow->id,
                'manager_user_id'=>$request['manager']['id'],
                'boarding_id'=>$BoardingNow->id,
            ]);
        }   
        
        //FILES
        if(($request->file('images') !== null)){
            foreach($request->file('images') as $image){
                
                $path = $image->getClientOriginalName();
                $path = str_replace(" ", "-", $path);
                $path = time() . '-' . $path;
                // $path = user_id + path;

                $img = new BoardingImage();

                // $img->image = $image->storeAs('public/Boarding_House_Images', $path);
                Storage::putFileAs('public/Boarding_House_Images',$image, $path);
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

        $sharedBathroom = $currBoarding['shared_bathroom'];
        if($sharedBathroom == true){
            $sharedBathroom = true;
        }else{
            $sharedBathroom = false;
        }

        return Inertia::render('Boarding/ReadBoarding', [
            'currImages' => $currImages,
            'currBoarding' => $currBoarding,
            'currFacilities' => $currFacilities,
            'currType' => $currType,
            'currManager'=>$currManager,
            'sharedBathroom' => $sharedBathroom,
        ]);
    }

    public function getUpdateBoarding(Request $request)
    {
        $Manager_data = User::where('user_role_id','=','4')->get();
        $currBoarding = Boarding::where('id','=',$request->id)->get()->first();
        $currFacilities = ($currBoarding->facilities()->exists()) ? $currBoarding->facilities()->get(): null;


        $sharedBathroom = $currBoarding['shared_bathroom'];
        if($sharedBathroom == true){
            $sharedBathroom = true;
        }else{
            $sharedBathroom = false;
        }

        $currManager = $currBoarding->managerBoardings()->get()->first();

        $currImages = $currBoarding->images()->get();
        // dd(count($currImages));

        // dd($currBoarding);
        
        return Inertia::render('Boarding/UpdateBoarding', [
            'currImages' => $currImages,
            'currBoarding' => $currBoarding,
            'currFacilities' => $currFacilities,
            'currManager'=>$currManager,
            'facilities' => FacilityDetail::get(),
            'types' => BoardingType::get(),
            'sharedBathroom' => $sharedBathroom,
            'managers' => $Manager_data,
        ]);
    }

    public function updateBoarding(Request $request){
        // dd($request['max_image']);
        dd($request);

        // dd($request['manager']);

        // Current ID of Boarding House to be updated
        // dd($request->id);

        $max_pic = 5 - (int)$request['max_image'];
        $total_pic = (int)$request['max_image'] + (int)count($request['images']);
        // dd($max_pic);
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

        // dd($request['facility']);
        // dd($facility_id);
        

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

        $currManager = ManagerBoarding::where([['owner_boarding_id','=',$currOwner['boarding_id']],['boarding_id','=',$request->id]])->get()->first();


        if(isset($request['manager']) && $request['manager']!== null){
            if($currManager){
                //current Manager Exists, update record
                $currManager->update([
                    'manager_user_id'  => $request['manager']['id'],
                ]);
            }else{
                //current Manager doesnt exist, create new
                ManagerBoarding::create([
                    'owner_boarding_id'=> $currOwner['id'],
                    'boarding_id'=> $request->id,
                    'manager_user_id'  => $request['manager']['id'],
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

                $img = new BoardingImage();

                // $img->image = $image->storeAs('public/Boarding_House_Images', $path);
                Storage::putFileAs('public/Boarding_House_Images',$image, $path);
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
        $currBoarding = Boarding::where('id','=',$request->id)->get()->first();
        $currImages = $currBoarding->images()->get();
        // $images = [];
        foreach($currImages as $img) {
            // array_push($images,$img['image']);
            Storage::delete('public/Boarding_House_Images/'.$img['image']);
            $img -> delete();
        }

        Boarding::findOrFail($request->id)->delete();

        if(Auth::user()->user_role_id==1){
            return redirect('/boardingAdmin')->with('message', 'Success Deleting Boarding House');
        }else if (Auth::user()->user_role_id==3){
            return redirect('/boardingOwner')->with('message', 'Success Deleting Boarding House');
        }

    }
}
