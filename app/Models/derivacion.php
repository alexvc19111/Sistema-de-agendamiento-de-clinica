<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class derivacion extends Model
{
    //
    protected $fillable = ['turno_id', 'paciente_id', 'medico_id', 'estado_turno_id', 'motivo'];

    public function turno()
    {
        return $this->belongsTo(turno::class);
    }

    public function paciente()
    {
        return $this->belongsTo(paciente::class);
    }

    public function medico()
    {
        return $this->belongsTo(medico::class);
    }

    public function estado_turno()
    {
        return $this->belongsTo(estado_turno::class);
    }
}
