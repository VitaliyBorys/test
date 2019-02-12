<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
class LastSeen
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
        if (!$request->user()) {
            return $next($request);
        }

        $user = $request->user();
        $user->update([
            'last_login' => Carbon::now()
        ]);

        return $next($request);
    }
}
