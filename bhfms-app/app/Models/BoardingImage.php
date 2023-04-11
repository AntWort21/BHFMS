<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardingImage extends Model
{
    use HasFactory;
    
    public function boarding() {
        return $this->belongsTo(BoardingImage::class,'boarding_images_id');
    }

    protected $guarded = [];
}
