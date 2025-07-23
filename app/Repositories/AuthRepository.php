<?php
namespace App\Repositories;

use App\Models\usuario;

use App\Repositories\Interfaces\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{

     // Realiza una consulta en la tabla "usuarios" donde el campo "username" coincida con el parámetro recibido.
    // Devuelve el primer resultado encontrado o null si no existe ningún usuario con ese username.
    public function findByUsername(string $username): ?usuario
    {
        return usuario::where('username', $username)->first();
    }
}
