<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\Group;
use App\Repositories\EventRepository;
use App\Repositories\GroupRepository;
use Illuminate\Http\RedirectResponse;
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

    public function destroy(Group $group, Event $event) : RedirectResponse
    {
        $this->eventRepository->deleteEvent($event);

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
        //
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
