<?php

namespace App\Repositories\Interfaces;

interface AgendaMedicaRepositoryInterface
{
    public function crearAgenda(array $data);
    public function obtenerPorMedico($medicoId);
}
