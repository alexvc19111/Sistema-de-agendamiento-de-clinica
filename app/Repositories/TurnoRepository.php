<?php

namespace App\Repositories;

use App\Models\turno;
use App\Repositories\Interfaces\TurnoRepositoryInterface;
use Illuminate\Support\Collection;

class TurnoRepository implements TurnoRepositoryInterface
{
    protected $model;

    public function __construct(turno $turno)
    {
        $this->model = $turno;
    }

    public function all() : Collection
    {
        return $this->model->with(['medico', 'paciente', 'estado_turno','agenda_medica'])->get();
    }

    public function findById($id)
    {
        return $this->model->with(['medico', 'paciente', 'estado_turno','agenda_medica'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $turno = $this->find($id);
        $turno->update($data);
        return $turno;
    }

    public function delete($id)
    {
        $turno = $this->find($id);
        return $turno->delete();
    }

    public function obtenerTurnosPorEstadoYFecha($medico_id, $estado_turno_id, $fecha_desde, $fecha_hasta)
{
    return turno::where('medico_id', $medico_id)
        ->where('estado_turno_id', $estado_turno_id)
        ->whereBetween('fecha', [$fecha_desde, $fecha_hasta])
        ->orderBy('fecha', 'asc')
        ->orderBy('hora', 'asc')
        ->get();
}
public function existeTurno($medico_id, $fecha, $hora)
    {
        return $this->model
            ->where('medico_id', $medico_id)
            ->where('fecha', $fecha)
            ->where('hora', $hora)
            ->exists();
    }

 public function save(Turno $turno)
    {
        $turno->save();
        return $turno;
    }

    public function getTurnosReservadosDesdeFecha($medicoId, $fecha)
{
    return $this->model
        ->where('medico_id', $medicoId)
        ->where('estado_turno_id', 14) // Estado reservado
        ->where('fecha', '>=', $fecha)
        ->with(['paciente', 'estado_turno', 'agenda_medica'])
        ->orderBy('fecha')
        ->get();
}
}
