<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\TeamMember;
use App\Models\TaskAssignment;
use App\Models\TaskSubmission;

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
        
            $tasks = Task::where('assign_to', $manager_id)
                ->with(['taskAssignments.user'])
                ->get();
            return response()->json($tasks);
        }



        public function assignTaskToTeam(Request $request)
        {
            $manager = Auth::user(); 
        
            if (!$manager || $manager->role != 1) { 
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        
            $validated = $request->validate([
                'task_id' => 'required|exists:tasks,id',
                'user_id' => 'required|exists:users,id',
            ]);
        
            $existing = TaskAssignment::where('task_id', $validated['task_id'])
                ->where('user_id', $validated['user_id'])
                ->first();
        
            if ($existing) {
                return response()->json(['message' => 'This user is already assigned to the task.'], 409);
            }
        
          
            TaskAssignment::create([
                'task_id' => $validated['task_id'],
                'user_id' => $validated['user_id'],
                'manager_id' => $manager->id, 
            ]);
        
                $task = Task::find($validated['task_id']);
                $user = User::find($validated['user_id']);

                return response()->json([
                    'message' => 'Task assigned successfully.',
                    'task' => [
                        'title' => $task->title,
                        'description' => $task->description,
                        'email' => $user->email,
                    ]
                ]);
        }
        

                public function getTeamMembers()
                {
                    $managerId = auth()->id(); 
                    $members = TeamMember::with('user')
                        ->where('manager_id', $managerId)
                        ->get();
                
                    return response()->json($members);
                }

                
                public function showUserSubmission($task_id, $user_id)
                {
                    $submission = TaskSubmission::where('task_id', $task_id)
                        ->where('user_id', $user_id)
                        ->first(); 
                
                    if (!$submission) {
                        return response()->json(['message' => 'No submission found.'], 404);
                    }
                
                    return response()->json([
                        'id' => $submission->id,
                        'notes' => $submission->notes,
                        'status' => $submission->status,
                        'file_path' => $submission->file_path,
                    ], 200);
                }


                public function updateStatus(Request $request, $id)
                {
                    $submission = TaskSubmission::find($id);
                
                    if (!$submission) {
                        return response()->json(['message' => 'Submission not found'], 404);
                    }
                
                    $submission->status = $request->status;
                
                    if ($request->status === 'Rejected') {
                        $submission->reject_reason = $request->reject_reason;
                    } else {
                        $submission->reject_reason = null;
                    }
                
                    $submission->save();
                
                    return response()->json(['message' => 'Status updated successfully']);
                }


                public function getCompletedTaskCount()
                    {
                        $managerId = Auth::id();
                        $teamMembers = TeamMember::where('manager_id', $managerId)->get();
                        $userIds = [];
                        foreach ($teamMembers as $member) {
                            $userIds[] = $member->user_id;
                        }
                        $completedCount = TaskSubmission::where('status', 'Completed')
                            ->whereIn('user_id', $userIds)
                            ->count();

                        return response()->json(['completed_count' => $completedCount]);
                    }

                    public function getPendingTaskCount()
                        {
                            $managerId = Auth::id();
                            $teamMembers = TeamMember::where('manager_id', $managerId)->get();

                            $userIds = [];
                            foreach ($teamMembers as $member) {
                                $userIds[] = $member->user_id;
                            }

                            $pendingCount = TaskSubmission::where('status', 'Pending')
                                ->whereIn('user_id', $userIds)
                                ->count();

                            return response()->json(['pending_count' => $pendingCount]);
                        }


                        public function getTotalTaskCount()
                        {
                            $managerId = Auth::id();
                            $teamMembers = TeamMember::where('manager_id', $managerId)->get();
                            $userIds = [];
                            foreach ($teamMembers as $member) {
                                $userIds[] = $member->user_id;
                            }
                            $totalCount = TaskSubmission::whereIn('user_id', $userIds)->count();
                        
                            return response()->json(['total_count' => $totalCount]);
                        }


             public function getReports(Request $request)
             {
                $managerId = Auth::id();
                $teamMembers = TeamMember::where('manager_id', $managerId)->get();

                $userIds = [];
                foreach ($teamMembers as $member) {
                    $userIds[] = $member->user_id;
                }

                $totalTasks = TaskSubmission::whereIn('user_id', $userIds)->count();
                $pending = TaskSubmission::whereIn('user_id', $userIds)
                        ->where('status', 'Pending')->count();
                $inProgress = TaskSubmission::whereIn('user_id', $userIds)
                            ->where('status', 'In Progress')->count();
                $completed = TaskSubmission::whereIn('user_id', $userIds)
                            ->where('status', 'Completed')->count();

                return response()->json([
                    'total_tasks' => $totalTasks,
                    'pending' => $pending,
                    'in_progress' => $inProgress,
                    'completed' => $completed
                ]);
             }

          

                
}
