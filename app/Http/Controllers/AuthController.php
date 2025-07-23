<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $datos = $this->authService->login($credentials['username'], $credentials['password']);

        if (!$datos) {
            return response()->json(['mensaje' => 'Credenciales inválidas'], 401);
        }

        return response()->json($datos);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return response()->json(['mensaje' => 'Sesión cerrada correctamente.']);
    }

    public function me(Request $request)
    {
        $data = $this->authService->getUserInfo($request->user());

        return response()->json($data);
    }
}
