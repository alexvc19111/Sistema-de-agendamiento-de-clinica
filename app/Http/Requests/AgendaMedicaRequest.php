<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;



class AgendaMedicaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $medico_id = $this->input('medico_id');
        $dia_semana = $this->input('dia_semana');
        $agendaId = $this->route('id'); // para update, puede venir en ruta

        return [
            'medico_id' => 'required|exists:medicos,id',
            'dia_semana' => [
                'required',
                'string',
                Rule::unique('agenda_medica')->where(function ($query) use ($medico_id) {
                    return $query->where('medico_id', $medico_id);
                })->ignore($agendaId),
            ],
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'almuerzo_inicio' => 'required|date_format:H:i',
            'almuerzo_fin' => 'required|date_format:H:i|after:almuerzo_inicio',
        ];
    }
    

}
