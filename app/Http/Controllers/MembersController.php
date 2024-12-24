<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\Project;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    //
    public function index(Request $request,Project $project){
    $members = $project->members()->paginate(10);
    return new UserCollection($members);
    }

    public function store(Request $request,Project $project){
        $request->validate([
            'user_id'=>'required|exists:users,id',
            // 'project_id'=>'required|exists:users,id'
        ]);

        $project->members()->syncWithoutDetaching([$request->user()->id]);
        $members=$project->members();
        return new UserCollection($members);
    }

    public function destroy(Request $request,Project $project,int $member ){
        abort_if($project->creator_id === $member ,400,'Cant remove creator from project !!');
        $project->members()->detach([$member]);
        $member=$project->members;
        return new UserCollection($member);
    }
}
