<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class turno extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'medico_id',
        'paciente_id',
        'fecha',
        'hora',
        'estado_turno_id',
        'agenda_medica_id',
        'motivo_consulta',
    ];

    public function medico() {
        return $this->belongsTo(medico::class);
    }

    public function paciente() {
        return $this->belongsTo(paciente::class);
    }

    public function estado_turno() {
        return $this->belongsTo(estado_turno::class);
    }

    public function agenda_medica() {
        return $this->belongsTo(agenda_medica::class);
    }

    public function atenciones() {
        return $this->hasMany(atencion::class);
    }

    public function derivaciones() {
        return $this->hasMany(derivacion::class);
    }
}
