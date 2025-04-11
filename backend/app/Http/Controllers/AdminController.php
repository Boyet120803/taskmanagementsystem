<?php

namespace App\Http\Controllers;
use illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search', '');
        $users = User::where('fname', 'LIKE', "%{$searchTerm}%")
            ->orWhere('lname', 'LIKE', "%{$searchTerm}%")
            ->orWhere('email', 'LIKE', "%{$searchTerm}%")
            ->get();
    
        return response()->json(['users' => $users]);
    }

        public function login(Request $request)
        {
            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) {
                $user = Auth::user();
                $token = $user->createToken('mytoken')->plainTextToken;
        
                return response()->json([
                    'message' => 'Login successful',
                    'token' => $token,
                    'role' => $user->role,
                ]);
            } else {
                return response()->json([
                    'message' => 'Invalid credentials',
                ], 401);
            }
        }

        public function register(Request $request){
            $request->validate([
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|integer|in:0,1,2',
                'fname' => 'required|string|max:255',
                'mname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'gender' => 'required|string',
                'address' => 'required|string|max:255',
                'contact' => 'required|string|max:11',
                'birthdate' => 'required|date',
                'age' => 'required|integer|min:0',
            ]);
        
            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'fname' => $request->fname,
                'mname' => $request->mname,
                'lname' => $request->lname,
                'gender' => $request->gender,
                'address' => $request->address,
                'contact' => $request->contact,
                'birthdate' => $request->birthdate,
                'age' => $request->age,
            ]);
        
            return response()->json([
                'message' => 'User created successfully',
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

        public function update(Request $request, $id){
            $user = User::find($id);
             $request->validate([
                'email' => 'string|email|max:255|unique:users,email,'.$id,
                'password' => 'string|min:8|confirmed',
                'role' => 'integer|in:0,1,2',
                'fname' => 'string|max:255',
                'mname' => 'string|max:255',
                'lname' => 'string|max:255',
                'gender' => 'string',
                'address' => 'string|max:255',
                'contact' => 'string|max:11',
                'birthdate' => 'date',
                'age' => 'integer|min:0',
             ]);
        }

        public function show($id){
            $user = User::find($id);
            if(!$user){
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }
            return response()->json($user);
        }


        public function destroy($id){
            $user = User::find($id);
            if(!$user){
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }
            return response()->json([
                'deleted' => $user->delete(),
                'message' => 'User deleted successfully',
            ]);
        }
    
    }

