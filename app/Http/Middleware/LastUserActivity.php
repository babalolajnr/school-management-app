<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Record Last User Activity
 */
class LastUserActivity
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
        if (auth('web')->check() || auth('teacher')->check()) {
            $expiresAt = Carbon::now()->addMinutes(2);
            Cache::put('user-is-online-' . $request->user()->id, true, $expiresAt);

            $request->user()->update(['last_seen' => Carbon::now()->format('Y-m-d H:i:s')]);
        }

        return $next($request);
    }
}
