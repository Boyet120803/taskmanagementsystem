<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\TaskAssignment;

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

    public function userTasks()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    
        $assignment = TaskAssignment::with(['task', 'manager'])
            ->where('user_id', $user->id)
            ->latest() 
            ->first();
    
        if (!$assignment) {
            return response()->json(['message' => 'No task assigned'], 404);
        }
    
        $data = [
            'task_id' => $assignment->task->id,
            'task_title' => $assignment->task->title,
            'task_description' => $assignment->task->description,
            'due_date' => $assignment->task->due_date,
            'status' => $assignment->task->status,
            'assigned_at' => $assignment->created_at->toDateTimeString(),
            'manager_name' => $assignment->manager ? $assignment->manager->fname . ' ' . $assignment->manager->lname : 'No Manager Assigned',
        ];
    
        return response()->json($data);
    }
    

        public function userprofile(){
        $user = auth()->user();
        return response()->json([
                'fname' => $user->fname,
                'mname' => $user->mname,
                'lname' => $user->lname,
                'gender' => $user->gender,
                'address' => $user->address,
                'contact' => $user->contact,
                'birthdate' => $user->birthdate,
                'age' => $user->age,
                'email' => $user->email,
        ]);

        return response()->json($user);
    }

    public function update(Request $request)
    {
       
        $user = auth()->user();
    
      
        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'contact' => 'required|string|max:15',
            'birthdate' => 'required|date',
            'age' => 'required|integer|min:0',
            'email' => 'required|email|max:255',
        ]);
    
       
        $user->update($validated);
    
      
        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user,
        ]);
    }
    
}



