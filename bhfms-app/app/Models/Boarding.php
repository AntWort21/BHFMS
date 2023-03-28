<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boarding extends Model
{
    public function boardingType(){
        return $this->belongsTo(RentTransactionHeader::class, 'boarding_types_id');
    }

    public function facilities(){
        return $this->hasMany(Facility::class);
    }

    public function rent_transaction_detail(){
        return $this->hasMany(RentTransactionDetail::class);
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
}