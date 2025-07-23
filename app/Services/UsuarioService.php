<?php
namespace App\Services;

use App\Repositories\Interfaces\UsuarioRepositoryInterface;

class UsuarioService
{
    protected $usuarioRepository;

    public function __construct(UsuarioRepositoryInterface $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }


    //Logica para crear usuario, donde se encripta la contraseña y se delaga la creacion al repositorio
    //Se retorna el usuario creado
    public function crearUsuario(array $datos)
    {
        $datos['password'] = bcrypt($datos['password']);
        return $this->usuarioRepository->create($datos);
    }

    public function obtenerUsuario($id)
    {
        return $this->usuarioRepository->find($id);
    }

    public function actualizarUsuario($id, array $datos)
    {
        if (isset($datos['password'])) {
            $datos['password'] = bcrypt($datos['password']);
        }
        return $this->usuarioRepository->update($id, $datos);
    }
    
    public function eliminarUsuario($id)
    {
        return $this->usuarioRepository->delete($id);
    }

    public function listarUsuarios()
    {
        return $this->usuarioRepository->getAllWithRelations();
    }
}