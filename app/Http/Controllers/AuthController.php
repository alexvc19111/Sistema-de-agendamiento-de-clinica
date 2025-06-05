<?php

namespace App\Http\Controllers;

use App\Models\usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $usuario = usuario::where('username', $request->username)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json(['mensaje' => 'Credenciales inválidas'], 401);
        }

        $token = $usuario->createToken('token_personal')->plainTextToken;

        return response()->json([
            'id' => $usuario->id,
            'token' => $token,
            'username' => $usuario->username,
            'persona' => $usuario->persona,
            'roles' => $usuario->roles->pluck('nombre_rol')->toArray(), // Devuelve nombres de los roles
        ]);
    }
    public function logout(Request $request)
    {
        // Revocar el token actual que se usa en esta petición
        $request->user()->tokens()->delete();


        return response()->json(['mensaje' => 'Sesión cerrada correctamente.']);
    }

     public function me(Request $request)
    {
        $user = $request->user()->load('persona', 'roles');

        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'persona' => $user->persona,
            'roles' => $user->roles->pluck('nombre_rol')->toArray(), // Devuelve nombres de los roles
        ]);
    }
}

