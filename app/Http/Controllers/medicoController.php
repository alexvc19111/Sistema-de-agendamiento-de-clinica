<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicoRequest;
use App\Services\MedicoService;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    protected $medicoService;

    public function __construct(MedicoService $medicoService)
    {
        $this->medicoService = $medicoService;
    }

    public function index()
    {
        return response()->json($this->medicoService->getAll(), 200);
    }

    public function show($id)
    {
        return response()->json($this->medicoService->find($id));
    }

    public function store(MedicoRequest $request)
    {
        return response()->json($this->medicoService->create($request->validated()), 201);
    }

    public function update(MedicoRequest $request, $id)
    {
        return response()->json($this->medicoService->update($id, $request->validated()));
    }

    public function destroy($id)
    {
        $this->medicoService->delete($id);
        return response()->json(['message' => 'Médico eliminado']);
    }

    public function findByUsuarioId($usuario_id)
{
    $medico = $this->medicoService->findByUsuarioId($usuario_id);

    if (!$medico) {
        return response()->json(['message' => 'Médico no encontrado'], 404);
    }

    return response()->json($medico);
}
}
