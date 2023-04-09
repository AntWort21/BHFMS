<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentTransactionHeader extends Model
{
    use HasFactory;

    public function rentTransactionalDetail(){
        return $this->hasOne(RentTransactionDetail::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'users_id');
    }

    protected $guarded = [];
}
