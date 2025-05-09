<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class estado_turnoController extends Controller
{
    //
    // Método para obtener todos los registros de la tabla
    public function index()
    {
        return estado_turno::all();
    }

    // Método para almacenar un nuevo registro en la tabla
    public function store(Request $request)
    {
        $request->validate([
            'nombre_estado' => 'nullable|string|max:30',
        ]);

        return estado_turno::create($request->all());
    }

    // Método para obtener un solo registro por su ID
    public function show($id)
    {
        return estado_turno::findOrFail($id);
    }

    // Método para actualizar un registro existente
    public function update(Request $request, $id)
    {
        $estado = estado_turno::findOrFail($id);

        $request->validate([
            'nombre_estado' => 'nullable|string|max:30',
        ]);

        $estado->update($request->all());
        return $estado;
    }

    // Método para eliminar un registro por su ID
    public function destroy($id)
    {
        $estado = estado_turno::findOrFail($id);
        $estado->delete();

        return response()->json(['message' => 'Estado eliminado correctamente']);
    }
}
