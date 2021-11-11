<?php

namespace App\Repositories;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Event;
use App\Models\Group;
use App\Models\Task;

class TaskRepository
{
    public function createTask(StoreTaskRequest $request, Group $group, Event $event) : void
    {
        $task = $event->tasks()->create([
            'name'        => $request->input('name'),
            'description' => $request->input('description'),
            'group_id'    => $group->id,
        ]);

        if (count($request->input('assigned')) > 0) {
            $task->members()->attach($request->input('assigned'));
        }
    }

    public function deleteTask(Task $task) : void
    {
        $task->delete();
    }

    public function updateTask(StoreTaskRequest $request, Task $task) : void
    {
        $task->update([
            'name'        => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        $task->members()->sync($request->input('assigned'));
    }
}
