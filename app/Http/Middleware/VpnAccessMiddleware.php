<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class VpnAccessMiddleware
{
    public function handle($request, Closure $next)
    {
        $allowedIpAddresses = ['127.0.0.1', '10.0.0.2', '10.0.0.3', '10.0.1.2', '10.0.1.1'];
        if ($request->user() && $request->user()->rol_id == 1) {
            if (in_array($request->ip(), $allowedIpAddresses)) {
                return $next($request);
            }
            $request->user()->resetThreeFactorCode();
            auth()->logout();
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }elseif ($request->user() && $request->user()->rol_id == 3) {
            if (in_array($request->ip(), $allowedIpAddresses)) {
                $request->user()->resetThreeFactorCode();
                auth()->logout();
                throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
            }
            return $next($request);
        }
        return $next($request);
    }
}
