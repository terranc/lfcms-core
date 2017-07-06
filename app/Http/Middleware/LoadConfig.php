<?php

namespace App\Http\Middleware;

use App\Models\Config\Config;
use Closure;

class LoadConfig
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
        Config::loadConfigs();
        return $next($request);
    }

}
