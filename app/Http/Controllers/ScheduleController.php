<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Models\Group;
use App\Models\Schedule;
use App\Repositories\GroupRepository;
use App\Repositories\ScheduleRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ScheduleController extends Controller
{
    private GroupRepository $groupRepository;

    private ScheduleRepository $scheduleRepository;

    public function __construct(ScheduleRepository $repository, GroupRepository $groupRepository)
    {
        $this->scheduleRepository = $repository;
        $this->groupRepository    = $groupRepository;
    }

    public function destroy(Group $group, Schedule $schedule) : RedirectResponse
    {
        $this->scheduleRepository->deleteSchedule($schedule);

        return redirect()->back();
    }

    public function edit(Group $group, Schedule $schedule) : Response
    {
        return Inertia::render('Schedules/Edit', [
            'schedule'  => $this->scheduleRepository->getEagerLoadedSchedule(
                $schedule,
                ['events', 'events.members', 'events.tasks', 'events.tasks.members']
            ),
            'group'     => $group,
        ]);
    }

    public function index() : Response
    {
        return Inertia::render('Schedules/Index', [
            'schedules' => $this->scheduleRepository->getSchedulesForCurrentGroupPaginated(10),
        ]);
    }

    public function show(Group $group, Schedule $schedule) : Response
    {
        return Inertia::render('Schedules/Show', [
            'schedule'  => $schedule,
            'events'    => $this->scheduleRepository->getScheduleEventsPaginated($schedule, 10) ?: [],
            'group'     => $this->groupRepository->getCurrentGroup(),
        ]);
    }

    public function store(StoreScheduleRequest $request) : RedirectResponse
    {
        $this->scheduleRepository->createSchedule($request);

        return Redirect::back();
    }

    public function update(StoreScheduleRequest $request, Group $group, Schedule $schedule) : RedirectResponse
    {
        $this->scheduleRepository->updateSchedule($request, $schedule);

        return Redirect::back();
    }
}
