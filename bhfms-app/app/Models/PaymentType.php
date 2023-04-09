<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory;

    public function rentTransactionals(){
        return $this->hasMany(RentTransaction::class);
    }

    protected $guarded = [];
}
