<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuario_rol;

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
            'usuario_id' => 'required|exists:usuarios,id|unique:usuario_rols,usuario_id',
            'rol_id' => 'required|exists:rols,id',
        ]);

        $usuarioRol = usuario_rol::create($request->all());

        return response()->json([
            'message' => 'Relación usuario-rol creada correctamente.',
            'usuario_rol' => $usuarioRol
        ], 201);
    }

    // Método para obtener un registro por ID
    public function show($id)
    {
        $usuarioRol = usuario_rol::find($id);

        if (!$usuarioRol) {
            return response()->json(['message' => 'Relación usuario-rol no encontrada.'], 404);
        }

        return $usuarioRol;}

    // Método para actualizar un registro
    public function update(Request $request, $id)
    {
        $usuarioRol = usuario_rol::find($id);

        if (!$usuarioRol) {
            return response()->json(['message' => 'Relación usuario-rol no encontrada.'], 404);
        }

        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id|unique:usuario_rols,usuario_id,' . $usuarioRol->id,
            'rol_id' => 'required|exists:rols,id',
        ]);

        $usuarioRol->update($request->all());
        return response()->json([
            'message' => 'Relación usuario-rol actualizada correctamente.',
            'usuario_rol' => $usuarioRol
        ]);
    }

    // Método para eliminar un registro
    public function destroy($id)
    {
        $usuarioRol = usuario_rol::find($id);

        if (!$usuarioRol) {
            return response()->json(['message' => 'Relación usuario-rol no encontrada.'], 404);
        }

        $usuarioRol->delete();

        return response()->json(['message' => 'Relación usuario-rol eliminada correctamente.'], 200);
    }

}
