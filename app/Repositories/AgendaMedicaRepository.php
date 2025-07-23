<?php
namespace App\Repositories;

use App\Models\agenda_medica;
use App\Repositories\Interfaces\AgendaMedicaRepositoryInterface;

class AgendaMedicaRepository implements AgendaMedicaRepositoryInterface
{
    public function crearAgenda(array $data)
    {
        return agenda_medica::create($data);
    }

    public function obtenerPorMedico($medicoId)
    {
        return agenda_medica::where('medico_id', $medicoId)->get();
    }

    public function getAgendaPorMedicoYDia($medico_id, $dia_semana)
    {
        return agenda_medica::where('medico_id', $medico_id)
            ->where('dia_semana', $dia_semana)
            ->first();
    }
}
