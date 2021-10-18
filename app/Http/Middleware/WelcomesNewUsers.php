<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WelcomesNewUsers
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasValidSignature()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        if (!$request->user) {
            abort(Response::HTTP_FORBIDDEN);
        }

//        if (is_null($request->user->welcome_valid_until)) {
//            abort(Response::HTTP_FORBIDDEN);
//        }
//
//        if (Carbon::create($request->user->welcome_valid_until)->isPast()) {
//            abort(Response::HTTP_FORBIDDEN);
//        }
        return $next($request);
    }
}
