<?php

namespace App\Http\Controllers;

// use App\Models\Boarding;

use App\Models\Boarding;
use App\Models\BoardingImage;
use App\Models\BoardingType;
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

    public function getBoardingHouseDetail(Request $request)
    {
        $selectedBoardingHouseDetail = Boarding::where('id', $request->id)->first();
        $imagesForSelectedBoardingHouse = BoardingImage::where('boarding_id', $request->id)->get()->pluck('image');

        return Inertia::render('Boarding/SelectedBoardingHouse', [
            'boardingHouseDetail' => $selectedBoardingHouseDetail,
            'images' => $imagesForSelectedBoardingHouse
        ]);
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
