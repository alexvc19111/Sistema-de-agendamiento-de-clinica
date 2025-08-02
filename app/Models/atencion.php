<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atencion extends Model
{
    protected $fillable = [
        'turno_id',
        'presion',
        'temperatura',
        'frecuencia_cardiaca',
        'frecuencia_respiratoria',
        'peso',
        'talla',
        'diagnostico',
        'observaciones',
    ];

    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }
}
