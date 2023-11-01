<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestBucketController extends Controller
{
    //
    public function store(Request $request){
        
        $path = $request->file('file')->storePublicly('public/images/test');

        return response()->json([
            'path' => $path,
            'msg' => 'success'
        ]);
    }

}
