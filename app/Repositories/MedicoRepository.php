<?php
namespace App\Repositories;

use App\Models\medico;

class MedicoRepository
{
    public function all()
    {
        return medico::with(['usuario', 'especialidad'])->get();
    }

    public function find($id)
    {
        return medico::with(['usuario', 'especialidad', 'agenda_medica'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return medico::create($data);
    }

    public function update($id, array $data)
    {
        $medico = medico::findOrFail($id);
        $medico->update($data);
        return $medico;
    }

    public function delete($id)
    {
        return medico::destroy($id);
    }

    public function findByUsuarioId($usuarioId)
    {
        return medico::where('usuario_id', $usuarioId)->first();
    }

    public function getAll()
{
    return medico::with(['usuario.persona', 'especialidad'])->get();
}

}
