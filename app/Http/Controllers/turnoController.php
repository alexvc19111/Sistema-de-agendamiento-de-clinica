<?php
namespace App\Http\Controllers;


use App\Services\TurnoService;
use App\Http\Requests\TurnoRequest;
use App\Http\Requests\AgendarTurnoRequest;
use App\Http\Requests\GenerarTurnosRequest; 
use App\Http\Requests\CambiarEstadoRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Turno;
use Illuminate\Support\Facades\Log;


class turnoController extends Controller
{
    protected $turnoService;

    public function __construct(TurnoService $turnoService)
    {
        $this->turnoService = $turnoService;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->turnoService->getAll());
    }

    public function store(TurnoRequest $request): JsonResponse
    {
        $turno = $this->turnoService->create($request->validated());
        return response()->json($turno, 201);
    }

    public function show($id): JsonResponse
    {
        $turno = $this->turnoService->getById($id);
        return response()->json($turno);
    }

    public function update(TurnoRequest $request, $id): JsonResponse
    {
        $turno = $this->turnoService->update($id, $request->validated());
        return response()->json($turno);
    }

    public function destroy($id): JsonResponse
    {
        $this->turnoService->delete($id);
        return response()->json(['message' => 'Turno eliminado']);
    }

    public function generarTurnos(GenerarTurnosRequest $request, $medico_id)
{
    Log::info("Generando turnos para médico ID: $medico_id");

    $fecha_desde = $request->fecha_desde;
    $fecha_hasta = $request->fecha_hasta;

    Log::info("Fechas: $fecha_desde hasta $fecha_hasta");

    $turnosGenerados = $this->turnoService->generarTurnosDisponibles($medico_id, $fecha_desde, $fecha_hasta);

    Log::info("Se generaron " . count($turnosGenerados) . " turnos");

    return response()->json([
        'mensaje' => 'Turnos disponibles generados',
        'cantidad' => count($turnosGenerados),
        'turnos' => $turnosGenerados,
    ]);
}


    public function turnosDisponiblesPorMedico(Request $request,$medico_id)
{
    // Validamos que venga la fecha final (fecha límite)
    $request->validate([
        'fecha_hasta' => 'required|date|after_or_equal:today',
    ]);

    $fecha_desde = now()->startOfDay();
    $fecha_hasta = $request->fecha_hasta;

    // Usamos el servicio para traer los turnos disponibles
    $turnos = $this->turnoService->obtenerTurnosDisponibles($medico_id, $fecha_desde, $fecha_hasta);

    return response()->json($turnos);
}


public function agendarTurno(AgendarTurnoRequest $request, $id)
{
    $data = $request->validated();

    try {
        $turno = $this->turnoService->agendarTurno($id, $data);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['mensaje' => $e->errors()], 400);
    }

    return response()->json([
        'mensaje' => 'Turno agendado correctamente',
        'turno' => $turno
    ]);
}
public function cambiarEstado(CambiarEstadoRequest $request, $id)
{
    $request->validate([
        'estado_turno_id' => 'required|in:15,16,17,18', // Solo estos estados permitidos
    ]);

    $turno = Turno::findOrFail($id);

    $turno->estado_turno_id = $request->estado_turno_id;
    $turno->save();

    return response()->json([
        'mensaje' => 'Estado del turno actualizado correctamente',
        'turno' => $turno,
    ]);
}
public function turnosReservadosDesdeHoyPorMedico($medicoId)
{
    $turnos = $this->turnoService->getTurnosReservadosDesdeHoyPorMedico($medicoId);
    return response()->json($turnos);
}
public function historialPorMedico($medicoId)
{
    $turnos = \App\Models\Turno::with(['paciente.persona', 'agenda_medica', 'estado_turno'])
        ->where('medico_id', $medicoId)
        ->whereIn('estado_turno_id', [16, 17, 18])
        ->orderBy('fecha', 'desc')
        ->orderBy('hora', 'desc')
        ->get();

    // Formatear para incluir nombre del paciente
    $turnos = $turnos->map(function($turno) {
        $pacienteNombre = $turno->paciente && $turno->paciente->persona
            ? $turno->paciente->persona->nombres . ' ' . $turno->paciente->persona->apellidos
            : 'Nombre no disponible';
        return [
            'id' => $turno->id,
            'fecha' => $turno->fecha,
            'hora' => $turno->hora,
            'motivo_consulta' => $turno->motivo_consulta,
            'estado_turno_id' => $turno->estado_turno_id,
            'estado_turno' => $turno->estado_turno,
            'agenda_medica' => $turno->agenda_medica,
            'pacienteNombre' => $pacienteNombre,
            'paciente' => $turno->paciente,
        ];
    });

    return response()->json($turnos);
}
public function turnosDisponiblesDesdeHoy()
{
    $fechaDesde = now()->startOfDay();
    $fechaHasta = now()->copy()->addMonth()->endOfDay();

    // Estado 13: Disponible
    $turnos = $this->turnoService->obtenerTurnosPorEstadoYFechas(13, $fechaDesde, $fechaHasta);

    // Cargar relaciones necesarias
    $turnos->load('medico.usuario.persona');

    // Log de depuración
    foreach ($turnos as $turno) {
        logger()->info('Turno ID: ' . $turno->id);
        logger()->info('Medico ID: ' . optional($turno->medico)->id);
        logger()->info('Medico nombres: ' . optional(optional(optional($turno->medico)->usuario)->persona)->nombres);
    }

    // Mapeo de respuesta para el frontend
    $formateado = $turnos->map(function ($turno) {
        $medico = $turno->medico;

        return [
            'id' => $turno->id,
            'estado' => 'Disponible',
            'fecha' => $turno->fecha,
            'hora' => $turno->hora,
            'medico' => $medico ? [
                'id' => $medico->id,
                'nombre_especialidad' => $medico->nombre_especialidad,
                'persona' => $medico->usuario && $medico->usuario->persona ? [
                    'nombres' => $medico->usuario->persona->nombres,
                    'apellidos' => $medico->usuario->persona->apellidos,
                ] : null,
            ] : null,
        ];
    });

    return response()->json($formateado);
}






}


