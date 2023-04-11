<?php

namespace App\Http\Controllers;

// use App\Models\Boarding;

use App\Models\Boarding;
use App\Models\BoardingImage;
use App\Models\BoardingType;
use App\Models\Facility;
use App\Models\FacilityDetail;
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
    
    public function index(Request $request)
    {
        // $data = Boarding::when($request->search, function($query, $search){
        //     $query->where('status','=',$search);
        // })->with(['ownerBoardings' => function ($query) {
        //     $query->select('status');
        // }])->get();

        // $users = User::whereHas('posts', function($q){
        //     $q->where('created_at', '>=', '2015-01-01 00:00:00');
        // })->get();

        $Boarding_data = Boarding::join('owner_boardings','boardings.id','=','owner_boardings.boarding_id')
            ->join('users','users.id','=','owner_boardings.user_id')
            ->when($request->search, function($query, $search){
            if($search=='all'){
                $query;
                
            }else{
                $query->where('status','=',$search);
            }
            
        })->paginate(5)->withQueryString();



        // dd($data);


        // $data = Boarding::when($request->search, function($query, $search){
        //     $query->where('status','=',$search);
        // })->paginate(5)->withQueryString();

        return Inertia::render('Boarding/ListBoarding', [
            'all_count' => Boarding::count(),
            'approved' => Boarding::join('owner_boardings','boardings.id','=','owner_boardings.boarding_id')->where('status','=','approved')->count(),
            'declined' => Boarding::join('owner_boardings','boardings.id','=','owner_boardings.boarding_id')->where('status','=','declined')->count(),
            'pending' => Boarding::join('owner_boardings','boardings.id','=','owner_boardings.boarding_id')->where('status','=','pending')->count(),
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
        // dd($request['facility']);
        $validation = $request->validate([
            // 'name' => ['required', 'max:50'],
            // 'address' => ['required'],
            // 'type' => ['required'],
            // 'rooms' => ['required','numeric','min:1'],
            // 'price' => ['required','numeric','min:1'],
            // 'description' => ['required', 'max:200','min:5'],
            // 'images' => ['max:3']
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
