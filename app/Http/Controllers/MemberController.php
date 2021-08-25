<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;
use Session;

class MemberController extends Controller
{
    public function index(): Response
    {
        $groupId = Session::get('group');
        $members = Group::find($groupId)->users;
        return Inertia::render('Members/Index', [
            'members' => $members,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username'  => 'required_without:email',
            'email'     => 'required_without:username',
        ]);

        if ($validated['email']) {
            $user = User::where('email', '=', $validated['email'])->first();

            if (!$user) {
                return Redirect::back()->withErrors(['email' => 'Email not found']);
            }
        }

        if ($validated['username']) {
            $user = User::where('username', '=', $validated['username'])->first();

            if (!$user) {
                return Redirect::back()->withErrors(['username' => 'Username not found']);
            }
        }

        $user->groups()->syncWithoutDetaching(Session::get('group'));

        return Redirect::back();
    }
}
