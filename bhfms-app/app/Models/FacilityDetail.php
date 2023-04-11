<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityDetail extends Model
{
    use HasFactory;
    public function boardings(){
        return $this->belongsToMany(Boarding::class, 'facilities', 'boarding_id','boardings_id');
    }

    protected $guarded = [];
}
