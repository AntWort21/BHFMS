<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'country_id',
        'lat',
        'lng',
    ];
    public function country(){
        return $this->belongsTo(Country::class,'countries_id');
    }
    public function cities(){
        return $this->hasMany(City::class);
    }
}
