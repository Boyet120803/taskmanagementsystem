<?php

namespace App\Http\Controllers;
use App\Models\AccessToken;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class SampleController extends Controller
{
    public function sample(){
        $response = Http::asForm()->withHeaders([
        ])->get('https://backend.bdedal.online/users');
        return response()->json($response->object());
    }
}
