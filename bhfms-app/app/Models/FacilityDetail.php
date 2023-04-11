<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityDetail extends Model
{
    use HasFactory;
    public function facilities(){
        return $this->belongsToMany(Boarding::class, 'facilities', 'boarding_id','facility_id');
        // return $this->hasMany(facility::class);
    }

    protected $guarded = [];
}
