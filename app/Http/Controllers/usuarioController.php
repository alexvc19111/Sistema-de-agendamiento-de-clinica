<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class usuarioController extends Controller
{
    //Metodo para obtener todas los usuarios
    public function index()
    {
        return usuario::all();
    }

    // Método para crear un nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:usuarios',
            'password' => 'required|string|min:6',
            'persona_id' => 'required|exists:personas,id_persona'
        ]);

        // Encriptar contraseña antes de guardar
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        return usuario::create($data);
    }

    // Método para mostrar un usuario por ID
    public function show($id)
    {
        $usuario = usuario::findOrFail($id);
        return $usuario;
    }

    // Método para actualizar un usuario
    public function update(Request $request, $id)
    {
        $usuario = usuario::findOrFail($id);

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
        return $usuario;
    }

    // Método para eliminar un usuario
    public function destroy($id)
    {
        $usuario = usuario::findOrFail($id);
        $usuario->delete();

        return response()->json(['mensaje' => 'Usuario eliminado correctamente.']);
    }
}
