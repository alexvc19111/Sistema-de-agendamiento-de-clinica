<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class personaController extends Controller
{
    // Método para obtener todas las personas
    public function index(){
        return persona::all();
    }
    
    //Metodo para almacenar registros en la tabla
    public function store(Request $request){
        $request->validate([
            'nombres' => 'required|string|max:50',
            'apellidos' => 'required|string|max:50',
            'dni' => 'required|string|max:10|unique:personas',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:15'
        ]);
        return persona::create($request->all());
    }

    //Metodo para mostrar persona por ID
    public function show($id)
    {
        $persona = Persona::findOrFail($id);
        return $persona;
    }


    //Metodo para actualizar una persona
    public function update(Request $request, $id)
    {
        $persona = Persona::findOrFail($id);

        $request->validate([
            'nombres' => 'sometimes|required|string|max:50',
            'apellidos' => 'sometimes|required|string|max:50',
            'dni' => 'sometimes|required|string|max:10|unique:personas,dni,' . $id,
            'fecha_nacimiento' => 'sometimes|required|date',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:15'
        ]);

        $persona->update($request->all());
        return $persona;
    }

    //Metodo para eliminar una persona
    public function destroy($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->delete();

        return response()->json(['mensaje' => 'Persona eliminada correctamente.']);
    }

}
