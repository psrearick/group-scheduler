<?php

namespace App\Repositories;

use App\Http\Requests\StoreGroupRequest;
use App\Models\Group;
use App\Models\User;

class GroupRepository extends Repository
{
    /**
     * @param StoreGroupRequest $request
     * @return Group
     */
    public function createGroup(StoreGroupRequest $request) : Group
    {
        return Group::create($request);
    }

    /**
     * @return Group
     */
    public function getCurrentGroup() : Group
    {
        return Group::find($this->getCurrentGroupId());
    }

    public function getCurrentGroupId() : int
    {
        return session('group');
    }

    /**
     * @param StoreGroupRequest $request
     * @return Group
     */
    public function store(StoreGroupRequest $request) : Group
    {
        return $this->createGroup($request);
    }

    /**
     * @param StoreGroupRequest $request
     * @param User $user
     * @return Group
     */
    public function storeForUser(StoreGroupRequest $request, User $user) : Group
    {
        $group = $this->createGroup($request);
        $user->groups()->attach($group->id);

        return $group;
    }
}
