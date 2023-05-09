<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function getAllPaymentMethodPage(){
        $PaymentMethods = PaymentMethod::paginate(5)->withQueryString();
        return inertia('PaymentMethod/ListPaymentMethod', [
            'paymentMethods' => $PaymentMethods
        ]);
    }

    public function getPaymentMethodCreate(){
        return inertia('PaymentMethod/CreatePaymentMethod', [
        ]);
    }

    public function PaymentMethodCreate(Request $request){
        $validation = $request->validate([
            'name' => ['required', 'max:200', 'min:3','unique:payment_methods,payment_method_name,'],
            'status' => ['required'],
        ]);

        PaymentMethod::create([
            'payment_method_name' => $request->name,
            'status'=> $request->status,
        ]);

        return redirect('/paymentMethodAll')->with('message', 'Success Creating new Transaction Type');
    }

    public function getPaymentMethodUpdate(Request $request){
        $currPaymentMethod = PaymentMethod::find($request->id);
        return inertia('PaymentMethod/UpdatePaymentMethod', [
            'paymentMethod' => $currPaymentMethod,
        ]);
    }

    public function PaymentMethodUpdate(Request $request){

        $validation = $request->validate([
            'name' => ['required', 'max:200', 'min:3','unique:payment_methods,payment_method_name,' . $request->id],
            'status' => ['required'],
        ]);

        PaymentMethod::where('id','=',$request->id)->update([
            'payment_method_name' => $request->name,
            'status'=> $request->status,
        ]);

        return redirect('/paymentMethodAll')->with('message', 'Success Updating Transaction Type');
    }

    public function PaymentMethodDelete(Request $request){
        $currPaymentMethod = PaymentMethod::where('id','=',$request->id)->first();

        $currPaymentMethod->delete();

        return redirect('paymentMethodAll')->with('message', 'Success Deleting Transaction Type');
    }
}
