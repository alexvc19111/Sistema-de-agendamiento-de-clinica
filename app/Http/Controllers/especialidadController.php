<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\especialidad;

class especialidadController extends Controller
{
    // Método para obtener todos los registros de especialidad
    public function index()
    {
        return especialidad::all();
    }

    // Método para almacenar un nuevo registro de especialidad
    public function store(Request $request)
    {
        $request->validate([
            'nombre_especialidad' => 'required|string|max:50|unique:especialidads',
        ]);

        return especialidad::create($request->all());
    }

    // Método para obtener un registro de especialidad por ID
    public function show($id)
    {
        return especialidad::findOrFail($id);
    }

    // Método para actualizar un registro de especialidad
    public function update(Request $request, $id)
    {
        $especialidad = especialidad::findOrFail($id);

        $request->validate([
            'nombre_especialidad' => 'sometimes|required|string|max:50|unique:especialidads',
        ]);

        $especialidad->update($request->all());
        return $especialidad;
    }

    // Método para eliminar un registro de especialidad
    public function destroy($id)
    {
        $especialidad = especialidad::findOrFail($id);
        $especialidad->delete();

        return response()->json(['message' => 'Especialidad eliminada correctamente']);
    }
}
