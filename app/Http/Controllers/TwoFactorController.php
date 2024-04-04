<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;

use App\Notifications\SendTwoFactorCode;
use App\Notifications\SendThreeFactorCode;

use Illuminate\Validation\ValidationException;


class TwoFactorController extends Controller
{
    public function index(): View
    {
        return view('auth.twoFactor');
    }

    public function store(Request $request): ValidationException|RedirectResponse
    {
        $request->validate([
            'codigo' => ['integer', 'required', 'digits:6'],
        ]);
        $user = auth()->user();

        if ((int)$request->input('codigo') !== (int)$user->two_factor_code) {
            throw ValidationException::withMessages([
                'codigo' => __('Codigo incorrecto'),
            ]);
        }
        $user->resetTwoFactorCode();
        return redirect()->to(URL::signedRoute(RouteServiceProvider::HOME));
    }

    public function resend(): RedirectResponse
    {
        $user = auth()->user();
        if ($user->rol_id == 1) { 
            $user->generateThreeFactorCode();
            $user->notify(new SendThreeFactorCode());
            return redirect()->back()->withStatus(__('El codigo ha sido reenviado'));
        }
        $user->generateTwoFactorCode();
        $user->notify(new SendTwoFactorCode());
        return redirect()->back()->withStatus(__('El codigo ha sido reenviado'));
    }
}
