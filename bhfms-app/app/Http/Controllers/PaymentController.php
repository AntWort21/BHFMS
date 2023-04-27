<?php

namespace App\Http\Controllers;

use App\Models\Boarding;
use App\Models\PaymentMethod;
use App\Models\RentTransaction;
use App\Models\User;
use App\Models\TenantBoarding;
use App\Models\TransactionType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function getPaymentPageManager()
    {
        return Inertia::render('Payment/PaymentPageManager', [
            'listTenants' => $this->getAllTenants(1),
            'boardingHouseName' => $this->getBoardingHouseName(1),
            'transactionTypes' => $this->getTransactionType()
        ]);
    }

    public function getBoardingHouseName(int $boardingId){
        return Boarding::select('boarding_name')
        ->where('id',$boardingId)
        ->first();
    }

    private function getTransactionType(){
        return TransactionType::pluck('transaction_type_name');
    }

    public function getAllTenants(int $boardingId)
    {

        return TenantBoarding::select('users.user_name','users.email')
        ->join('users','users.id','=','tenant_boardings.user_id')
        ->where('boarding_id',$boardingId)
        ->where('status','approved')
        ->get();
        // $tenants = array();
        // foreach($allTenants as $tenant){
        //     array_push($tenants,new TenantData($tenant->id,$tenant->user->name));
        // }   
    }

    private function getTenantIdByEmail(String $email){
        return TenantBoarding::whereIn('user_id',function($query) use ($email){
            $query->select('id')
            ->from('users')
            ->where('email',$email);
        })->first();
    }

    public function addPaymentManager(Request $request)
    {
        
        $validation = $request->validate([
            'paymentDate' => ['required'],
            'paymentAmount' => ['required', 'numeric','min:10000'],
            'tenantEmail' => ['required'],
            'paymentRepeat' => ['required'],
            'transactionType' => ['required']
        ]);
        RentTransaction::create([
            'tenant_boarding_id'=>$this->getTenantIdByEmail($validation['tenantEmail'])->id,
            'transaction_type_id' => TransactionType::select('id')->where('transaction_type_name',$validation['transactionType'])->first()->id,
            'invoice_id' => $this->generateInvoice($validation['paymentDate']),
            'amount' => $validation['paymentAmount'] +  rand(0,1000),
            'payment_date' => $validation['paymentDate'],
            'repeat_payment'=> $validation['paymentRepeat'] == 'true' ?  true: false,
        ]);   

    }

    public function getAllPayment(){
        if(Auth::user()->user_role_id==2){
            return Inertia::render('Payment/PaymentHistory', [
                'userRole' => Auth::user()->user_role_id,
                'paymentList' => $this->getListPaymentByUser(Auth::user()->id)
            ]);
        }elseif(Auth::user()->user_role_id==1||Auth::user()->user_role_id==3){ 
            return Inertia::render('Payment/PaymentHistory', [
                'userRole' => Auth::user()->user_role_id,
                'paymentList' => $this->getListPaymentByBoardingId($_GET['boarding'])
            ]);
        }
    }

    private function getListPaymentByUser(int $userId){
        
        $a = RentTransaction::select('rent_transactions.id','payment_status','payment_date','boarding_name','invoice_id')
        ->join('tenant_boardings','tenant_boardings.id','=','tenant_boarding_id')
        ->join('boardings','boardings.id','=','boarding_id')
        ->whereIn('tenant_boarding_id',function($query) use ($userId) {
            $query->select('id')
            ->from('tenant_boardings')
            ->where('user_id',$userId);
        })
        ->get();
        // dd($a);
        return $a;
    }
    private function getListPaymentByBoardingId(int $boardingId){
        $subquery = TenantBoarding::select('id','user_id','boarding_id')
        ->where('boarding_id',$boardingId);


        $a = RentTransaction::join(DB::raw("({$subquery->toSql()}) as tenant_boardings"),'tenant_boardings.id','=','tenant_boarding_id')
        ->join('users','users.id','=','tenant_boardings.user_id')
        ->mergeBindings($subquery->getQuery())
        ->get();
        return $a;
    }
    private function generateInvoice(String $date){
        $invoice_id = (Carbon::createFromDate($date)->format('y') * 10000000) +  (Carbon::createFromDate($date)->format('m') * 1000000) + (Carbon::createFromDate($date)->format('d') * 10000) + rand(0,10000);
        while(RentTransaction::where("invoice_id",$invoice_id)->first()){
            $invoice_id = (Carbon::createFromDate($date)->format('y') * 1000000) +  (Carbon::createFromDate($date)->format('m') * 100000) + (Carbon::createFromDate($date)->format('d') * 10000) + rand(0,10000);
        }
        return $invoice_id;
    }

    public function getInvoiceDetail(Request $request){
        $transactionDetail = RentTransaction::join('tenant_boardings','tenant_boardings.id','=','tenant_boarding_id')
        ->join('boardings','boardings.id','=','tenant_boardings.boarding_id')
        ->join('users','users.id','=','tenant_boardings.user_id')
        ->join('transaction_types','transaction_type_id','=','transaction_types.id')
        ->where("invoice_id",json_decode($request->getContent())->invoice_id)->first();
        return [number_format($transactionDetail->amount,0,',','.'),$transactionDetail];
    }

    public function getPaymentPageTenant(){
        $paymentDetail = RentTransaction::join('tenant_boardings','tenant_boardings.id','=','tenant_boarding_id')
        ->join('boardings','boardings.id','=','tenant_boardings.boarding_id')
        ->where("invoice_id",$_GET['order'])->first();
        if(!$paymentDetail || $paymentDetail->payment_status!='Pending'){//No data
            return redirect('/paymentHistory');;
        }
        return Inertia::render('Payment/PaymentPageTenant', [
            'listPaymentMethod' => PaymentMethod::where("status","available")->pluck('payment_method_name'),
            'paymentDetail' => $paymentDetail,
        ]);
    }

    public function addPaymentTenant(Request $request){
        $transaction = RentTransaction::where('invoice_id',$_GET['order'])->first();
        $validation = $request->validate([
            'paymentMethod' => ['required'],
            'proofOfPayment' => ['required','image']
        ]);
        
        $fileName = date('Y',strtotime($transaction->payment_date)).date('m',strtotime($transaction->payment_date))
        .date('d',strtotime($transaction->payment_date)).$_GET['order'].'.png';
        $validation['proofOfPayment']->move(storage_path('app/public/proofOfPayment'), $fileName);
        
        $transaction->payment_method_id = PaymentMethod::where('payment_method_name',$validation['paymentMethod'])->first()->id;
        $transaction->payment_status = 'Processing';
        $transaction->save();
    }

    public function cancelPayment(){
        $transaction = RentTransaction::where('invoice_id',$_GET['order'])->first();
        if($transaction->payment_status=='Canceled'){
            return redirect('/paymentHistory?boarding='.$_GET['boarding']);
        }
        else if($transaction->payment_status=='Processing'){
            $transaction->payment_transferred_status='Processing_Refund';
        }
        else if($transaction->payment_status=='Approved' && $transaction->payment_transferred_status=='Successful'){
            $transaction->payment_transferred_status='Owner_Refund';
        } else if($transaction->payment_status=='Approved'){
            $transaction->payment_transferred_status='Pending_Refund';
        }
        $transaction->payment_status = 'Canceled';
        $transaction->save();
        return redirect('/paymentHistory?boarding='.$_GET['boarding']);
    }
}

