<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Rules\Recaptcha;
use Illuminate\Support\Facades\URL;
use App\Models\User;

use Closure;
use Illuminate\Support\Facades\Validator;

use App\Notifications\SendTwoFactorCode;
use App\Notifications\SendThreeFactorCode;

class AuthenticatedSessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('vpn.access')->only('adminLogin');
    }
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function adminLogin(Request $request)
    {    
        if ($request->user()->rol_id == 1) { 

            $request->user()->generateThreeFactorCode();
            $request->user()->notify(new SendThreeFactorCode());

        }    
        
        return redirect()->intended(URL::signedRoute(RouteServiceProvider::HOME));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $allowedIpAddresses = ['127.0.0.2'];
        if (in_array($request->ip(), $allowedIpAddresses)) {
            $request->validate([
            'g-recaptcha-response' => ['required', new Recaptcha()]
            ]);
        }
        
        
        $request->authenticate();

        $request->session()->regenerate();

        if ($request->user()->rol_id == 1) { 
            return redirect('/admin-login');
        }

        $request->user()->generateTwoFactorCode();

        $request->user()->notify(new SendTwoFactorCode());

        return redirect()->intended(URL::signedRoute(RouteServiceProvider::HOME));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->user()->resetThreeFactorCode();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();



        return redirect('/');
    }
}
