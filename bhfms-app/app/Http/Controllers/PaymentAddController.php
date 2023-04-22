<?php

namespace App\Http\Controllers;

use App\Models\Boarding;
use App\Models\RentTransaction;
use App\Models\User;
use App\Models\TenantBoarding;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PaymentAddController extends Controller
{
    public function getAddPayment()
    {
        return Inertia::render('Payment/PaymentAdd', [
            'listTenants' => $this->getAllTenants(1),
            'boardingHouseName' => $this->getBoardingHouseName(1),
            'boardingId' => 1
        ]);
    }

    public function getBoardingHouseName(int $boardingId){
        return Boarding::select('boarding_name')
        ->where('id',$boardingId)
        ->first();
    }

    public function getAllTenants(int $boardingId)
    {

        return TenantBoarding::select('users.user_name','users.email')
        ->join('users','users.id','=','tenant_boardings.id')
        ->where('boarding_id',$boardingId)
        ->where('status',2)
        ->get();
        // $tenants = array();
        // foreach($allTenants as $tenant){
        //     array_push($tenants,new TenantData($tenant->id,$tenant->user->name));
        // }   
    }

    private function getTenantIdByEmail(String $email){
        return User::select('id')
        ->where('email',$email)
        ->first();
    }

    public function addPayment(Request $request)
    {
        
        $validation = $request->validate([
            'paymentDate' => ['required'],
            'paymentAmount' => ['required', 'numeric'],
            'tenantEmail' => ['required'],
            'paymentRepeat' => ['required'],
        ]);
        RentTransaction::create([
            'tenant_boarding_id'=>$this->getTenantIdByEmail($validation['tenantEmail'])->id,
            'invoice_id' => $this->generateInvoice($validation['paymentDate']),
            'amount' => $validation['paymentAmount'],
            'start_date' => $validation['paymentDate'],
            'repeat_payment'=> $validation['paymentRepeat'],
        ]);   
    }

    public function getAllPayment(){
        if(Auth::user()->user_role_id==2){
            return Inertia::render('Payment/PaymentHistory', [
                'userRole' => Auth::user()->user_role_id,
                'paymentList' => $this->getListPaymentByUser(Auth::user()->id)
            ]);
        }elseif(Auth::user()->user_role_id==1||Auth::user()->user_role_id==3){

        }
    }

    private function getListPaymentByUser(int $userId){
        
        $a = RentTransaction::select('rent_transactions.id','payment_status','start_date','boarding_name','invoice_id')
        ->join('tenant_boardings','tenant_boardings.id','=','tenant_boarding_id')
        ->join('boardings','boardings.id','=','boarding_id')
        ->whereIn('tenant_boarding_id',function($query) use ($userId){
            $query->select('id')
            ->from('tenant_boardings')
            ->where('user_id',$userId);
        })
        ->get();
        // dd($a);
        return $a;
    }

    private function generateInvoice(String $date){
        $invoice_id = (Carbon::createFromDate($date)->format('y') * 1000000) +  (Carbon::createFromDate($date)->format('m') * 100000) + (Carbon::createFromDate($date)->format('d') * 10000) + rand(0,100000);
        while(RentTransaction::where("invoice_id",$invoice_id)->first()){
            $invoice_id = (Carbon::createFromDate($date)->format('y') * 1000000) +  (Carbon::createFromDate($date)->format('m') * 100000) + (Carbon::createFromDate($date)->format('d') * 10000) + rand(0,100000);
        }
        return $invoice_id;
    }

    public function getInvoiceDetail(Request $request){
        $transactionDetail = RentTransaction::join('tenant_boardings','tenant_boardings.id','=','tenant_boarding_id')
        ->join('boardings','boardings.id','=','tenant_boardings.boarding_id')
        ->join('users','users.id','=','tenant_boardings.user_id')
        ->where("invoice_id",json_decode($request->getContent())->invoice_id)->first();
        return [number_format($transactionDetail->amount,0,',','.'),$transactionDetail];
    }
}

