<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuario;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Services\UsuarioService;


class usuarioController extends Controller
{
    use HasApiTokens;

    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }


    // Método para crear un nuevo usuario
    // Este método recibe los datos validados del request y los pasa al servicio para crear el usuario
    public function store(StoreUsuarioRequest $request)
    {

        $datosValidados = $request->validated();

         $usuario = $this->usuarioService->crearUsuario($datosValidados);

        return response()->json([
            'mensaje' => 'Usuario creado correctamente.',
            'usuario' => $usuario->only('id', 'username', 'persona_id')
        ], 201);


    }

    // Método para mostrar un usuario por ID
    public function show($id)
    {
        $usuario = $this->usuarioService->obtenerUsuario($id);

        if (!$usuario) {
            return response()->json(['mensaje' => 'Usuario no encontrado.'], 404);
        }

        return response()->json($usuario);
    }

    // Método para actualizar un usuario
    public function update(UpdateUsuarioRequest $request, $id)
    {
        $usuario = $this->usuarioService->actualizarUsuario($id, $request->validated());

        if (!$usuario) {
            return response()->json(['mensaje' => 'Usuario no encontrado.'], 404);
        }

        return response()->json([
            'mensaje' => 'Usuario actualizado correctamente.',
            'usuario' => $usuario
        ]);
    }


    // Método para eliminar un usuario
    public function destroy($id)
    {
        $usuarioAutenticado = auth()->user();
        
        if ($usuarioAutenticado->username !== 'Administrador') {
        return response()->json(['mensaje' => 'No autorizado para eliminar usuarios.'], 403);
    }

        $usuario = $this->usuarioService->eliminarUsuario($id);

        if (!$usuario) {
            return response()->json(['mensaje' => 'Usuario no encontrado.'], 404);
        }

        return response()->json(['mensaje' => 'Usuario eliminado correctamente.'], 200);
    }

    public function index()
    {
        $usuarios = $this->usuarioService->listarUsuarios();

        $resultado = $usuarios->map(function ($usuario) {
            return [
                'id' => $usuario->id,
                'nombres' => $usuario->persona->nombres ?? null,
                'apellidos' => $usuario->persona->apellidos ?? null,
                'dni' => $usuario->persona->dni ?? null,
                'fecha_nacimiento' => $usuario->persona->fecha_nacimiento ?? null,
                'direccion' => $usuario->persona->direccion ?? null,
                'telefono' => $usuario->persona->telefono ?? null,
                'username' => $usuario->username,
                'roles' => $usuario->roles->pluck('nombre_rol')->toArray()
            ];
        });

        return response()->json($resultado);
    }
}
