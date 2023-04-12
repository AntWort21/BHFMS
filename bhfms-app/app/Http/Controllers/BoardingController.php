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

        return Inertia::render('Boarding/BoardingManagementAdmin', [
            'all_count' => Boarding::count(),
            'approved' => Boarding::join('owner_boardings','boardings.id','=','owner_boardings.boarding_id')->where('status','=','approved')->count(),
            'declined' => Boarding::join('owner_boardings','boardings.id','=','owner_boardings.boarding_id')->where('status','=','declined')->count(),
            'pending' => Boarding::join('owner_boardings','boardings.id','=','owner_boardings.boarding_id')->where('status','=','pending')->count(),
            'boardings' => $Boarding_data,
        ]);
    }

    public function indexManager(Request $request)
    {
        
        $Boarding_data = Boarding::join('owner_boardings','boardings.id','=','owner_boardings.boarding_id')
            ->join('manager_boardings','manager_boardings.owner_boarding_id','=','owner_boardings.id')
            ->join('users','users.id','=','manager_boardings.user_id')
            ->where('manager_boardings.user_id','=',auth()->id())
            ->when($request->search, function($query, $search){
            if($search=='all'){
                $query;
                
            }else{
                $query->where('status','=',$search);
            }
            
        })->paginate(5)->withQueryString();

        return Inertia::render('Boarding/BoardingManagementManager', [
            'all_count' => ManagerBoarding::where('manager_boardings.user_id','=',auth()->id())->count(),
            'approved' => ManagerBoarding::join('owner_boardings','manager_boardings.owner_boarding_id','=','owner_boardings.id')->where([['manager_boardings.user_id','=',auth()->id()],['status','=','approved']])->count(),
            'declined' => ManagerBoarding::join('owner_boardings','manager_boardings.owner_boarding_id','=','owner_boardings.id')->where([['manager_boardings.user_id','=',auth()->id()],['status','=','declined']])->count(),
            'pending' => ManagerBoarding::join('owner_boardings','manager_boardings.owner_boarding_id','=','owner_boardings.id')->where([['manager_boardings.user_id','=',auth()->id()],['status','=','pending']])->count(),
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

        return Inertia::render('Boarding/BoardingManagementManager', [
            'all_count' => Boarding::join('owner_boardings','boardings.id','=','owner_boardings.boarding_id')->where('owner_boardings.user_id','=',auth()->id())->count(),
            'approved' => Boarding::join('owner_boardings','boardings.id','=','owner_boardings.boarding_id')->where([['owner_boardings.user_id','=',auth()->id()],['status','=','approved']])->count(),
            'declined' => Boarding::join('owner_boardings','boardings.id','=','owner_boardings.boarding_id')->where([['owner_boardings.user_id','=',auth()->id()],['status','=','declined']])->count(),
            'pending' => Boarding::join('owner_boardings','boardings.id','=','owner_boardings.boarding_id')->where([['owner_boardings.user_id','=',auth()->id()],['status','=','pending']])->count(),
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

    //Show the form for creating a new resource.
    public function createOwnerBoarding()
    {
        $Manager_data = User::where('user_role_id','=','4')->get();
        return Inertia::render('Boarding/CreateBoarding', [
            'facilities' => FacilityDetail::get(),
            'types' => BoardingType::get(),
            'managers' => $Manager_data,
        ]);
    }

    public function postOwnerBoarding(Request $request)
    {    
        $validation = $request->validate([
            'name' => ['required', 'max:50'],
            'address' => ['required'],
            'type' => ['required'],
            'rooms' => ['required','numeric','min:1'],
            'price' => ['required','numeric','min:1'],
            'description' => ['required', 'max:200','min:5'],
            'images' => ['max:3'],
            'images.*' =>['max:2000','size:2000'],
        ]);
        

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


        if(isset($request['manager'])){
            $ManagerBoardingNow = ManagerBoarding::create([
                'owner_boarding_id' =>$OwnerBoardingNow->id,
                'user_id'=>$request['manager']['id'],
            ]);
        }   
        
        //FILES
        if(isset($request['images'])){
            foreach($request->file('images') as $image){
                
                $path = $image->getClientOriginalName();
                $path = str_replace(" ", "-", $path);
                $path = time() . '-' . $path;

                $img = new BoardingImage();

                $img->image = $image->storeAs('public/Boarding_House_Images', $path);
                $img->boarding_id = $BoardingNow->id;
                $img->save();
            }
        }

        return redirect('/boardingOwner')->with('message', 'Success Adding new Boarding House');
    }

    //Store a newly created resource in storage
    public function store(Request $request)
    {
        //
    }

    //Display the specified resource.
    public function show($id)
    {
        //
    }

    //Show the form for editing the specified resource
    public function edit($id)
    {
        //
    }

    //Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        //
    }

    //Remove the specified resource from storage
    public function destroy($id)
    {
        //
    }
}
