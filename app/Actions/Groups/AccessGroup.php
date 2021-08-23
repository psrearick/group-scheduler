<?php

namespace App\Actions\Groups;

use App\Models\Group;
use Illuminate\Support\Facades\Session;

class AccessGroup
{
    public function currentGroup()
    {
        return Session::get('group');
    }

    public function gainAccess(Group $group)
    {
        Session::forget('group');
        Session::put('group', $group->id);
    }

    public function revokeAccess()
    {
        Session::forget('group');
    }
}
