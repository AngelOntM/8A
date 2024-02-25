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

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
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

        if ($user->admin) {
            $user->email_verified_at = null;
            $user->save();
        }

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
