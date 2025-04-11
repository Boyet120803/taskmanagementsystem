<?php

namespace App\Http\Controllers;
use App\Models\AdminTask;
use Illuminate\Http\Request;

class AdminTaskController extends Controller
{
    public function index(){
        return response()->json(AdminTask::all());
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|max:50',
            'due_date' => 'nullable|date',
        ]);
        $task = Admintask::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
        ]);
        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task,
        ]);
    }

    public function update(Request $request, $id){

        $task = AdminTask::find($id);
        if(!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|max:50',
            'due_date' => 'nullable|date',
        ]);
        $task->update($request->all());
        return response()->json($task);
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
}
