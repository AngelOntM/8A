<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Closure;
use Illuminate\Support\Facades\Validator;
use App\Rules\Recaptcha;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:60'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:60', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'g-recaptcha-response' => ['required', new Recaptcha()]
        ]);

        //$isAdmin = User::where('admin', 1)->count() === 0;
        $isAdmin = 3;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $isAdmin,
        ]);

        event(new Registered($user));

        //Auth::login($user);

        return redirect(URL::signedRoute(RouteServiceProvider::HOME));
    }
}
