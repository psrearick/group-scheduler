<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\Group;
use App\Repositories\EventRepository;
use App\Repositories\GroupRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class EventController extends Controller
{
    protected EventRepository $eventRepository;

    protected GroupRepository $groupRepository;

    public function __construct(EventRepository $eventRepository, GroupRepository $groupRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->groupRepository = $groupRepository;
    }

    public function destroy(Request $request, Group $group, Event $event) : RedirectResponse
    {
        $schedule = $event->schedule;

        $this->eventRepository->deleteEvent($event);

        if ($request->get('navigate') && $schedule) {
            return redirect()->route('groups.schedules.show', [
                'group'     => $group,
                'schedule'  => $schedule,
            ]);
        }

        if ($request->navigate) {
            return redirect()->route('groups.events.index', [
                'group'     => $group,
            ]);
        }

        return redirect()->back();
    }

    public function index() : Response
    {
        return Inertia::render('Events/Index', [
            'events'    => $this->eventRepository->getEventsForGroupPaginated(10),
            'group'     => $this->groupRepository->getCurrentGroup(),
        ]);
    }

    public function show(Group $group, Event $event)
    {
        $eventLoaded = $this->eventRepository->getEventEager($event);
        $tasks = $this->eventRepository->getEventTasks($event)->with('members')->paginate();

        return Inertia::render('Events/Show', [
            'event'     => $eventLoaded,
            'tasks'     => $tasks,
        ]);
    }

    public function store(StoreEventRequest $request) : RedirectResponse
    {
        $this->eventRepository->saveEvent($request);

        return Redirect::back();
    }

    public function update(UpdateEventRequest $request, Group $group, Event $event) : RedirectResponse
    {
        $this->eventRepository->updateEvent($request, $event);

        return Redirect::back();
    }
}
