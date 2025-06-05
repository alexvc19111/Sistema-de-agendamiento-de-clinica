<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuario;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\HasApiTokens;



class usuarioController extends Controller
{
    use HasApiTokens;

    

    // Método para crear un nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:usuarios',
            'password' => 'required|string|min:6',
            'persona_id' => 'required|exists:personas,id'
        ]);

        // Encriptar contraseña antes de guardar
        $data = $request->only(['username', 'password', 'persona_id']);
        $data['password'] = bcrypt($data['password']);

        $usuario = usuario::create($data);
        return response()->json([
    'mensaje' => 'Usuario creado correctamente.',
    'usuario' => $usuario->only('id', 'username', 'persona_id') // no envíes password ni datos sensibles
], 201);
    }

    // Método para mostrar un usuario por ID
    public function show($id)
    {
        $usuario = usuario::findOrFail($id);

        if (!$usuario) {
            return response()->json(['mensaje' => 'Usuario no encontrado.'], 404);
        }

        return $usuario;
    }

    // Método para actualizar un usuario
    public function update(Request $request, $id)
    {
        $usuario = usuario::find($id);

        if (!$usuario) {
            return response()->json(['mensaje' => 'Usuario no encontrado.'], 404);
        }

        $request->validate([
            'username' => 'sometimes|required|string|max:50|unique:usuarios,username,' . $id,
            'password' => 'sometimes|required|string|min:6',
            'persona_id' => 'sometimes|required|exists:personas,id'
        ]);

        $data = $request->all();
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $usuario->update($data);
        return response()->json([
            'mensaje' => 'Usuario actualizado correctamente.',
            'usuario' => $usuario
        ]);
        }

    // Método para eliminar un usuario
    public function destroy($id)    
    {
        $usuario = usuario::find($id);

        if (!$usuario) {
            return response()->json(['mensaje' => 'Usuario no encontrado.'], 404);
        }

        $usuario->delete();

        return response()->json(['mensaje' => 'Usuario eliminado correctamente.'],200);
    }
    public function index()
{
    // Cargar usuario con persona y roles (relaciones)
    $usuarios = usuario::with(['persona', 'roles'])->get();

    // Mapear para devolver solo los campos que quieres
    $resultado = $usuarios->map(function ($usuario) {
        return [
            'nombres' => $usuario->persona->nombres ?? null,
            'apellidos' => $usuario->persona->apellidos ?? null,
            'dni' => $usuario->persona->dni ?? null,
            'fecha_nacimiento' => $usuario->persona->fecha_nacimiento ?? null,
            'direccion' => $usuario->persona->direccion ?? null,
            'telefono' => $usuario->persona->telefono ?? null,
            'username' => $usuario->username,
            'roles' => $usuario->roles->pluck('nombre_rol')->toArray()  // array de roles
        ];
    });

    return response()->json($resultado);
}
}
