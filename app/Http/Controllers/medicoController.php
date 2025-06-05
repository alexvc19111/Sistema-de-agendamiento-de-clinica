<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\medico;

class medicoController extends Controller
{
    //
    // Obtener todos los médicos
    public function index()
    {
        return medico::with(['usuario', 'especialidad'])->get();
    }

    // Guardar nuevo médico
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id|unique:medicos,usuario_id',
            'especialidad_id' => 'required|exists:especialidads,id',
        ]);

        return medico::create($request->all());
    }

    // Mostrar médico específico
    public function show($id)
    {
        return medico::with(['usuario', 'especialidad'])->findOrFail($id);
    }

    // Actualizar médico
    public function update(Request $request, $id)
    {
        $medico = medico::findOrFail($id);

        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id|unique:medicos,usuario_id,' . $medico->id,
            'especialidad_id' => 'required|exists:especialidads,id',
        ]);

        $medico->update($request->all());
        return $medico;
    }

    // Eliminar médico
    public function destroy($id)
    {
        $medico = medico::findOrFail($id);
        $medico->delete();

        return response()->json(['message' => 'Médico eliminado correctamente']);
    }
}
