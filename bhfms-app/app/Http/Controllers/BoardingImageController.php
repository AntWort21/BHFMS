<?php

namespace App\Http\Controllers;

use App\Models\BoardingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BoardingImageController extends Controller
{
    public function deleteImage(Request $request)
    {
        
        $currImage = BoardingImage::where('id','=',$request->id)->first();
        // dd($currImage->image);
        if($currImage){
            Storage::delete('public/Boarding_House_Images/'.$currImage->image);
            $currImage -> delete();
        }
        return redirect()->back();
        // lete('public/image/'.$filename);
    }
}
