<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boarding extends Model
{
    public function boardingType(){
        return $this->belongsTo(BoardingType::class, 'boarding_types_id');
    }

    public function facilities(){
        return $this->hasMany(Facility::class);
    }

    public function tenantBoardings(){
        return $this->hasMany(TenantBoarding::class);
    }

    public function wishlists(){
        return $this->hasMany(Wishlist::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function ownerBoardings(){
        return $this->hasMany(OwnerBoarding::class);
    }

    public function complains(){
        return $this->hasMany(Complain::class);
    }

    protected $guarded = [];
}