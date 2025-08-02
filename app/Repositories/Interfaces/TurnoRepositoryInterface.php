<?php
namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface TurnoRepositoryInterface
{
    public function all(): Collection;
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
