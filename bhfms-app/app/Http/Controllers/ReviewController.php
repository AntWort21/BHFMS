<?php

namespace App\Http\Controllers;

use App\Models\Boarding;
use App\Models\TenantBoarding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReviewController extends Controller
{
    public function getAllReviewPage()
    {
        $boardingHouseIDs = TenantBoarding::where('user_id', Auth::user()->id)->where('status', 'approved')->get()->pluck('boarding_id');
        $boardingHouses = Boarding::whereIn('id', $boardingHouseIDs)->get();

        return Inertia::render('Review/AllReview', ['boardingHouseList' => $boardingHouses]);
    }
}
