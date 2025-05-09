<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class derivacionController extends Controller
{
    //
    // Método para obtener todos los registros de la tabla
    public function index()
    {
        return derivacion::all();
    }

    // Método para almacenar un nuevo registro en la tabla
    public function store(Request $request)
    {
        $request->validate([
            'turno_id' => 'required|exists:turnos,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id' => 'required|exists:medicos,id',
            'estado_turno_id' => 'required|exists:estado_turnos,id',
            'motivo' => 'nullable|string',
        ]);

        return derivacion::create($request->all());
    }

    // Método para obtener un solo registro por su ID
    public function show($id)
    {
        return derivacion::findOrFail($id);
    }

    // Método para actualizar un registro existente
    public function update(Request $request, $id)
    {
        $derivacion = derivacion::findOrFail($id);

        $request->validate([
            'turno_id' => 'required|exists:turnos,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id' => 'required|exists:medicos,id',
            'estado_turno_id' => 'required|exists:estado_turnos,id',
            'motivo' => 'nullable|string',
        ]);

        $derivacion->update($request->all());
        return $derivacion;
    }

    // Método para eliminar un registro por su ID
    public function destroy($id)
    {
        $derivacion = derivacion::findOrFail($id);
        $derivacion->delete();

        return response()->json(['message' => 'Derivación eliminada correctamente']);
    }
}
