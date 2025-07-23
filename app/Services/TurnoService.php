<?php
namespace App\Services;

use App\Repositories\TurnoRepository;
use App\Services\AgendaMedicaService; // para generación de turnos según agenda
use App\Repositories\AgendaMedicaRepository; // para obtener agenda médica

class TurnoService
{
    protected $turnoRepo;
    protected $agendaMedicaService;
    protected $agendaMedicaRepo;

    public function __construct(TurnoRepository $turnoRepo, AgendaMedicaService $agendaMedicaService, AgendaMedicaRepository $agendaMedicaRepo)
    {
        $this->turnoRepo = $turnoRepo;
        $this->agendaMedicaService = $agendaMedicaService;
        $this->agendaMedicaRepo = $agendaMedicaRepo;
    }

    public function getAll()
    {
        return $this->turnoRepo->all();
    }

    public function getById($id)
    {
        return $this->turnoRepo->find($id);
    }

    public function create(array $data)
{
    // Verifica si ya hay un turno en esa fecha y hora para ese médico
    $existe = $this->turnoRepo->existeTurno(
        $data['medico_id'],
        $data['fecha'],
        $data['hora']
    );

    if ($existe) {
        throw new \Exception('Este horario ya está ocupado.');
    }

    // Todo ok, se puede crear el turno
    return $this->turnoRepo->create($data);
}


    public function update($id, array $data)
    {
        return $this->turnoRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->turnoRepo->delete($id);
    }
    

    public function generarTurnosParaRango($medico_id, $fecha_inicio, $fecha_fin)
{
    $disponibilidad = $this->obtenerDisponibilidad($medico_id, $fecha_inicio, $fecha_fin);

    foreach ($disponibilidad as $dia) {
        $fecha = $dia['fecha'];
        foreach ($dia['horas_disponibles'] as $hora) {
            $this->turnoRepo->create([
                'medico_id' => $medico_id,
                'fecha' => $fecha,
                'hora' => $hora,
                'estado_turno_id' => 13, // o el ID de "disponible", ajusta según tu sistema
            ]);
        }
    }
}


    public function obtenerDisponibilidad($medico_id, $fecha_inicio, $fecha_fin)
{
    $periodo = new \DatePeriod(
        new \DateTime($fecha_inicio),
        new \DateInterval('P1D'),
        (new \DateTime($fecha_fin))->modify('+1 day') // para incluir el último día
    );

    $turnos = $this->turnoRepo->getTurnosPorMedicoYRangoFecha($medico_id, $fecha_inicio, $fecha_fin);

    $disponibilidad = [];

    foreach ($periodo as $fecha) {
        $diaSemanaTexto = $this->convertirDiaSemana($fecha->format('N')); // 1=Lunes, 7=Domingo
        $agenda = $this->agendaMedicaRepo->getAgendaPorMedicoYDia($medico_id, $diaSemanaTexto);

        if (!$agenda) {
            // No atiende ese día
            continue;
        }

        $horaInicio = new \DateTime($agenda->hora_inicio);
        $horaFin = new \DateTime($agenda->hora_fin);
        $almuerzoInicio = new \DateTime($agenda->almuerzo_inicio);
        $almuerzoFin = new \DateTime($agenda->almuerzo_fin);

        // Extraemos turnos del día actual
        $turnosDelDia = $turnos->filter(function($turno) use ($fecha) {
            return $turno->fecha == $fecha->format('Y-m-d');
        })->pluck('hora')->toArray();

        $horaActual = clone $horaInicio;
        $intervalo = new \DateInterval('PT30M'); // 30 minutos por turno, puedes ajustar

        $horasDisponibles = [];

        while ($horaActual < $horaFin) {
            // No incluir horas de almuerzo
            if ($horaActual >= $almuerzoInicio && $horaActual < $almuerzoFin) {
                $horaActual->add($intervalo);
                continue;
            }

            $horaFormateada = $horaActual->format('H:i:s');

            // No incluir horas ya ocupadas
            if (!in_array($horaFormateada, $turnosDelDia)) {
                $horasDisponibles[] = $horaFormateada;
            }

            $horaActual->add($intervalo);
        }

        $disponibilidad[] = [
            'fecha' => $fecha->format('Y-m-d'),
            'horas_disponibles' => $horasDisponibles,
        ];
    }

    return $disponibilidad;
}

// Función auxiliar para convertir número día a texto (en español)
private function convertirDiaSemana($numero)
{
    $dias = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miercoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sabado',
        7 => 'Domingo',
    ];

    return $dias[$numero] ?? '';
}
}
