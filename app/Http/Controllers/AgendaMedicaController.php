<?php
namespace App\Http\Controllers;

use App\Http\Requests\AgendaMedicaRequest;
use App\Services\AgendaMedicaService;
use Illuminate\Http\JsonResponse;

class AgendaMedicaController extends Controller
{
    protected $agendaService;

    public function __construct(AgendaMedicaService $agendaService)
    {
        $this->agendaService = $agendaService;
    }

    public function store(AgendaMedicaRequest $request)
    {
        $agenda = $this->agendaService->crearAgenda($request->validated());
        return response()->json($agenda, 201);
    }


    public function update(AgendaMedicaRequest $request, $id): JsonResponse
    {
        try {
            $agenda = $this->agendaService->actualizarAgenda($id, $request->validated());
            return response()->json($agenda);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function porMedico($medicoId)
    {
        $agenda = $this->agendaService->obtenerAgendaPorMedico($medicoId);
        return response()->json($agenda);
    }
}