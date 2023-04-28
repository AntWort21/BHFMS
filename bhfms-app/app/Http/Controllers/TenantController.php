<?php

namespace App\Http\Controllers;

use App\Models\TenantBoarding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TenantController extends Controller
{
    public function getAllTenantBoarding(Request $request){
        $Boarding_data = TenantBoarding::Join('boardings', 'boardings.id', '=', 'tenant_boardings.boarding_id')
            ->leftJoin('owner_boardings','owner_boardings.id','=','boardings.id')
            ->join('users', 'users.id', '=', 'tenant_boardings.user_id')
            ->where('owner_boardings.user_id','=',auth()->id())
            ->when($request->search, function ($query, $search) {
                if ($search == 'all') {
                    $query;
                } else {
                    $query->where('tenant_boardings.status', '=', $search);
                }
            })->paginate(5)->withQueryString();

        $all_boarding_count = TenantBoarding::join('boardings', 'boardings.id', "=", 'tenant_boardings.boarding_id')
        ->join('owner_boardings','owner_boardings.boarding_id','boardings.id')
        ->where('owner_boardings.user_id','=',auth()->id())->get();

        $all = $all_boarding_count->count();
        $apv = $all_boarding_count->where('status', '=', 'approved')->count();
        $dcl = $all_boarding_count->where('status', '=', 'declined')->count();
        $pending = $all_boarding_count->where('status', '=', 'pending')->count();
        $done = $all_boarding_count->where('status', '=', 'checkout')->count();

        // dd($Boarding_data);

        return Inertia::render('Tenant/TenantList', [
            'all_count' => $all,
            'approved' => $apv,
            'pending' => $pending,
            'declined' => $dcl,
            'done' => $done,
            'users' => $Boarding_data,
        ]);
    }

    public function getAcceptTenant(Request $request){

    }

    public function acceptTenant(){

    }
}
