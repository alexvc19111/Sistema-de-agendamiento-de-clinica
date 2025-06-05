<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\rol;

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
            'nombre_rol' => 'required|string|max:100|unique:rols'
        ]);

        return rol::create($request->all());

        return response()->json([
            'mensaje' => 'Rol creado correctamente.',
            'rol' => $rol
        ], 201);
    }

    // Método para mostrar un rol por ID
    public function show($id)
    {
        $rol = rol::find($id);
        if (!$rol) {
            return response()->json(['mensaje' => 'Rol no encontrado.'], 404);
        }

        return $rol;
    }

    // Método para actualizar un rol
    public function update(Request $request, $id)
    {
        $rol = rol::find($id);
        if (!$rol) {
            return response()->json(['mensaje' => 'Rol no encontrado.'], 404);
        }

        // Validación de los datos de entrada
        $request->validate([
            'nombre_rol' => 'sometimes|required|string|max:100|unique:rols,nombre_rol,' . $id
        ]);

        $rol->update($request->all());
        return response()->json([
            'mensaje' => 'Rol actualizado correctamente.',
            'rol' => $rol
        ]);
    }

    // Método para eliminar un rol
    public function destroy($id)
    {
        $rol = rol::find($id);
        if (!$rol) {
            return response()->json(['mensaje' => 'Rol no encontrado.'], 404);
        }
        $rol->delete();

        return response()->json(['mensaje' => 'Rol eliminado correctamente.'], 200);
    }
}
