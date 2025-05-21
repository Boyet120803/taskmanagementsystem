<?php

namespace App\Http\Controllers;
use illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\TaskSubmission;
use App\Models\Task;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
       return response()->json([
         'users' => User::all(),
       ]);
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
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image')->store('uploads', 'public');
            }
        
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
                'image' => $image ?? null,
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

             $user->update($request->all());
             return response()->json([
                'message' => 'User updated successfully',
                'user' => $user,
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
    
        public function profile(){
          
            $user = auth()->user();
            $fullName = $user->fname . ' ' . $user->mname . ' ' . $user->lname;
            return response()->json([
                'full_name' => $fullName,
                'email' => $user->email, 
                'role' => $user->role,
            ]);
        }
        
        public function getUsers()
        {
            $users = User::whereIn('role', [1, 2])->get();
            return response()->json([
                'status' => 'success',
                'total_users' => $users->count(), // <-- ito ang kulang
                'users' => $users,
            ]);
        }

        public function getPendingTaskCount()
        {
            $count = TaskSubmission::where('status', 'Pending')->count();

            return response()->json([
                'pending_count' => $count,
            ]);
        }

        public function getCompleteTaskCount()
        {
            $count = TaskSubmission::where('status', 'Completed')->count();

            return response()->json([
                'completed_count' => $count,
            ]);
        }

        public function getTotalTaskCount()
        {
            $count = Task::count(); // Count lahat ng tasks

            return response()->json([
                'total_task_count' => $count,
            ]);
        }
       
        

    }

