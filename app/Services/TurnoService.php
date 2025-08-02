<?php
namespace App\Services;

use App\Repositories\Interfaces\TurnoRepositoryInterface;
use App\Repositories\Interfaces\AgendaMedicaRepositoryInterface;
use App\Models\turno;



class TurnoService
{
    protected $turnoRepository;
    protected $agendaMedicaRepository;

    public function __construct(TurnoRepositoryInterface $turnoRepository, AgendaMedicaRepositoryInterface $agendaMedicaRepository)
    {
        $this->turnoRepository = $turnoRepository;
        $this->agendaMedicaRepository = $agendaMedicaRepository;
    }

    public function getAll()
    {
        return $this->turnoRepository->all();
    }

    public function getById($id)
    {
        return $this->turnoRepository->findById($id);
    }

    public function create(array $data)
    {
        return $this->turnoRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->turnoRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->turnoRepository->delete($id);
    }

    public function obtenerTurnosDisponibles($medico_id, $fecha_desde, $fecha_hasta)
    {
        // Suponemos que el turno "Disponible" tiene estado_turno_id = 13
        $estadoDisponible = 13;

        return $this->turnoRepository->obtenerTurnosPorEstadoYFecha(
            $medico_id,
            $estadoDisponible,
            $fecha_desde,
            $fecha_hasta
        );
    }

    public function generarTurnosDisponibles($medico_id, $fecha_desde, $fecha_hasta)
{
    $agenda = $this->agendaMedicaRepository->obtenerPorMedico($medico_id);

    if (!$agenda || $agenda->isEmpty()) {
        return [];
    }

    $estadoDisponible = 13;
    $turnosGenerados = [];

    $diasSemanaMap = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miercoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sabado',
        7 => 'Domingo',
    ];

    $start = strtotime($fecha_desde);
    $end = strtotime($fecha_hasta);

    for ($fecha = $start; $fecha <= $end; $fecha += 86400) {
        $nombreDia = $diasSemanaMap[date('N', $fecha)]; // 1 (Lunes) a 7 (Domingo)

        // Filtrar horarios de agenda para ese día
        $horariosDia = $agenda->filter(function ($a) use ($nombreDia) {
            return $a->dia_semana === $nombreDia;
        });

        foreach ($horariosDia as $horario) {
            $fechaTexto = date('Y-m-d', $fecha);

            $inicio = strtotime($fechaTexto . ' ' . $horario->hora_inicio);
            $fin = strtotime($fechaTexto . ' ' . $horario->hora_fin);

            $almuerzoInicio = strtotime($fechaTexto . ' ' . $horario->almuerzo_inicio);
            $almuerzoFin = strtotime($fechaTexto . ' ' . $horario->almuerzo_fin);

            while ($inicio < $fin) {
                // Saltar si estamos en horario de almuerzo
                if ($inicio >= $almuerzoInicio && $inicio < $almuerzoFin) {
                    $inicio = $almuerzoFin;
                    continue;
                }

                $horaTexto = date('H:i:s', $inicio);

                // Verificar si ya existe un turno en esa fecha y hora
                $existe = $this->turnoRepository->existeTurno($medico_id, $fechaTexto, $horaTexto);

                if (!$existe) {
                    $turnoData = [
                        'medico_id' => $medico_id,
                        'paciente_id' => null,
                        'fecha' => $fechaTexto,
                        'hora' => $horaTexto,
                        'estado_turno_id' => $estadoDisponible,
                        'agenda_medica_id' => $horario->id,
                        'motivo_consulta' => null,
                    ];

                    $turno = $this->turnoRepository->create($turnoData);
                    $turnosGenerados[] = $turno;
                }

                $inicio += 30 * 60; // avanzar 30 minutos
            }
        }
    }

    return $turnosGenerados;
}

public function agendarTurno($id, $data)
{
    $turno = $this->turnoRepository->findById($id);

    // Validar que el turno esté disponible (ejemplo estado 13)
    if ($turno->estado_turno_id != 13) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'estado_turno_id' => ['El turno no está disponible para ser agendado.']
        ]);
    }

    $turno->paciente_id = $data['paciente_id'];
    $turno->motivo_consulta = $data['motivo_consulta'];
    $turno->estado_turno_id = $data['estado_turno_id']; // Ej: el id de "reservado"

    return $this->turnoRepository->save($turno);
}
public function getTurnosReservadosDesdeHoyPorMedico($medicoId)
{
    $today = date('Y-m-d');

    return $this->turnoRepository->getTurnosReservadosDesdeFecha($medicoId, $today);
}

public function obtenerTurnosPorEstadoYFechas($estadoId, $fechaDesde, $fechaHasta)
{
    return Turno::with('medico.usuario.persona')
        ->where('estado_turno_id', $estadoId)
        ->whereBetween('fecha', [$fechaDesde, $fechaHasta])
        ->get();
}
}

