<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class EventController extends Controller
{
    public function store(StoreEventRequest $request): RedirectResponse
    {
        dd($request->all());
        $date = date('Y-m-d H:i:s', strtotime($request->get('start_date')));
//        $date = DateTime::createFromFormat('Y-m-d', $request->get('date'));
//        dd($date);
//        dd($date->format('Y-m-d H:i:s'));


//        dd(Carbon::parse($request->get('date'))->format('Y-m-d'));
//        dd([$request->all(), Carbon::createFromFormat('Y-m-d', $request->get('date'), 'America/New_York')]);
        if (!$request->get('recurring')) {
            Event::create([
                'name'          => $request->get('name'),
                'description'   => $request->get('description'),
                'date'          => Carbon::parse($request->get('date')),
                'schedule_id'   => $request->get('schedule_id'),
                'group_id'      => Session::get('group'),
            ]);

            return Redirect::back();
        }

        if ($request->get('frequency') == 'day') {

        }

        return Redirect::back();
    }
}
