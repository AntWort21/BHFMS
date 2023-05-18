<?php

namespace App\Http\Controllers;

use App\Models\Boarding;
use App\Models\ManagerBoarding;
use App\Models\OwnerBoarding;
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
    const PAGINATION_NUMBER = 5;
    public function addPaymentTenant(Request $request)
    {
        $transaction = RentTransaction::where('invoice_id',$_GET['order'])->first();
        
        $validation = $request->validate([
            'paymentMethod' => ['required'],
            'proofOfPayment' => ['required', 'image']
        ]);
        
        $fileName = date('Ymd', strtotime($transaction->payment_date)) . $_GET['order'] . '.png';
        $validation['proofOfPayment']->move(storage_path('app/public/proofOfPayment'), $fileName);
        
        $transaction->payment_method_id = PaymentMethod::where('payment_method_name',$validation['paymentMethod'])->first()->id;
        $transaction->payment_status = 'Processing';
        $transaction->save();

        return redirect('/paymentHistory');;
    }

    public function addPaymentManager(Request $request)
    {
        $customMessage = [
            'tenantEmail.required' => 'Please select tenant',
        ];
        
        $validation = $request->validate([
            'paymentDate' => ['required'],
            'paymentAmount' => ['required', 'numeric','min:10000'],
            'tenantEmail' => ['required'],
            'transactionType' => ['required']
        ], $customMessage);
        RentTransaction::create([
            'tenant_boarding_id'=>$this->getTenantIdByEmail($validation['tenantEmail'],$_GET['boarding'])->id,
            'transaction_type_id' => TransactionType::select('id')->where('transaction_type_name',$validation['transactionType'])->first()->id,
            'invoice_id' => $this->generateInvoice($validation['paymentDate']),
            'amount' => $validation['paymentAmount'] +  rand(0,1000),
            'payment_date' => $validation['paymentDate'],
            'repeat_payment'=> $request['paymentRepeat'] == 'true' ?  true: false,
        ]);   
        
        if(Auth::user()->user_role_id == 3) {
            return redirect('/boardingOwner'); 
        }
        return redirect('/boardingManager');

    }

    public function getPaymentPageManager()
    {
        return Inertia::render('Payment/PaymentPageManager', [
            'listTenants' => $this->getAllTenants($_GET['boarding']),
            'boardingHouseName' => $this->getBoardingHouseName($_GET['boarding']),
            'transactionTypes' => $this->getTransactionTypeName(),
        ]);
    }

    public function getCheckInvoiceRequest(){
        $userRole = Auth::user()->user_role_id;
        return Inertia::render('Payment/PaymentCheckInvoice', [
            'userRole' => $userRole,
            'invoiceList' => $this->getInvoiceListProcessing(),
        ]); 
    }

    public function getInvoiceListProcessing(){
        return RentTransaction::where('payment_status','Processing')
        ->paginate(self::PAGINATION_NUMBER);
    }

    private function getBoardingHouseName(int $boardingId)
    {
        return Boarding::find($boardingId)->boarding_name;
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
        ->where('tenant_status','approved')
        ->get();
    }

    private function getTenantBoarding(int $tenantBoarding)
    {
        return TenantBoarding::where('id',$tenantBoarding)->first();
    }

    private function getTenantIdByEmail(String $email, int $boardingId)
    {
        return TenantBoarding::whereIn('user_id',function($query) use ($email){
                    $query->select('id')
                    ->from('users')
                    ->where('email',$email);})
                ->where('boarding_id',$boardingId)
                ->first();
    }

    public function getAllPayment()
    {
        $userRole = Auth::user()->user_role_id;
        $paymentList = [];
        
        if ($userRole == 2) {
            $paymentList = $this->getListPaymentByUser(Auth::user()->id);
        } elseif ($userRole == 3 || $userRole == 4) {
            $boardingId = $_GET['boarding'] ?? null;
            if ($boardingId) {
                $paymentList = $this->getListPaymentByBoardingId($boardingId);
            } else if($userRole == 3) { //Owner History
                $boardingIDs = OwnerBoarding::where('user_id',Auth::user()->id)
                ->where('owner_status', '!=', 'declined')
                ->pluck('boarding_id');
                $paymentList = RentTransaction::join('tenant_boardings', 'tenant_boardings.id', '=', 'tenant_boarding_id')
                ->join('users','users.id','=','tenant_boardings.user_id')
                ->whereIn('tenant_boardings.boarding_id',$boardingIDs)
                ->paginate(self::PAGINATION_NUMBER);
            } else if($userRole == 4) { // Manager History
                $boardingIDs = ManagerBoarding::where('user_id',Auth::user()->id)
                ->pluck('boarding_id');
                $paymentList = RentTransaction::join('tenant_boardings', 'tenant_boardings.id', '=', 'tenant_boarding_id')
                ->join('users','users.id','=','tenant_boardings.user_id')
                ->whereIn('tenant_boardings.boarding_id',$boardingIDs)
                ->paginate(self::PAGINATION_NUMBER);
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
        ->paginate(self::PAGINATION_NUMBER);
    }

    private function getListPaymentByBoardingId(int $boardingId){
        $subquery = TenantBoarding::select('id','user_id','boarding_id')
        ->where('boarding_id',$boardingId);
       
        return RentTransaction::joinSub($subquery, 'tenant_boardings', function ($join) {
            $join->on('tenant_boardings.id', '=', 'tenant_boarding_id');
        })
        ->join('users', 'users.id', '=', 'tenant_boardings.user_id')
        ->paginate(self::PAGINATION_NUMBER);
    }

    private function getTenantById(int $tenantId)
    {
        return User::where('id',$tenantId)->first();
    }

    public function getInvoiceDetail(Request $request)
    {
        $invoiceId = json_decode($request->getContent())->invoice_id;
        $transactionDetail = RentTransaction::join('transaction_types','transaction_type_id','=','transaction_types.id')
        ->where("invoice_id",$invoiceId)
        ->first();
        $tenant_boarding = TenantBoarding::where('id',$transactionDetail->tenant_boarding_id)->first();
        $username = User::where('id',$tenant_boarding->user_id)->value('user_name');
        $boradingName = Boarding::where('id',$tenant_boarding->boarding_id)->value('boarding_name');
        return [$transactionDetail->amount,$transactionDetail,$username,$boradingName];
    }

    public function getEditPayment()
    {
        $transaction = RentTransaction::where('invoice_id', $_GET['order'])->first();
        $tenantBoarding = $this->getTenantBoarding($transaction->tenant_boarding_id);
        $transaction->amount = floor($transaction->amount / 1000) * 1000;
        return Inertia::render('Payment/PaymentPageManager', [
            'transaction' => $transaction,
            'listTenants' => $this->getAllTenants(1),
            'boardingHouseName' => $this->getBoardingHouseName($tenantBoarding->boarding_id),
            'tenant' => $this->getTenantById($tenantBoarding->user_id),
            'transactionTypes' => $this->getTransactionTypeName(),
        ]);
    }

    public function getPaymentPageTenant()
    {
        $paymentDetail = RentTransaction::join('tenant_boardings','tenant_boardings.id','=','tenant_boarding_id')
            ->join('boardings','boardings.id','=','tenant_boardings.boarding_id')
            ->where("invoice_id",$_GET['order'])
            ->whereIn('payment_status', ['Pending','Late','Rejected'])
            ->first();

        if(!$paymentDetail){//No data
            return redirect('/paymentHistory');
        }
        return Inertia::render('Payment/PaymentPageTenant', [
            'listPaymentMethod' => PaymentMethod::where("status","available")->pluck('payment_method_name'),
            'paymentDetail' => $paymentDetail,
        ]);
    }

    public function getPaymentRemit()
    {
        $userRole = Auth::user()->user_role_id;
        $paymentList = RentTransaction::join('tenant_boardings', 'tenant_boardings.id', '=', 'tenant_boarding_id')
        ->join('owner_boardings','owner_boardings.boarding_id','=','tenant_boardings.boarding_id')
        ->join('users','users.id','owner_boardings.user_id')
        ->where('payment_status','Approved')
        ->where('payment_transferred_status','Pending')
        ->paginate(self::PAGINATION_NUMBER);
        return Inertia::render('Payment/PaymentRemit',[
            'userRole' => $userRole,
            'invoiceList' => $paymentList,
        ]);
    }
    public function getPaymentSupport() {
        
    }
    public function cancelPayment()
    {
        $transaction = RentTransaction::where('invoice_id', $_GET['order'])->first();
    
        if ($transaction->payment_status === 'Canceled') {
            return redirect('/paymentHistory?boarding=' . $_GET['boarding']);
        }
    
        switch ($transaction->payment_status) {
            case 'Processing': //The tenant have paid and still being processed
                $transaction->payment_transferred_status = 'Processing_Refund'; //Return to Tenant
                break;
            case 'Approved': //Owner have recieve the money
                if ($transaction->payment_transferred_status === 'Successful') { //Admin have transferred to the owner 
                    break;
                    // $transaction->payment_transferred_status = 'Owner_Refund';
                    // session()->flash('message','Payment has been transferred to Owner cannot be canceled');
                } else { //Admin have not transferred to owner
                    $chatController = new ChatController;
                    $chatController->storeSpecificChatMessage(User::where('email','bhfms@gmail.com')->first()->id,
                    TenantBoarding::find($transaction->tenant_boarding_id)->user_id,
                    'Please send your Bank name and Account Number for refund on this transaction - '.$transaction->invoice_id);
                    $transaction->payment_transferred_status = 'Processing_Refund'; //Return to Tenant
                    $transaction->payment_status = 'Canceled';
                }
                break;
            default:
                break;
        }
        
        $transaction->save();
    
        return redirect('/paymentHistory?boarding=' . $_GET['boarding']);
    }

    public function updateInvoiceStatus(Request $request) 
    {   
        $content = json_decode($request->getContent());
        $invoiceStatus = $content->invoiceStatus;
        $invoiceId = $content->invoiceID;
        $transaction = RentTransaction::where('invoice_id',$invoiceId)->first();
        $transaction->payment_status = $invoiceStatus;
        if($invoiceStatus=='Approved' && $transaction->payment_transferred_status=='Processing_Refund'){
            $chatController = new ChatController;
            $chatController->storeSpecificChatMessage(User::where('email','bhfms@gmail.com')->first()->id,
            TenantBoarding::find($transaction->tenant_boarding_id)->user_id,
            'Please send your Bank name and Account Number for refund on this transaction - '.$transaction->invoice_id);
            $transaction->payment_status = 'Canceled';
        }
        if($invoiceStatus=='Rejected' && Carbon::parse($transaction->payment_date)->lt(Carbon::today()->timezone('Asia/Jakarta')->startOfDay())){
            $transaction->payment_date = Carbon::today()->timezone('Asia/Jakarta')->startOfDay()->addDay()->toDateString();
        }
        if($invoiceStatus=='Rejected' && $content->reason!=null) {
            $chatController = new ChatController;
            $chatController->storeSpecificChatMessage(User::where('email','bhfms@gmail.com')->first()->id,
            TenantBoarding::find($transaction->tenant_boarding_id)->user_id,
            $content->reason);
        }
        $transaction->save();
        
    }

    public function updatePayment(Request $request) 
    {
        $custom_messages = [
            'tenantEmail.required' => 'Please select tenant',
        ];
        $validation = $request->validate([
            'paymentDate' => ['required'],
            'paymentAmount' => ['required', 'numeric','min:10000'],
            'tenantEmail' => ['required'],
            'transactionType' => ['required']
        ], $custom_messages);
 
        RentTransaction::where('invoice_id',$_GET['order'])->first()->update([
            'tenant_boarding_id'=>$this->getTenantIdByEmail($validation['tenantEmail'],$_GET['boarding'])->id,
            'transaction_type_id' => TransactionType::select('id')->where('transaction_type_name',$validation['transactionType'])->first()->id,
            'amount' => $validation['paymentAmount'] +  rand(0,1000),
            'payment_date' => $validation['paymentDate'],
            'repeat_payment'=> $validation['paymentRepeat'] == 'true' ?  true: false,

        ]);

        return redirect('/paymentHistory?boarding='.$_GET['boarding']);;
    }

    public function updateTransferredStatus(Request $request){
        $status = $request->invoiceStatus;
        $transaction = RentTransaction::where('invoice_id',$request->invoiceID)->first();
        $transaction->payment_transferred_status = $status;
        if($status=='Successful') {
            if($request->hasFile('image')){
                $file = $request->file('image');
                $file->move(storage_path('app/public/proofOfTransferred'), $transaction->invoice_id.'.'.$file->getClientOriginalExtension());
            }
        }
        if($status == 'Declined') {
            $chatController = new ChatController;
            $chatController->storeSpecificChatMessage(User::where('email','bhfms@gmail.com')->first()->id,
            TenantBoarding::find($transaction->tenant_boarding_id)->user_id,
            $request->reason);
        }
        $transaction->save();
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

    public function schedulePayment(){
        $currDate =  Carbon::now()->timezone('Asia/Jakarta');
        $previousDate = $currDate->startOfDay()->subDay();
        $nextMonthDate = clone $previousDate;
        $nextMonthDate->addMonth();
        $yesterdayTransactions = RentTransaction::where('payment_date',$previousDate->toDateString())
        ->where('repeat_payment',1)
        ->get();
        foreach ($yesterdayTransactions as $transaction) {
            RentTransaction::create([
                'tenant_boarding_id'=> $transaction->tenant_boarding_id,
                'transaction_type_id' => $transaction->transaction_type_id,
                'invoice_id' => $this->generateInvoice($nextMonthDate->toDateString()),
                'amount' => (floor($transaction->amount / 1000) * 1000)+  rand(0,1000),
                'payment_date' => $nextMonthDate,
                'repeat_payment'=> true,
            ]);
        }
    }

    public function checkLatePayment(){
        $currDate =  Carbon::now()->timezone('Asia/Jakarta')->startOfDay();
        $lateTransactions = RentTransaction::where('payment_date','<',$currDate)
        ->whereIn('payment_status', ['Pending', 'Rejected'])
        ->get();
        foreach ($lateTransactions as $transaction) {
            $transaction->payment_status = 'Late';
            $transaction->save();
        }
    }
    
}

