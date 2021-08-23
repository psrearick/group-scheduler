<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Session;

class MemberController extends Controller
{
    public function index()
    {
        $groupId = Session::get('group');
        $members = Group::find($groupId)->users;
        return Inertia::render('Members/Index', [
            'members' => $members,
        ]);
    }
}
