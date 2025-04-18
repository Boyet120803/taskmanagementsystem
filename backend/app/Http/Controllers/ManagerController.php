<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\TeamMember;
use App\Models\TaskAssignment;

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

        public function profile(){
          
            $user = auth()->user();
            $fullName = $user->fname . ' ' . $user->mname . ' ' . $user->lname;
            return response()->json([
                'full_name' => $fullName,
                'email' => $user->email, 
                'role' => $user->role,
            ]);
        }

        public function getMyAssignedTasks()
        {
             $manager_id = Auth::id();

             $tasks = Task::where('assign_to', $manager_id)->get();

             return response()->json($tasks);
        }



        public function assignTaskToTeam(Request $request)
{
            $validated = $request->validate([
                'task_id' => 'required|exists:tasks,id',
                'user_id' => 'required|exists:users,id',
            ]);

            // I-check if na-assign na ba daan ang task sa user (optional)
            $existing = TaskAssignment::where('task_id', $validated['task_id'])
                                    ->where('user_id', $validated['user_id'])
                                    ->first();

            if ($existing) {
                return response()->json(['message' => 'This user is already assigned to the task.'], 409);
            }

            // I-save ang assignment
            TaskAssignment::create([
                'task_id' => $validated['task_id'],
                'user_id' => $validated['user_id'],
            ]);

            return response()->json(['message' => 'Task assigned successfully.']);
        }


                public function getTeamMembers()
                {
                    $managerId = auth()->id(); // get currently authenticated manager
                    $members = TeamMember::with('user')
                        ->where('manager_id', $managerId)
                        ->get();
                
                    return response()->json($members);
                }
                
            
}
