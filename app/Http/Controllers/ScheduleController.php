<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Models\Group;
use App\Models\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Request;
use Session;

class ScheduleController extends Controller
{
    public function edit(Group $group, Schedule $schedule) : Response
    {
        return Inertia::render('Schedules/Edit', [
            'schedule'  => $schedule->load(['events', 'events.members', 'events.tasks', 'events.tasks.members']),
            'group'     => $group,
        ]);
    }
    public function index(): Response
    {
        return Inertia::render('Schedules/Index', [
            'schedules' => Schedule
                ::where('group_id', Session::get('group'))
                ->whereNull('deleted_at')
                ->get(),
        ]);
    }

    public function show(Group $group, Schedule $schedule) : Response
    {
        return Inertia::render('Schedules/Show', [
            'schedule'  => $schedule->load(['events', 'events.members', 'events.tasks', 'events.tasks.members']),
            'group'     => Group::find(Session::get('group')),
        ]);
    }

    public function store(StoreScheduleRequest $request) : RedirectResponse
    {
        $request->group->schedules()->create([
            'name'          => $request->input('name'),
            'description'   => $request->input('description'),
        ]);

        return Redirect::back();
    }

    public function update(Schedule $schedule, StoreScheduleRequest $request) : RedirectResponse
    {
        $schedule->update(
            [
                'name'          => $request->input('name'),
                'description'   => $request->input('description'),
            ]
        );

        return Redirect::back();
    }
}
