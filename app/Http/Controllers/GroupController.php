<?php

namespace App\Http\Controllers;

use App\Actions\Groups\CreateGroup;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class GroupController extends Controller
{
    public function create() : \Inertia\Response
    {
        return Inertia::render('Groups/Create');
    }

    public function edit(Group $group)
    {
        dd($group);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store() : \Illuminate\Http\RedirectResponse
    {
        app(CreateGroup::class)->storeForUser(request()->all(), Auth::user());

        return Redirect::route('dashboard');
    }
}
