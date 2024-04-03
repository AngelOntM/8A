<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            return response(["token"=>$token], Response::HTTP_OK);
        } else {
            return response(["message"=> "Credenciales inválidas"],Response::HTTP_UNAUTHORIZED);
        }        
    }

    public function userProfile(Request $request) {
        $user = auth()->user();

        if ($user) {
            return response()->json([
                "message" => "userProfile OK",
                "userData" => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'rol_id' => $user->rol_id,
                    'role' => $user->rol->role,
                ]
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                "message" => "No user authenticated",
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function logout(Request $request) {
        // Obtén el usuario actualmente autenticado
        $user = $request->user();

        // Revoque el token de autenticación del usuario
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return response(["message"=>"Cierre de sesión OK"], Response::HTTP_OK);
    }

    public function allUsers() {
       $users = User::all();
       return response()->json([
        "users" => $users
       ]);
    }
}
