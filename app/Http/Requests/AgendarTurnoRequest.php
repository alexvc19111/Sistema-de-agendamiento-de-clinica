<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgendarTurnoRequest extends FormRequest
{
    public function authorize()
    {
        return true; // O pon la lógica para autorizar si quieres
    }

    public function rules()
    {
        return [
            'paciente_id' => 'required|exists:pacientes,id',
            'motivo_consulta' => 'required|string|max:255',
            'estado_turno_id' => 'required|exists:estado_turnos,id',
        ];
    }
}
