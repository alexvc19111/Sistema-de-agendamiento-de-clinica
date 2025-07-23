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
        return response()->json($this->medicoService->obtener($id));
    }

    public function store(MedicoRequest $request)
    {
        return response()->json($this->medicoService->crear($request->validated()), 201);
    }

    public function update(MedicoRequest $request, $id)
    {
        return response()->json($this->medicoService->actualizar($id, $request->validated()));
    }

    public function destroy($id)
    {
        $this->medicoService->eliminar($id);
        return response()->json(['message' => 'Médico eliminado']);
    }
}
