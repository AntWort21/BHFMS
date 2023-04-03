<?php

namespace App\Http\Controllers;

// use App\Models\Boarding;

use App\Models\BoardingType;
use App\Models\Boarding;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BoardingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function indexOwner(Request $request)
    {
        // $data = Boarding::when($request->search, function($query, $search){
        //     $query->where('status','=',$search);
        // })->get();

        $data = Boarding::when($request->search, function($query, $search){
            $query->where('status','=',$search);
        })->paginate(10)->withQueryString();

        return Inertia::render('Boarding/ListBoarding', [
            'all_count' => Boarding::count(),
            'approved' => Boarding::where('status','=','approved')->count(),
            'declined' => Boarding::where('status','=','declined')->count(),
            'pending' => Boarding::where('status','=','pending')->count(),
            'boardings' => $data
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

        return Inertia::render('Boarding/CarouselTry',[
            'slides' => $slides
        ]);
    }

    //Show the form for creating a new resource.
    public function create()
    {
        // $slides = [
        //     "https://picsum.photos/id/1032/900/400",
        //     "https://picsum.photos/id/1033/900/400",
        //     "https://picsum.photos/id/1037/900/400",
        //     "https://picsum.photos/id/1035/900/400",
        //     "https://picsum.photos/id/1036/900/400",
        // ];

        // return Inertia::render('Boarding/CarouselTry',[
        //         'slides' => $slides
        // ]);

        return Inertia::render('Boarding/CreateBoarding',[
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
