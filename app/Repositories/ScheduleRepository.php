<?php

namespace App\Repositories;

use App\Http\Requests\StoreScheduleRequest;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ScheduleRepository extends Repository
{
    private GroupRepository $groupRepository;

    public function __construct()
    {
        $this->groupRepository = new GroupRepository();
    }

    // create schedule for current group
    public function createSchedule(StoreScheduleRequest $request) : void
    {
        $this->groupRepository->getCurrentGroup()->schedules()->create([
            'name'          => $request->input('name'),
            'description'   => $request->input('description'),
        ]);
    }

    // delete
    public function deleteSchedule(Schedule $schedule) : void
    {
        $schedule->delete();
    }

    // get schedules lazy loaded with specified relationships
    public function getEagerLoadedSchedule(Schedule $schedule, array $relationships) : Schedule
    {
        return $schedule->load($relationships);
    }

    // get schedule builder for all non-deleted schedules in the current group
    public function getScheduleBuilderForCurrentGroup() : Builder
    {
        return $this->groupRepository->getCurrentGroup()->schedules()
            ->whereNull('deleted_at')->getQuery();
    }

    // get all schedule events
    public function getScheduleEvents(Schedule $schedule) : ?Builder
    {
        $events = $schedule->events;

        return $events->count() ? $events->toQuery()
            ->with(['members', 'tasks.members'])
            ->orderBy('date')
            : null;
    }

    // get all schedule events paginated
    public function getScheduleEventsPaginated(Schedule $schedule, int $paginate) : ?LengthAwarePaginator
    {
        return $this->getScheduleEvents($schedule)?->paginate($paginate);
    }

    // get the current groups schedule's paginated
    public function getSchedulesForCurrentGroupPaginated(int $paginate) : LengthAwarePaginator
    {
        return $this->getScheduleBuilderForCurrentGroup()->paginate($paginate);
    }

    // update existing schedule
    public function updateSchedule(StoreScheduleRequest $request, Schedule $schedule) : void
    {
        $schedule->update(
            [
                'name'          => $request->input('name'),
                'description'   => $request->input('description'),
            ]
        );
    }
}
