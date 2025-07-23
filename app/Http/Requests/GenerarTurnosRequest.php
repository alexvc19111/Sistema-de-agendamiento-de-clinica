<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerarTurnosRequest extends FormRequest
{
    public function authorize()
    {
        return true; // puedes validar roles aquí también
    }

    public function rules()
    {
        return [
            'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ];
    }
}
