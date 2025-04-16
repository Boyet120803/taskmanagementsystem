<?php

namespace App\Http\Controllers;
use App\Models\AdminTask;
use App\Models\User;
use Illuminate\Http\Request;

class AdminTaskController extends Controller
{
    public function index()
        {
            $tasks = AdminTask::with('assignedUser')->get(); 
            return response()->json($tasks); 
        }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|max:50',
            'due_date' => 'nullable|date',
            'assign_to' => 'nullable|exists:users,id', 
        ]);
        $task = AdminTask::create([
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
            $task = AdminTask::find($id);
            if (!$task) {
                return response()->json(['message' => 'Task not found'], 404);
            }
    
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'status' => 'required|string|in:Pending,In Progress,Completed',
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

    public function show($id){
        $task = AdminTask::find($id);

        if(!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        return response()->json($task);
    }

    public function destroy($id){
        $task = AdminTask::find($id);
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


}
