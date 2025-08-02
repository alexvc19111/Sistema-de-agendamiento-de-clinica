<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Asegúrate de que pueda pasar la autorización
    }

    public function rules(): array
    {
        return [
            'usuario_id' => 'required|exists:usuarios,id|unique:medicos,usuario_id',
            'especialidad_id' => 'required|exists:especialidads,id|max:100',
        ];
    }
}
