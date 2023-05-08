<?php

namespace App\Http\Controllers;

use App\Models\Boarding;
use App\Models\OwnerBoarding;
use App\Models\TenantBoarding;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TenantController extends Controller
{
    public function getAllTenantBoarding(Request $request){
        // if Owner
        if(Auth::user()->user_role_id==3){
            $Tenant_data = TenantBoarding::
                join('users', 'users.id', '=', 'tenant_boardings.user_id')
                ->join('boardings', 'boardings.id', '=', 'tenant_boardings.boarding_id')
                ->join('owner_boardings', 'boardings.id', '=', 'owner_boardings.boarding_id')
                ->select('users.user_name','boardings.boarding_name','tenant_boardings.id','tenant_boardings.tenant_status')
                ->where('owner_boardings.user_id','=',auth()->id())
                ->when($request->search, function ($query, $search) {
                    if ($search == 'all') {
                        $query;
                    } else {
                        $query->where('tenant_status', '=', $search);
                    }
                })->paginate(5)->withQueryString();
            
            $all_boarding_count = TenantBoarding::join('boardings', 'boardings.id', "=", 'tenant_boardings.boarding_id')
            ->join('owner_boardings','owner_boardings.boarding_id',"=",'boardings.id')
            ->select('tenant_status', DB::raw('count(*) as total'))
            ->groupBy('tenant_status')
            ->where('owner_boardings.user_id','=',auth()->id())->get()->toArray();
        }
        // if Manager
        else if(Auth::user()->user_role_id==4){
            $Tenant_data = TenantBoarding::
            join('users', 'users.id', '=', 'tenant_boardings.user_id')
            ->join('boardings', 'boardings.id', '=', 'tenant_boardings.boarding_id')
                ->join('manager_boardings', 'boardings.id', '=', 'manager_boardings.boarding_id')
                ->select('users.user_name','boardings.boarding_name','tenant_boardings.id','tenant_boardings.tenant_status')
                ->where('manager_boardings.user_id','=',auth()->id())
                ->when($request->search, function ($query, $search) {
                    if ($search == 'all') {
                        $query;
                    } else {
                        $query->where('tenant_status', '=', $search);
                    }
                })->paginate(5)->withQueryString();
            
            $all_boarding_count = TenantBoarding::join('boardings', 'boardings.id', "=", 'tenant_boardings.boarding_id')
            ->join('manager_boardings','manager_boardings.boarding_id',"=",'boardings.id')
            ->select('tenant_status', DB::raw('count(*) as total'))
            ->groupBy('tenant_status')
            ->where('manager_boardings.user_id','=',auth()->id())->get()->toArray();
        }

        $all = 0;
        $apv = 0;
        $dcl = 0;
        $pending = 0;
        $done = 0;

        foreach($all_boarding_count as $count => $collection) {
            if($all_boarding_count[$count]["tenant_status"] == "pending"){
                $all+= $all_boarding_count[$count]["total"]; 
                $pending = $all_boarding_count[$count]["total"];
            } 
                
            elseif($all_boarding_count[$count]["tenant_status"] == "approved"){
                $all+= $all_boarding_count[$count]["total"]; 
                $apv = $all_boarding_count[$count]["total"];

            }

            elseif($all_boarding_count[$count]["tenant_status"] == "declined"){
                $all+= $all_boarding_count[$count]["total"]; 
                $dcl = $all_boarding_count[$count]["total"];
            }

            elseif($all_boarding_count[$count]["tenant_status"] == "checkout"){
                $all+= $all_boarding_count[$count]["total"]; 
                $done = $all_boarding_count[$count]["total"];
            }
        }

        return Inertia::render('Tenant/TenantList', [
            'all_count' => $all,
            'approved' => $apv,
            'pending' => $pending,
            'declined' => $dcl,
            'done' => $done,
            'users' => $Tenant_data,
        ]);
    }

    public function getDetailTenantBoarding(Request $request){
        $tenantBoarding = TenantBoarding::find($request->id);
        $user_data = User::where("id",$tenantBoarding->user_id)->first();
        return Inertia::render('Tenant/ReadTenant', [
            'reason' => $tenantBoarding->declined_reason,
            'tenantBoarding' => $tenantBoarding,
            'currUser' => $user_data,
        ]);
    }

    public function getRequestTenant(Request $request){
        $tenantBoarding = TenantBoarding::find($request->id);
        $user_data = User::where("id",$tenantBoarding->user_id)->first();
        
        return Inertia::render('Tenant/RequestTenant', [
            'currID' => $request->id,
            'currUser' => $user_data,
        ]);
    }

    public function RequestTenant(Request $request){
        $accFirst = TenantBoarding::where('id','=',$request->currID)->first();
        $checkRoom = Boarding::where('id','=',$accFirst->boarding_id)->first()->rooms;
        $checkTenant = TenantBoarding::where([['boarding_id','=',$accFirst->boarding_id],['tenant_status','=','approved']])->count();
        if($checkRoom - $checkTenant <= 0 ){
            return redirect('/tenantBoarding')->with('message', 'Cannot Accept new Tenant as room is full');
        }

        if($request->accept){
            TenantBoarding::where('id','=',$request->currID)->update([
                'tenant_status' => 2,
                'declined_reason' => $request['reason'],
            ]);
            
            //Decline all Current User Accepted Tenant Boarding
            $update = TenantBoarding::where('user_id','=',$accFirst->user_id)->where('tenant_status','=','pending')->update([
                'tenant_status' => 'declined',
                'declined_reason' => 'Already Accepted in another Boarding House.',
            ]);

            //Decline all other request if room is full
            if($checkRoom - $checkTenant -1 <= 0 ){
                $update = TenantBoarding::where('boarding_id','=',$accFirst->boarding_id)->where('tenant_status','=','pending')->update([
                    'tenant_status' => 'declined',
                    'declined_reason' => 'The Boarding House you requested is currently at maximum capacity as other tenants have been accepted first.',
                ]);
            }

            return redirect('/tenantBoarding')->with('message', 'Success Accepting new Tenant');
        }else{
            TenantBoarding::where('id','=',$request->currID)->update([
                'tenant_status' => 3,
                'declined_reason' => $request['reason'],
            ]);
            return redirect('/tenantBoarding')->with('message', 'Success Declining new Tenant');
        }

    }
}
