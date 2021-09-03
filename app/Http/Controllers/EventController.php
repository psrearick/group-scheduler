<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Models\Group;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function store(StoreEventRequest $request)
//    public function store(Request $request)
    {
        dd('test');
//        dd($request->all());
    }
}
