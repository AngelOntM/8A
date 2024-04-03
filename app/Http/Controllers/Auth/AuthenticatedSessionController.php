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
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function adminLogin(Request $request)
    {
        $request->user()->generateThreeFactorCode();

        $request->user()->notify(new SendThreeFactorCode());
        
        return redirect()->intended(URL::signedRoute(RouteServiceProvider::HOME));

    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->validate([
            'g-recaptcha-response' => ['required', new Recaptcha()]
        ]);
        
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user(); 

        if ($user->rol_id == 1) { 
            return $this->adminLogin($request);
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
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();



        return redirect('/');
    }
}
