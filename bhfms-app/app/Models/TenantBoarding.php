<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantBoarding extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'boarding_id',
        'status',
        'declined_reason',
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function boarding(){
        return $this->belongsTo(Boarding::class,'boarding_id');
    }
    public function rentTransactions(){
        return $this->hasMany(RentTransaction::class);
    }
    
    protected $guarded = [];
}
