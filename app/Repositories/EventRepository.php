<?php

namespace App\Repositories;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EventRepository extends Repository
{
    public function deleteEvent(Event $event) : void
    {
        $event->delete();
    }

    public function getEventsBuilderForGroup() : Builder
    {
        return Event
            ::with(['schedule', 'members', 'tasks.members'])
            ->where('group_id', session('group'))
            ->whereNull('deleted_at')
            ->orderBy('date', 'desc');
    }

    public function getEventsForGroup() : Collection
    {
        return $this->getEventsBuilderForGroup()->get();
    }

    public function getEventsForGroupPaginated(int $paginate) : LengthAwarePaginator
    {
        return $this->getEventsBuilderForGroup()->paginate($paginate);
    }

    public function saveEvent(StoreEventRequest $request) : void
    {
        $startDate = date('Y-m-d H:i:s', strtotime($request->get('start_date')));
        if (!$request->get('recurring')) {
            $event = $this->createEvent($request->all());
            if ($request->get('assigned')) {
                $this->saveAssignees($event, $request->get('assigned'));
            }

            return;
        }

        $endDate = date('Y-m-d H:i:s', strtotime($request->get('end_date')));
        $day     = new Carbon($startDate, new DateTimeZone('America/New_York'));
        $end     = new Carbon($endDate, new DateTimeZone('America/New_York'));
        while ($end->greaterThanOrEqualTo($day)) {
            $requestData               = $request->all();
            $requestData['start_date'] = $day;
            $event                     = $this->createEvent($requestData);
            $this->saveAssignees($event, $request->get('assigned'));
            if ($request->get('frequency') == 'day') {
                $day->addDay();
            }
            if ($request->get('frequency') == 'week') {
                $day->addWeek();
            }
            if ($request->get('frequency') == 'month') {
                $day->addMonthNoOverflow();
            }
            if ($request->get('frequency') == 'year') {
                $day->addYearNoOverflow();
            }
        }
    }

    public function updateEvent(UpdateEventRequest $request, Event $event) : void
    {
        $startDate = date('Y-m-d H:i:s', strtotime($request->get('start_date')));
        $event->update([
            'name'          => $request->get('name'),
            'description'   => $request->get('description'),
            'date'          => new Carbon($startDate, new DateTimeZone('America/New_York')),
        ]);
        $event->members()->sync($request->get('assigned'));
    }

    private function createEvent(array $event) : Event
    {
        $startDate = date('Y-m-d H:i:s', strtotime($event['start_date']));

        return Event::create([
            'name'          => $event['name'],
            'description'   => $event['description'],
            'date'          => $startDate,
            'schedule_id'   => $event['schedule_id'],
            'group_id'      => Session::get('group'),
        ]);
    }

    private function saveAssignees(Event $event, array $assignees) : void
    {
        $event->members()->attach($assignees);
    }
}
