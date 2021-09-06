<?php

namespace App\Http\Controllers;

use App\Helpers\CollectionHelper;
use App\Models\Group;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;
use Session;

class MemberController extends Controller
{
    /**
     * @throws BindingResolutionException
     */
    public function index() : Response
    {
        $groupId = Session::get('group');
        $members = Group::find($groupId)->users;

        return Inertia::render('Members/Index', [
            'members' => CollectionHelper::paginate($members, 10),
        ]);
    }

    public function store(Request $request) : RedirectResponse
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
