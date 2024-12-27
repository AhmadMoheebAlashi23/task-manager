<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectController extends Controller
{
    //

    // public function __construct(){
    //     $this->authorizeResource( Project::class, "projects");
    // }

    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
    }

    public function index(Request $request,Project $project){

        $projects = QueryBuilder::for(Project::class)
        ->allowedIncludes('tasks')
        // ->defaultSort('-created_at')
        // ->allowedSorts(['title','is_done','created_at'])
        ->paginate();
        // return new ProjectResource($tasks);
        return new ProjectCollection($projects);
    }

    public function show(Request $request,Project $project){
        return (new ProjectResource($project))
        ->load('tasks')
        ->load('members');

    }

    public function store(StoreProjectRequest $storeProjectRequest){
        $validated=$storeProjectRequest->validated();
        $project =Auth::user()->projects()->create($validated);
        return new ProjectResource($project) ;
    }

    public function update(UpdateProjectRequest $updateProjectRequest,Project $project ){
        $validated=$updateProjectRequest->validated();
        $project->update($validated);

        return new ProjectResource($project);
    }

    public function destroy(Request $request,Project $project){
        $project->delete();
        return response()->noContent();
    }
}
