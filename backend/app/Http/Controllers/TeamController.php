<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // Kunin ang lahat ng pwedeng i-assign na users (role = 2 for regular user)
    public function getAvailableUsers()
    {
        $users = User::where('role', 2)->get();
        return response()->json($users);
    }

    public function assignToTeam(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
    
        $manager_id = Auth::id(); // current manager
        $user_id = $request->user_id;
    
        // Check kung existing na ang assignment
        $exists = TeamMember::where('manager_id', $manager_id)
                            ->where('user_id', $user_id)
                            ->first();
    
            if ($exists) {
                return response()->json(['message' => 'User already assigned.'], 409);
            }
        
            // Create the team member assignment
            $teamMember = TeamMember::create([
                'manager_id' => $manager_id,
                'user_id' => $user_id
            ]);
        
            return response()->json([
                'message' => 'User assigned to your team.',
                'team' => $teamMember
            ]);
        }
    

        public function getTeamMembers()
        {
            $manager_id = Auth::id();
        
            $teamMembers = TeamMember::with('user')
                ->where('manager_id', $manager_id)
                ->get();
        
            return response()->json($teamMembers);
        }
        
        

        public function removeFromTeam($user_id)
            {
                $manager_id = Auth::id();
                $member = TeamMember::where('manager_id', $manager_id)->where('user_id', $user_id)->first();

                if (!$member) {
                    return response()->json(['message' => 'User not found in your team.'], 404);
                }

                $member->delete();
                return response()->json(['message' => 'User removed from your team.']);
            }

}
