<?php

namespace App\Http\Controllers;
use App\Models\AccessToken;
use Illuminate\Http\Request;

class AccessTokenController extends Controller
{
    public function index(){
    return response()->json([
        'message' => 'success',
    ],200);
   } 
}
