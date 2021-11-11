<?php

namespace App\Repositories;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Event;
use App\Models\Group;

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
}
