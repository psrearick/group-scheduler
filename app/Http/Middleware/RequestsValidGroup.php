<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;

class RequestsValidGroup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $requestGroup = is_object($request->route()->group)
            ? $request->route()->group->id
            : $request->route()->group;
        if ($requestGroup != Session::get('group')) {
            return Redirect::route('dashboard')->with('failure', 'Invalid group');
        }

        return $next($request);
    }
}
