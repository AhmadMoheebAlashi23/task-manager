<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskeRequest;
use App\Http\Requests\UpdateTaskeRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
// use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{


    public function __construct(){
        $this->authorizeResource( Task::class, "task");
    }


    public function index(Request $request){

        $tasks = QueryBuilder::for(Task::class)
        ->allowedFilters('is_done')
        ->defaultSort('-created_at')
        ->allowedSorts(['title','is_done','created_at'])
        ->paginate();
        return new TaskCollection($tasks);
    }

    public function show(Request $request, Task $task)    {
        return new TaskResource($task);
    }

    public function store(StoreTaskeRequest $request){
        $validate=$request->validated();

        $task=Auth::user()->tasks()->create($validate);
        return new TaskResource($task);

    }

    public function update(UpdateTaskeRequest $request,Task $task){
        $validated=$request->validated();

        $task->update($validated);
        return new TaskResource($task);

    }


    public function destroy(Request $request,Task $task){


        $task->delete();
        return response()->noContent();



    }
}
