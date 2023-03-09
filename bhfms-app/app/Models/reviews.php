<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reviews extends Model
{
    use HasFactory;

    public function facilityDetail(){
        return $this->belongsTo(FacilityDetail::class,'facility_details_id');
    }

    public function boarding(){
        return $this->belongsTo(Boarding::class,'boardings_id');
    }
}
