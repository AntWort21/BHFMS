<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerBoarding extends Model
{
    use HasFactory;

    //one to one relationship with middle table
    public function managerBoarding(){
        return $this->belongsTo(managerBoarding::class,'users_id');
    }

    protected $guarded = [];
}
