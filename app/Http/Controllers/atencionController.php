<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class atencionController extends Controller
{
    //
    // Método para obtener todas las atenciones
    public function index() {
        return atencion::all();
    }

    // Método para guardar una nueva atención
    public function store(Request $request) {
        $request->validate([
            'turno_id' => 'required|exists:turnos,id',
            'diagnostico' => 'nullable|string',
            'tratamiento' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        return atencion::create($request->all());
    }

    // Método para obtener una atención por ID
    public function show($id) {
        return atencion::findOrFail($id);
    }

    // Método para actualizar una atención
    public function update(Request $request, $id) {
        $atencion = atencion::findOrFail($id);

        $request->validate([
            'turno_id' => 'required|exists:turnos,id',
            'diagnostico' => 'nullable|string',
            'tratamiento' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $atencion->update($request->all());

        return $atencion;
    }

    // Método para eliminar una atención
    public function destroy($id) {
        $atencion = atencion::findOrFail($id);
        $atencion->delete();

        return response()->json(['mensaje' => 'Atención eliminada correctamente']);
    }
}
