<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class turnoController extends Controller
{
    //
    // Método para obtener todos los registros de la tabla
    public function index()
    {
        return turno::all();
    }

    // Método para almacenar un nuevo registro en la tabla
    public function store(Request $request)
    {
        $request->validate([
            'medico_id' => 'required|exists:medicos,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'estado_turno_id' => 'required|exists:estado_turnos,id',
        ]);

        return turno::create($request->all());
    }

    // Método para obtener un solo registro por su ID
    public function show($id)
    {
        return turno::findOrFail($id);
    }

    // Método para actualizar un registro existente
    public function update(Request $request, $id)
    {
        $turno = turno::findOrFail($id);

        $request->validate([
            'medico_id' => 'required|exists:medicos,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'estado_turno_id' => 'required|exists:estado_turnos,id',
        ]);

        $turno->update($request->all());
        return $turno;
    }

    // Método para eliminar un registro por su ID
    public function destroy($id)
    {
        $turno = turno::findOrFail($id);
        $turno->delete();

        return response()->json(['message' => 'Turno eliminado correctamente']);
    }
}
