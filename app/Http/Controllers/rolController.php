<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class rolController extends Controller
{
    //
    // Método para obtener todos los roles
    public function index()
    {
        return rol::all();
    }

    // Método para crear un nuevo rol
    public function store(Request $request)
    {
        $request->validate([
            'nombre_rol' => 'required|string|max:100|unique:roles'
        ]);

        return rol::create($request->all());
    }

    // Método para mostrar un rol por ID
    public function show($id)
    {
        $rol = rol::findOrFail($id);
        return $rol;
    }

    // Método para actualizar un rol
    public function update(Request $request, $id)
    {
        $rol = rol::findOrFail($id);

        $request->validate([
            'nombre_rol' => 'sometimes|required|string|max:100|unique:roles,nombre_rol,' . $id
        ]);

        $rol->update($request->all());
        return $rol;
    }

    // Método para eliminar un rol
    public function destroy($id)
    {
        $rol = rol::findOrFail($id);
        $rol->delete();

        return response()->json(['mensaje' => 'Rol eliminado correctamente.']);
    }
}
