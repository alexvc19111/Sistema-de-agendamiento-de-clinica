<?php
namespace App\Repositories\Interfaces;

use App\Models\usuario;

interface AuthRepositoryInterface
{
    public function findByUsername(string $username): ?usuario;
}
