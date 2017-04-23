<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class checkEditArticleAccess
{

    public function handle($request, Closure $next)
    {

        if(!Auth::user()->getIsAuthorAttribute() && !Auth::user()->getIsEditorAttribute()) {
            return back();
        }

        return $next($request);
    }

}
