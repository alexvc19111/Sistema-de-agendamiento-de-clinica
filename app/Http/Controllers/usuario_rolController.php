<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class usuario_rolController extends Controller
{
       // Método para obtener todos los registros de usuario_rol
    public function index()
    {
        return usuario_rol::all();
    }

    // Método para almacenar un nuevo registro en usuario_rol
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,usuario_id|unique:usuario_rols,usuario_id',
            'rol_id' => 'required|exists:rols,rol_id',
        ]);

        return usuario_rol::create($request->all());
    }

    // Método para obtener un registro por ID
    public function show($id)
    {
        return usuario_rol::findOrFail($id);
    }

    // Método para actualizar un registro
    public function update(Request $request, $id)
    {
        $usuarioRol = usuario_rol::findOrFail($id);

        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id|unique:usuario_rols,usuario_id,' . $usuarioRol->id,
            'rol_id' => 'required|exists:rols,id',
        ]);

        $usuarioRol->update($request->all());
        return $usuarioRol;
    }

    // Método para eliminar un registro
    public function destroy($id)
    {
        $usuarioRol = usuario_rol::findOrFail($id);
        $usuarioRol->delete();

        return response()->json(['message' => 'Relación usuario-rol eliminada correctamente']);
    }

}
