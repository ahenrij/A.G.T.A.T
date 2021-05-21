<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Usager
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
        if (Auth::user()->typeUser->libelle == USAGER_LABEL || Auth::user()->typeUser->libelle == ADMIN_LABEL) {
            return $next($request);
        }

        abort(401);
    }
}
