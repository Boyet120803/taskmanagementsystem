<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index(){  
        $user = Auth::user();
        return response()->json([
            'message' => 'Welcome to the manager dashboard',
            'user' => $user,
        ]);
    }

        public function logout(Request $request)
        {
            $user = Auth::user();
            $user->tokens()->delete();
        
            return response()->json([
                'message' => 'Logout successful',
            ]);
        }
}
