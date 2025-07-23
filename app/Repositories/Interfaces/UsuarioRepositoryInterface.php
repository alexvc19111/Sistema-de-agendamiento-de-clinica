<?php
namespace App\Repositories\Interfaces;

interface UsuarioRepositoryInterface
{
    public function create(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
    public function getAllWithRelations();
}