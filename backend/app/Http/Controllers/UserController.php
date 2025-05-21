<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\TaskAssignment;
use App\Models\TaskSubmission;
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
    
        $assignments = TaskAssignment::where('user_id', $user->id)
            ->with(['task', 'manager'])
            ->get();
    
        if ($assignments->isEmpty()) {
            return response()->json(['message' => 'No task assigned'], 404);
        }
    
        $data = $assignments->map(function ($assignment) use ($user) {
            $submission = TaskSubmission::where('user_id', $user->id)
                            ->where('task_id', $assignment->task->id)
                            ->latest()
                            ->first();
    
            return [
                'task_id' => $assignment->task->id,
                'task_title' => $assignment->task->title,
                'task_description' => $assignment->task->description,
                'due_date' => $assignment->task->due_date,
                'status' => $submission ? $submission->status : 'Pending', // ← dito na galing ang status!
                'assigned_at' => $assignment->created_at->toDateTimeString(),
                'manager_name' => $assignment->manager ? $assignment->manager->fname . ' ' . $assignment->manager->lname : 'No Manager Assigned',
                'user_has_submitted' => $submission ? true : false,
                'reject_reason' => $submission ? $submission->reject_reason : null,
            ];
        });
    
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
                'image' => $user->image,
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

    public function submit(Request $request)
            {
                $request->validate([
                    'task_id' => 'required|exists:tasks,id',
                    'notes' => 'required|string',
                    'file' => 'nullable|file|max:2048'
                ]);

                $user = auth()->user();

                // Check if user already submitted this task
                $existing = TaskSubmission::where('user_id', $user->id)
                            ->where('task_id', $request->task_id)
                            ->first();

                if ($existing) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You have already submitted this task.'
                    ], 400);
                }

                $submission = new TaskSubmission();
                $submission->user_id = $user->id;
                $submission->task_id = $request->task_id;
                $submission->notes = $request->notes;
                $submission->status = 'Pending'; 

                if ($request->hasFile('file')) {
                    $path = $request->file('file')->store('task_files', 'public');
                    $submission->file_path = $path;
                }

                $submission->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Task submitted successfully. Waiting for manager review.'
                ]);
            }

    
}



