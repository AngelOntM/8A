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


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        try {
                        
            Log::channel('custom')->info('Entro a su perfil', ['Usuario' => $request->user()->id]);
            
            return view('profile.edit', ['user' => $request->user()]);

        } catch (\Exception $e) {

            Log::channel('custom')->error('No pudo entrar a su perfil', ['Usuario' => $request->user()->id]);
            
        }
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            $request->user()->fill($request->validated());

            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }

            $request->user()->save();
            Log::channel('custom')->info('Modifico su perfil', ['Usuario' => $request->user()->id, 'data' => $request->except('password')]);

            return back()->with('status', 'profile-updated');
        } catch (\Throwable $e) {

            Log::channel('custom')->error('No se pudo modifico su perfil', ['Usuario' => $request->user()->id]);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        try {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);
    
            $user = $request->user();
    
            Auth::logout();
    
            $user->delete();
    
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            Log::channel('custom')->info('Elimino su perfil', ['Usuario' => $request->user()->id]);
    
            return Redirect::to('/');
        } catch (\Throwable $e) {

            Log::channel('custom')->error('No se pudo eliminar el usuario', ['Usuario' => $request->user()->id]);
            
        }
    }
}
