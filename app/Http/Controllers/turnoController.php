<?php
namespace App\Http\Controllers;

use App\Http\Requests\TurnoRequest;
use App\Http\Requests\GenerarTurnosRequest;
use App\Services\TurnoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    protected $turnoService;

    public function __construct(TurnoService $turnoService)
    {
        $this->turnoService = $turnoService;
    }

    public function index(): JsonResponse
    {
        $turnos = $this->turnoService->getAll();
        return response()->json($turnos);
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
        return response()->json(['message' => 'Turno eliminado correctamente']);
    }

    public function generarTurnos(GenerarTurnosRequest $request): JsonResponse
    {
        $medicoId = auth()->user()->medico->id; // Ajusta según tu autenticación
        $this->turnoService->generarTurnosParaRango(
            $medicoId,
            $request->input('fecha_inicio'),
            $request->input('fecha_fin')
        );

        return response()->json(['message' => 'Turnos generados correctamente.']);
    }

    public function disponibilidad(Request $request, $medico_id)
{
    $request->validate([
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
    ]);

    $disponibilidad = $this->turnoService->obtenerDisponibilidad($medico_id, $request->fecha_inicio, $request->fecha_fin);

    return response()->json($disponibilidad);
}
}
