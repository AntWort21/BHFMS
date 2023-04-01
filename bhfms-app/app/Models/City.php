<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'province_id',
        'lat',
        'lng',
    ];
    public function province(){
        return $this->belongsTo(Province::class,'provinces_id');
    }
    public function districts(){
        return $this->hasMany(District::class);
    }
}
