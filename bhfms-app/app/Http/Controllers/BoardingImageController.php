<?php

namespace App\Http\Controllers;

use App\Models\BoardingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Cast\String_;

class BoardingImageController extends Controller
{
    public function deleteImage(Request $request)
    {
        
        $currImage = BoardingImage::where('id','=',$request->id)->first();
        // dd($currImage->image);
        // $currImage_path = String_($currImage->image).split("/")[1];
        $currImage_path = $currImage->image;
        $currImage_path = explode('/storage/', $currImage_path);

        // $string_val = 'a.b';

        // $parts = explode('.', $string_val);
        // dd($currImage_path[1]);
        if($currImage){
            Storage::delete('public/'.$currImage_path[1]);
            $currImage -> delete();
        }
        return redirect()->back();
    }
}
