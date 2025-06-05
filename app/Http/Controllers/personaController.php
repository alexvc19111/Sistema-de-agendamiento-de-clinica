<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\persona;

class personaController extends Controller
{
    // Método para obtener todas las personas
    public function index(){
        return persona::all();
    }
    
    //Metodo para almacenar registros en la tabla
    public function store(Request $request){
        // Validación de los datos de entrada
        $request->validate([
            'nombres' => 'required|string|max:50',
            'apellidos' => 'required|string|max:50',
            'dni' => 'required|string|max:10|unique:personas',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:15'
        ]);
        $personas=persona::create($request->all());
        return response()->json([
            'mensaje' => 'Persona creada correctamente.',
            'persona' => $personas
        ], 201);
    }

    //Metodo para mostrar persona por ID
    public function show($id)
    {
        $persona = Persona::find($id);

        if (!$persona) {
            return response()->json(['mensaje' => 'Persona no encontrada.'], 420);
        }
        return $persona;
    }


    //Metodo para actualizar una persona
    public function update(Request $request, $id)
    {
        $persona = persona::findO($id);


        if (!$persona) {
            return response()->json(['mensaje' => 'Persona no encontrada.'], 404);
        }

        // Validación de los datos de entrada
        $request->validate([
            'nombres' => 'sometimes|required|string|max:50',
            'apellidos' => 'sometimes|required|string|max:50',
            'dni' => 'sometimes|required|string|max:10|unique:personas,dni,' . $id,
            'fecha_nacimiento' => 'sometimes|required|date',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:15'
        ]);

        $persona->update($request->all());
        return response()->json([
            'mensaje' => 'Persona actualizada correctamente.',
            'persona' => $persona
        ]);
    }

    //Metodo para eliminar una persona
    public function destroy($id)
    {
        $persona = Persona::find($id);

        if (!$persona) {
            return response()->json(['mensaje' => 'Persona no encontrada.'], 404);
        }

        $persona->delete();

        return response()->json(['mensaje' => 'Persona eliminada correctamente.'], 200);
    }

}
