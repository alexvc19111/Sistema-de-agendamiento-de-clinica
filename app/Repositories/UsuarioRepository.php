<?php
namespace App\Repositories;

use App\Models\usuario;

use App\Repositories\Interfaces\UsuarioRepositoryInterface;

class UsuarioRepository implements UsuarioRepositoryInterface
{
    //Se crea un store en la base de datos
    public function create(array $data)
    {
        return usuario::create($data);
    }
    // Se busca un usuario por su ID
    public function find($id) {
        return usuario::find($id);
    }
    // Se actualiza un usuario por su ID
    public function update($id, array $data) {
        $usuario = usuario::find($id);
        if ($usuario) {
            $usuario->update($data);
        }
        return $usuario;
    }

    // Se elimina un usuario por su ID
    public function delete($id) {
        $usuario = usuario::find($id);
        if ($usuario) {
            $usuario->delete();
        }
        return $usuario;
    }

    // Se obtienen todos los usuarios con sus relaciones
    public function getAllWithRelations() {
        return usuario::with(['persona', 'roles'])->get();
    }
}