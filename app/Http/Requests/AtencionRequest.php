<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtencionRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ajusta según autorización
    }

    public function rules()
    {
        return [
            'turno_id' => 'required|exists:turnos,id',
            'presion' => 'nullable|string|max:255',
            'temperatura' => 'nullable|numeric',
            'frecuencia_cardiaca' => 'nullable|integer',
            'frecuencia_respiratoria' => 'nullable|integer',
            'peso' => 'nullable|numeric',
            'talla' => 'nullable|numeric',
            'diagnostico' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ];
    }
}
