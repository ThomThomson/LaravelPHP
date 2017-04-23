<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class checkBackend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(!Auth::user()->getIsAdminAttribute() and !Auth::user()->getIsEditorAttribute()) {
            //Auth::logout();
            return back();
        }

        return $next($request);
    }
}
