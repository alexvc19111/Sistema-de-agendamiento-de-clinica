<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtencionRequest;
use App\Services\AtencionService;
use Illuminate\Http\Request;

class AtencionController extends Controller
{
    protected $service;

    public function __construct(AtencionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $atencions = $this->service->listAll();
        return response()->json($atencions);
    }

    public function show($id)
    {
        $atencion = $this->service->getById($id);
        if (!$atencion) {
            return response()->json(['message' => 'No encontrado'], 404);
        }
        return response()->json($atencion);
    }

    public function store(AtencionRequest $request)
    {
        $atencion = $this->service->create($request->validated());
        return response()->json($atencion, 201);
    }

    public function update(AtencionRequest $request, $id)
    {
        $atencion = $this->service->update($id, $request->validated());
        if (!$atencion) {
            return response()->json(['message' => 'No encontrado'], 404);
        }
        return response()->json($atencion);
    }

    public function destroy($id)
    {
        $deleted = $this->service->delete($id);
        if (!$deleted) {
            return response()->json(['message' => 'No encontrado'], 404);
        }
        return response()->json(null, 204);
    }

    public function porTurno($turnoId)
{
    $atencion = \App\Models\Atencion::where('turno_id', $turnoId)->first();
    if (!$atencion) {
        return response()->json(['error' => 'No se encontró la atención para este turno.'], 404);
    }
    return response()->json($atencion);
}
}
