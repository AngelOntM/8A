<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThreeFactorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if (auth()->check() && $user->three_factor_code) {
            if ($user->three_factor_expires_at < now()) {
                $user->resetThreeFactorCode();
                auth()->logout();
                return redirect()->route('login')
                    ->withStatus('Tu codigo de verificacion ha expirado, por favor ingresa de nuevo.');
            }
            if (!$request->is('verify*')) {
                return redirect()->route('verify.index');
            }
        }
        return $next($request);
    }
}
