<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function show() : Response
    {
        if (Session::get('group')) {
            $group = Session::get('group');
        }

        return isset($group)
            ? Inertia::render('Groups/Show')
            : (Auth::check()
                ? Inertia::render('Dashboard')
                : Inertia::render('Auth/Login'));
    }
}
