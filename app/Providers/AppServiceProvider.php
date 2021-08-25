<?php

namespace App\Providers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Inertia::share('groups', fn (Request $request) => $request->user()
            ? $request->user()->groups
            : null
        );
        Inertia::share('group', fn () => Session::get('group')
            ? Group::find(Session::get('group'))
            : null);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
