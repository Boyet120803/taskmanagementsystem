<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return response()->json([
            'message' => 'Welcome to the user dashboard',
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

    public function profile(){
          
        $user = auth()->user();
        $fullName = $user->fname . ' ' . $user->mname . ' ' . $user->lname;
        return response()->json([
            'full_name' => $fullName,
            'email' => $user->email, 
            'role' => $user->role,
        ]);
    }
}
