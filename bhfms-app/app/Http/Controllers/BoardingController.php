<?php

namespace App\Http\Controllers;

// use App\Models\Boarding;

use App\Models\Boarding;
use App\Models\BoardingImage;
use App\Models\BoardingType;
use App\Models\FacilityDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BoardingController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        return Inertia::render('Boarding/ListBoarding', [
            'boardings' => Boarding::get(),
        ]);
    }

    public function testCarousel()
    {
        $slides = [
            "https://picsum.photos/id/1032/900/400",
            "https://picsum.photos/id/1033/900/400",
            "https://picsum.photos/id/1037/900/400",
            "https://picsum.photos/id/1035/900/400",
            "https://picsum.photos/id/1036/900/400",
        ];

        return Inertia::render('Boarding/CarouselTry', [
            'slides' => $slides
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
    public function create()
    {
        return Inertia::render('Boarding/CreateBoarding', [
            'types' => BoardingType::get(),
        ]);
    }

    //Store a newly created resource in storage
    public function store(Request $request)
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
    }

    //Display the specified resource.
    public function show($id)
    {
        //
    }

    //Show the form for editing the specified resource
    public function edit($id)
    {
        $allBoardingHouse = Boarding::all();

        foreach ($allBoardingHouse as $key => $boardingHouse) {
            $allBoardingHouse[$key]->imageUrl = BoardingImage::where('boarding_id', $boardingHouse->id)->first()->image;
        }

        return Inertia::render('Boarding/AllBoardingHouse', ['allBoardingHouse' => $allBoardingHouse]);
    }

    //Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $Manager_data = User::where('user_role_id','=','4')->get();
        return Inertia::render('Boarding/CreateBoarding', [
            'facilities' => FacilityDetail::get(),
            'types' => BoardingType::get(),
            'managers' => $Manager_data,
        ]);
    }

    //Remove the specified resource from storage
    public function destroy($id)
    {
        //
    }

}
