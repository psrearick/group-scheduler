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
        Inertia::share('group', fn () => session('group')
            ? Group::find(session('group'))
            : null);

//        dd(Session::all());
//        Inertia::share('success', Session::get('success'));
//        ray(Session::all());
//
//        session()->reflash();
//        Inertia::share('flash', function () {
//            return [
//                'success'   => session('success'),
//                'error'     => session('failure'),
//            ];
//        });
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
