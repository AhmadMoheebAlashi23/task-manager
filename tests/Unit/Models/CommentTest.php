<?php

namespace Tests\Unit\Models;

use App\Models\Project;
use App\Models\Task;
use Tests\TestCase;

Class CommentTest extends TestCase{
    public function test_tasks_can__have_comments():void{
        $task= Task::factory()->create();
        $comments=$task->comments()->create()->make([
            'content'=>'Tesk Comment'
        ]);

        $comments->user()->associate($task->creator);

        $comments->save();

        $comments->assertModelExists();
    }

    public function test_projects_can__have_comments():void{
        $project= Project::factory()->create();
        $comments=$project->comments()->create()->make([
            'content'=>'Tesk Comment'
        ]);

        $comments->user()->associate($project->creator);

        $comments->save();

        $comments->assertModelExists();
    }
}
