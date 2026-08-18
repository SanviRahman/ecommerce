<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class LteContextSwitcher
{
    public function handle($request, Closure $next, string $guard)
    {
        Auth::shouldUse($guard);

        $configMap = [
            'admin' => 'adminlte_admin',
        ];

        $configFileName = $configMap[$guard] ?? null;

        if ($configFileName && Config::has($configFileName)) {
            Config::set('adminlte', config($configFileName));
        }

        return $next($request);
    }
}
