<?php

namespace App\Http\Controllers;

use App\Actions\Groups\AccessGroup;
use App\Models\Group;
use Inertia\Inertia;

class UserGroupController extends Controller
{
    public function create() {
        return Inertia::render('UserGroups/Create');
    }
}
