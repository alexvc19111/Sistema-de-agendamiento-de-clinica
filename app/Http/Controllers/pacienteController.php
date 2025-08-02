<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\paciente;

class pacienteController extends Controller
{
    //
    public function index()
    {
        return paciente::with('persona')->get();
    }

    // Guardar nuevo paciente
    public function store(Request $request)
    {
        $request->validate([
            'persona_id' => 'required|exists:personas,id|unique:pacientes,persona_id',
        ]);

        return paciente::create($request->all());
    }

    // Mostrar paciente específico
    public function show($id)
    {
        return paciente::with('persona')->findOrFail($id);
    }

    // Actualizar paciente
    public function update(Request $request, $id)
    {
        $paciente = paciente::findOrFail($id);

        $request->validate([
            'persona_id' => 'sometimes|required|exists:personas,id|unique:pacientes,persona_id,' . $paciente->id,

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

    public function buscar(Request $request)
{
    $termino = $request->input('q');

    $pacientes = paciente::whereHas('persona', function ($query) use ($termino) {
        $query->where('nombres', 'ILIKE', "%$termino%")
              ->orWhere('apellidos', 'ILIKE', "%$termino%")
              ->orWhere('dni', 'ILIKE', "%$termino%")
              ->orWhere('fecha_nacimiento', 'ILIKE', "%$termino%")
              ->orWhere('direccion', 'ILIKE', "%$termino%")
              ->orWhere('telefono', 'ILIKE', "%$termino%");
    })->with('persona')->get();

    return response()->json($pacientes);
}
}
