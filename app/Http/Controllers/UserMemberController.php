<?php

namespace App\Http\Controllers;

use App\Actions\Members\GenerateUsername;
use App\Http\Requests\StoreMemberRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UserMemberController extends Controller
{
    public function store(StoreMemberRequest $request) : RedirectResponse
    {
        $user = User::create([
            'name'     => $request->input('name'),
            'username' => $request->input('username')
                ?? (new GenerateUsername($request->input('name')))->generate(),
            'email'            => $request->input('email'),
            'phone_number'     => $request->input('phone_number'),
            'groupme_username' => $request->input('groupme_username'),
        ]);

        $user->groups()->syncWithoutDetaching(Session::get('group'));

        return Redirect::back();
    }
}
