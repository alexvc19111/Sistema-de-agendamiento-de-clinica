<?php
namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\AuthRepositoryInterface;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }


    //Logica del login donde se valida el usuario y contraseña
    //Si el usuario es valido se genera un token y se retorna la informacion del usuario
    public function login(string $username, string $password): array|null
    {
        $usuario = $this->authRepository->findByUsername($username);

        if (!$usuario || !Hash::check($password, $usuario->password)) {
            return null;
        }

        $token = $usuario->createToken('token_personal')->plainTextToken;

        return [
            'id' => $usuario->id,
            'token' => $token,
            'username' => $usuario->username,
            'persona' => $usuario->persona,
            'roles' => $usuario->roles->pluck('nombre_rol')->toArray(),
        ];
    }

    public function logout($user): void
    {
        $user->tokens()->delete();
    }

    public function getUserInfo($user): array
    {
        $user->load('persona', 'roles');

        return [
            'id' => $user->id,
            'username' => $user->username,
            'persona' => $user->persona,
            'roles' => $user->roles->pluck('nombre_rol')->toArray(),
        ];
    }
}
