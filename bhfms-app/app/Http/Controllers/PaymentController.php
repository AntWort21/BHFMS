<?php

namespace App\Http\Controllers;

use App\Models\Boarding;
use App\Models\PaymentMethod;
use App\Models\RentTransaction;
use App\Models\TenantBoarding;
use App\Models\TransactionType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function getPaymentPageManager()
    {
        return Inertia::render('Payment/PaymentPageManager', [
            'listTenants' => $this->getAllTenants(1),
            'boardingHouseName' => $this->getBoardingHouseName(1),
            'transactionTypes' => $this->getTransactionTypeName()
        ]);
    }

    public function addPaymentTenant(Request $request)
    {
        $transaction = RentTransaction::where('invoice_id',$_GET['order'])->first();
        
        $validation = $request->validate([
            'paymentMethod' => ['required'],
            'proofOfPayment' => ['required', 'image']
        ]);
        
        $fileName = date('Ymd', strtotime($transaction->payment_date)) . $_GET['order'] . '.png';
        dd($fileName);
        $validation['proofOfPayment']->move(storage_path('app/public/proofOfPayment'), $fileName);
        
        $transaction->payment_method_id = PaymentMethod::where('payment_method_name',$validation['paymentMethod'])->first()->id;
        $transaction->payment_status = 'Processing';
        $transaction->save();
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

    private function getBoardingHouseName(int $boardingId)
    {
        return Boarding::select('boarding_name')
        ->where('id',$boardingId)
        ->first();
    }

    private function getTransactionTypeName()
    {
        return TransactionType::pluck('transaction_type_name');
    }

    private function getAllTenants(int $boardingId)
    {
        return TenantBoarding::select('users.user_name','users.email')
        ->join('users','users.id','=','tenant_boardings.user_id')
        ->where('boarding_id',$boardingId)
        ->where('status','approved')
        ->get();
    }

    private function getTenantIdByEmail(String $email)
    {
        return TenantBoarding::whereIn('user_id',function($query) use ($email){
                $query->select('id')
                ->from('users')
                ->where('email',$email);})
            ->first();
    }

    public function getAllPayment()
    {
        $userRole = Auth::user()->user_role_id;
        $paymentList = [];
        
        if ($userRole == 2) {
            $paymentList = $this->getListPaymentByUser(Auth::user()->id);
        } elseif ($userRole == 1 || $userRole == 3) {
            $boardingId = $_GET['boarding'] ?? null;
            if ($boardingId) {
                $paymentList = $this->getListPaymentByBoardingId($boardingId);
            }
        }
        
        return Inertia::render('Payment/PaymentHistory', [
            'userRole' => $userRole,
            'paymentList' => $paymentList,
        ]);
    }

    private function getListPaymentByUser(int $userId){
        
        return RentTransaction::select('rent_transactions.id', 'payment_status', 'payment_date', 'boarding_name', 'invoice_id')
        ->join('tenant_boardings', 'tenant_boardings.id', '=', 'tenant_boarding_id')
        ->join('boardings', 'boardings.id', '=', 'boarding_id')
        ->whereIn('tenant_boarding_id', function ($query) use ($userId) {
            $query->select('id')
                ->from('tenant_boardings')
                ->where('user_id', $userId);
        })
        ->paginate(5);
    }

    private function getListPaymentByBoardingId(int $boardingId){
        $subquery = TenantBoarding::select('id','user_id','boarding_id')
        ->where('boarding_id',$boardingId);
       
        return RentTransaction::joinSub($subquery, 'tenant_boardings', function ($join) {
            $join->on('tenant_boardings.id', '=', 'tenant_boarding_id');
        })
        ->join('users', 'users.id', '=', 'tenant_boardings.user_id')
        ->paginate(5);
    }

    private function generateInvoice(String $date){
        $year = Carbon::createFromDate($date)->format('y') * 10000000;
        $month = Carbon::createFromDate($date)->format('m') * 1000000;
        $day = Carbon::createFromDate($date)->format('d') * 10000;
        $random = rand(0, 10000);
        $invoice_id = $year + $month + $day + $random;

        while (RentTransaction::where('invoice_id', $invoice_id)->first()) {
            $random = rand(0, 10000);
            $invoice_id = $year + $month + $day + $random;
        }

        return $invoice_id;
    }

    public function getInvoiceDetail(Request $request)
    {
        $invoice_id = json_decode($request->getContent())->invoice_id;
        
        $transactionDetail = RentTransaction::join('transaction_types','transaction_type_id','=','transaction_types.id')
        ->where("invoice_id",$invoice_id)
        ->first();
        $tenant_boarding = TenantBoarding::where('id',$transactionDetail->tenant_boarding_id)->first();
        $username = User::where('id',$tenant_boarding->user_id)->value('user_name');
        $boradingName = Boarding::where('id',$tenant_boarding->boarding_id)->value('boarding_name');
        return [$transactionDetail->amount,$transactionDetail,$username,$boradingName];
    }

    public function getPaymentPageTenant()
    {
        $paymentDetail = RentTransaction::join('tenant_boardings','tenant_boardings.id','=','tenant_boarding_id')
            ->join('boardings','boardings.id','=','tenant_boardings.boarding_id')
            ->where("invoice_id",$_GET['order'])
            ->where('payment_status', 'Pending')
            ->first();
        
            if(!$paymentDetail){//No data
            return redirect('/paymentHistory');;
        }
        return Inertia::render('Payment/PaymentPageTenant', [
            'listPaymentMethod' => PaymentMethod::where("status","available")->pluck('payment_method_name'),
            'paymentDetail' => $paymentDetail,
        ]);
    }


    public function cancelPayment()
    {
        $transaction = RentTransaction::where('invoice_id', $_GET['order'])->first();
    
        if ($transaction->payment_status === 'Canceled') {
            return redirect('/paymentHistory?boarding=' . $_GET['boarding']);
        }
    
        switch ($transaction->payment_status) {
            case 'Processing':
                $transaction->payment_transferred_status = 'Processing_Refund';
                break;
            case 'Approved':
                if ($transaction->payment_transferred_status === 'Successful') {
                    $transaction->payment_transferred_status = 'Owner_Refund';
                } else {
                    $transaction->payment_transferred_status = 'Pending_Refund';
                }
                break;
            default:
                break;
        }
    
        $transaction->payment_status = 'Canceled';
        $transaction->save();
    
        return redirect('/paymentHistory?boarding=' . $_GET['boarding']);
    }
}

