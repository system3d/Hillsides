<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Cache;
use Auth;
class LogLastUserActivity
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
        if(Auth::check()) {
            $expiresAt = Carbon::now()->addMinutes(5);
            Cache::put('user-is-online-' . access()->user()->id, true, $expiresAt);
        }
        return $next($request);
    }
}
