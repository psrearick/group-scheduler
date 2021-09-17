<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Models\Group;
use App\Repositories\GroupRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class GroupController extends Controller
{
    private GroupRepository $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * @return Response
     */
    public function create() : Response
    {
        return Inertia::render('Groups/Create');
    }

    public function edit(Group $group) : void
    {
        //
    }

    /**
     * @param StoreGroupRequest $request
     * @return RedirectResponse
     */
    public function store(StoreGroupRequest $request) : RedirectResponse
    {
        $this->groupRepository->storeForUser($request, Auth::user());

        return Redirect::route('dashboard');
    }
}
