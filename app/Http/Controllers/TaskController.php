<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Event;
use App\Models\Group;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class TaskController extends Controller
{
    private $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function destroy(Group $group, Event $event, Task $task) : RedirectResponse
    {
        $this->repository->deleteTask($task);

        return Redirect::back();
    }

    public function store(StoreTaskRequest $request, Group $group, Event $event) : RedirectResponse
    {
        $this->repository->createTask($request, $group, $event);

        return Redirect::back();
    }

    public function update(StoreTaskRequest $request, Group $group, Event $event, Task $task) : RedirectResponse
    {
        $this->repository->updateTask($request, $task);

        return Redirect::back();
    }
}
