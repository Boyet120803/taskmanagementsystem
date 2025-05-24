<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;

class AdminTaskController extends Controller
{
    public function index()
      {
            $tasks = Task::with(['assignedUser', 'submissions' => function($query) {
                $query->latest()->limit(1);
            }])->get();
        
            $formattedTasks = $tasks->map(function ($task) {  // ang map I-transform or i-format ang kada task 
                $latestSubmission = $task->submissions->first();
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'status' => $latestSubmission ? $latestSubmission->status : 'Pending',
                    'assigned_user' => $task->assignedUser 
                        ? $task->assignedUser->fname . ' ' . $task->assignedUser->lname 
                        : 'Unassigned',
                    'due_date' => $task->due_date,
                ];
            });
        
            return response()->json($formattedTasks);
        }
    

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|max:50',
            'due_date' => 'nullable|date',
            'assign_to' => 'nullable|exists:users,id', 
        ]);
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'assign_to' => $request->assign_to, 
        ]);
        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $task = Task::find($id);
            if (!$task) {
                return response()->json(['message' => 'Task not found'], 404);
            }
    
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'due_date' => 'nullable|date',
                'assign_to' => 'nullable|exists:users,id',
            ]);
    
            $task->update($validated);
    
            return response()->json($task);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Update failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
        {
            $task = Task::with(['submissions' => function($query) {
                $query->latest()->limit(1); // Kunin ang latest submission
            }])->find($id);
        
            if (!$task) {
                return response()->json(['message' => 'Task not found'], 404);
            }
        
            $latestSubmission = $task->submissions->first();
        
            return response()->json([
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $latestSubmission ? $latestSubmission->status : 'Pending',
                'due_date' => $task->due_date,
                'assigned_user' => $task->assignedUser 
                    ? $task->assignedUser->fname . ' ' . $task->assignedUser->lname 
                    : 'Unassigned',
            ]);
        }

    public function destroy($id){
        $task = Task::find($id);
        if(!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        return response()->json([
            'deleted' => $task->delete(),
            'message' => 'Task deleted successfully',
        ]);
    }

    public function logout(Request $request)
    {
        $task = Auth::user();
        $task->tokens()->delete();
    
        return response()->json([
            'message' => 'Logout successful',
        ]);
    }




        public function getAssignableUsers()
        {
            $users = User::whereIn('role', [1, 2])->get();
            return response()->json($users);
        }

         public function getAssignableUsersfordropdown()
        {
            $users = User::whereIn('role', [1, 2])->get();
            return response()->json($users);
        }



        public function getReports()
        {
            $totalTasks = TaskSubmission::count();
            $pending = TaskSubmission::where('status', 'Pending')->count();
            $inProgress = TaskSubmission::where('status', 'In Progress')->count();
            $completed = TaskSubmission::where('status', 'Completed')->count();

            return response()->json([
                'total_tasks' => $totalTasks,
                'pending' => $pending,
                'in_progress' => $inProgress,
                'completed' => $completed
            ]);
        }


}
