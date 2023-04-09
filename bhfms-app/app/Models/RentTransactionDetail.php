<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentTransactionDetail extends Model
{
    use HasFactory;

    public function paymentType(){
        return $this->belongsTo(PaymentType::class,'payment_types_id');
    }
    
    public function boarding(){
        return $this->belongsTo(Boarding::class,'boardings_id');
    }

    public function rentTransactionHeader(){
        return $this->belongsTo(RentTransactionHeader::class,'rent_transaction_header_id');
    }

    protected $guarded = [];
}
