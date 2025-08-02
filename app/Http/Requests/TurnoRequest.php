<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TurnoRequest extends FormRequest
{
    public function authorize()
    {
        return true; // o lógica según roles
    }

    public function rules()
    {
        return [
            'medico_id' => 'required|exists:medicos,id',
            'paciente_id' => 'nullable|exists:pacientes,id',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'estado_turno_id' => 'required|exists:estado_turnos,id',
            'agenda_medica_id' => 'nullable|exists:agenda_medicas,id',
            'motivo_consulta' => 'nullable|string|max:255',
        ];
    }
}
