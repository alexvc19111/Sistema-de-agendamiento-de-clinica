<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class turno extends Model
{
    //
    protected $fillable = ['medico_id', 'paciente_id', 'fecha', 'hora', 'estado_turno_id'];

    public function medico()
    {
        return $this->belongsTo(medico::class);
    }

    public function paciente()
    {
        return $this->belongsTo(paciente::class);
    }

    public function estado_turno()
    {
        return $this->belongsTo(estado_turno::class);
    }

    public function derivacion(){
        return $this->hasMany(derivacion::class);
    }

    public function atencion(){
        return $this->hasMany(atencion::class);
    }
}
