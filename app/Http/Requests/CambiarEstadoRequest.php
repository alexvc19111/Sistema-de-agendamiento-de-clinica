<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CambiarEstadoRequest extends FormRequest
{
    public function authorize()
    {
        return true; // O pon la lógica para autorizar si quieres
    }

    public function rules()
    {
        return [
            'estado_turno_id' => 'required|exists:estado_turnos,id',
        ];
    }
}
