<?php

namespace App\Http\Middleware;

use Closure;

class IsInstalled
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
        $envPath = base_path('.env');
        return !file_exists($envPath) && !request()->is('install') && !request()->is('install/*') ? redirect('install') : $next($request);
    }
}
