<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerBoarding extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function ownerBoarding(){
        return $this->belongsTo(OwnerBoarding::class,'owner_boardings_id');
    }
}
