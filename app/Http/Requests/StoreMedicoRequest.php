<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicoRequest extends FormRequest
{
    public function authorize()
    {
        return true; // asegúrate de manejar bien los roles si es necesario
    }

    public function rules()
    {
        return [
            'usuario_id' => 'required|exists:usuarios,id',
            'especialidad_id' => 'required|exists:especialidads,id',
        ];
    }
}
