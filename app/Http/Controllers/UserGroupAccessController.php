<?php

namespace App\Http\Controllers;

use App\Actions\Groups\AccessGroup;
use App\Models\Group;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class UserGroupAccessController extends Controller
{
    public function show(Group $group): RedirectResponse
    {
        app(AccessGroup::class)->gainAccess($group);
        return Redirect::route('dashboard');
    }

    public function destroy(): RedirectResponse
    {
        app(AccessGroup::class)->revokeAccess();
        return Redirect::route('dashboard');
    }
}
