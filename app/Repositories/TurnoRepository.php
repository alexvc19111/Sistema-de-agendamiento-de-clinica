<?php
namespace App\Repositories;

use App\Models\turno;

class TurnoRepository
{
    protected $model;

    public function __construct(turno $turno)
    {
        $this->model = $turno;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
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

    public function existeTurno($medico_id, $fecha, $hora)
{
    return $this->model->where('medico_id', $medico_id)
        ->where('fecha', $fecha)
        ->where('hora', $hora)
        ->exists();
}


    public function getTurnosPorMedicoYRangoFecha($medico_id, $fecha_inicio, $fecha_fin)
    {
        return $this->model
            ->where('medico_id', $medico_id)
            ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
            ->get();
    }
}
