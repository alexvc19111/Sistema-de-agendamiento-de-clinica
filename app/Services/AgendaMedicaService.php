<?php
namespace App\Services;

use App\Repositories\Interfaces\AgendaMedicaRepositoryInterface;

class AgendaMedicaService
{
    protected $agendaRepository;

    public function __construct(AgendaMedicaRepositoryInterface $agendaRepository)
    {
        $this->agendaRepository = $agendaRepository;
    }

    public function crearAgenda(array $data)
    {
        return $this->agendaRepository->crearAgenda($data);
    }

    public function obtenerAgendaPorMedico($medicoId)
    {
        return $this->agendaRepository->obtenerPorMedico($medicoId);
    }

    public function actualizarAgenda(int $id, array $data)
    {
        $agenda = agenda_medica::findOrFail($id);

        // Opción para validar en código adicional si quieres (pero ya está en Request)
        // Verificar que no haya otro registro con el mismo dia_semana para el medico, excepto este registro actual
        $existe = agenda_medica::where('medico_id', $data['medico_id'])
            ->where('dia_semana', $data['dia_semana'])
            ->where('id', '<>', $id)
            ->exists();

        if ($existe) {
            throw new \Exception('El médico ya tiene una agenda para ese día de la semana.');
        }

        $agenda->update($data);

        return $agenda;
    }

    
}

