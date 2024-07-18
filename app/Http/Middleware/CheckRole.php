<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
{
    if (in_array($request->user()->roles, $roles)) {
        Log::info('User role verified: ' . $request->user()->roles);
        return $next($request);
    }
    Log::warning('User role not authorized: ' . $request->user()->roles);
    return redirect()->route('login');
}

}
