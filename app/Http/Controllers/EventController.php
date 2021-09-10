<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\Group;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class EventController extends Controller
{
    public function destroy(Group $group, Event $event)
    {
        $event->delete();

        return redirect()->back();
    }

    public function index()
    {
        return Inertia::render('Events/Index', [
            'events'    => Event
                ::with(['schedule', 'members', 'tasks.members'])
                    ->where('group_id', session('group'))
                    ->whereNull('deleted_at')
                    ->orderBy('date', 'desc')
                    ->paginate(10),
            'group'     => Group::find(session('group')),
        ]);
    }

    public function show(Group $group, Event $event)
    {
        //
    }

    public function store(StoreEventRequest $request) : RedirectResponse
    {
        $startDate = date('Y-m-d H:i:s', strtotime($request->get('start_date')));
        if (!$request->get('recurring')) {
            $event = $this->saveEvent($request->all());
            if ($request->get('assigned')) {
                $this->saveAssignees($event, $request->get('assigned'));
            }

            return Redirect::back();
        }

        $endDate = date('Y-m-d H:i:s', strtotime($request->get('end_date')));
        $day     = new Carbon($startDate, new DateTimeZone('America/New_York'));
        $end     = new Carbon($endDate, new DateTimeZone('America/New_York'));
        while ($end->greaterThanOrEqualTo($day)) {
            $requestData               = $request->all();
            $requestData['start_date'] = $day;
            $event                     = $this->saveEvent($requestData);
            $this->saveAssignees($event, $request->get('assigned'));
            if ($request->get('frequency') == 'day') {
                $day->addDay();
            }
            if ($request->get('frequency') == 'week') {
                $day->addWeek();}
            if ($request->get('frequency') == 'month') {
                $day->addMonthNoOverflow();
            }
            if ($request->get('frequency') == 'year') {
                $day->addYearNoOverflow();
            }
        }

        return Redirect::back();
    }

    public function update(UpdateEventRequest $request, Group $group, Event $event)
    {
        $startDate = date('Y-m-d H:i:s', strtotime($request->get('start_date')));
        $event->update([
            'name'          => $request->get('name'),
            'description'   => $request->get('description'),
            'date'          => new Carbon($startDate, new DateTimeZone('America/New_York')),
        ]);
        $event->members()->sync($request->get('assigned'));

        return Redirect::back();
    }

    private function saveAssignees(Event $event, array $assignees) : void
    {
        $event->members()->attach($assignees);
    }

    private function saveEvent(array $event) : Event
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
}
