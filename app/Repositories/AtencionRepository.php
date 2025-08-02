<?php

namespace App\Repositories;

use App\Models\atencion;

class AtencionRepository
{
    protected $model;

    public function __construct(Atencion $atencion)
    {
        $this->model = $atencion;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $atencion = $this->find($id);
        if ($atencion) {
            $atencion->update($data);
            return $atencion;
        }
        return null;
    }

    public function delete($id)
    {
        $atencion = $this->find($id);
        if ($atencion) {
            return $atencion->delete();
        }
        return false;
    }
}
