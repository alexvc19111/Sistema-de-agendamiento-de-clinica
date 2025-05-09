<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pacienteController extends Controller
{
    //
    public function index()
    {
        return paciente::with('usuario')->get();
    }

    // Guardar nuevo paciente
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id|unique:pacientes,usuario_id',
        ]);

        return paciente::create($request->all());
    }

    // Mostrar paciente específico
    public function show($id)
    {
        return paciente::with('usuario')->findOrFail($id);
    }

    // Actualizar paciente
    public function update(Request $request, $id)
    {
        $paciente = paciente::findOrFail($id);

        $request->validate([
            'usuario_id' => 'sometimes|required|exists:usuarios,id',
        ]);

        $paciente->update($request->all());
        return $paciente;
    }

    // Eliminar paciente
    public function destroy($id)
    {
        $paciente = paciente::findOrFail($id);
        $paciente->delete();

        return response()->json(['message' => 'Paciente eliminado correctamente']);
    }
}
