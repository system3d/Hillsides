<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Cache;
use Auth;
use App\Online as online;
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
        $online = online::where('user_id',access()->user()->id)->first();
        if(isset($online->id)){
            $online->update(['data' => date('Y-m-d H:i:s')]);
        }else{
            $online = online::create(['data' => date('Y-m-d H:i:s'),'user_id' => access()->user()->id, 'locatario_id' => access()->user()->locatario_id]);
        }
        return $next($request);
    }
}
