<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;

class UserController extends Controller
{

    public function index()
    {
        return view('users.index', [
            'users' => User::get(),
        ]);
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'rols' => Rol::get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
                'name' => ['required', 'string', 'max:60'],
                'email' => ['required', 'string', 'email', 'max:60', Rule::unique(User::class)->ignore($user->id)],
                'rol_id' => ['required', 'exists:rols,id'],
            ]);

        $user->name = $request->name;
        $user->email = strtolower($request->email);
        $user->rol_id = $request->rol_id;

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->intended(URL::signedRoute('users.index'))
            ->with('status', __('User updated successfully!'));
    }


    public function editpassword(User $user)
    {
        return view('users.editpassword', [
            'user' => $user,
        ]);
    }

    public function updatepassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->password = Hash::make($request->password);

        $user->save();

        return redirect()->intended(URL::signedRoute('users.index'))
            ->with('status', __('Password updated successfully!'));
    }

    public function delete(User $user)
    {
        return view('users.delete', [
            'user' => $user,
        ]);
    }

    public function destroy(Request $request, User $user)
    {
        $request->validateWithBag('userDeletion', [
            'name' => ['required', 'string', 'max:60'],
        ]);

        if ($request->input('name') !== $user->name) {
            return redirect()->back()->withErrors([
                'name' => __('The provided name does not match our records.'),
            ]);
        }

        $user->delete();

        return redirect()->intended(URL::signedRoute('users.index'))
            ->with('status', __('User deleted successfully!'));
    }
}
