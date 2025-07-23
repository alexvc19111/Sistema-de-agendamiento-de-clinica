<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class agenda_medica extends Model
{

    protected $table = 'agenda_medica';
    
    protected $fillable = ['medico_id', 'dia_semana', 'hora_inicio', 'hora_fin', 'almuerzo_inicio', 'almuerzo_fin'];

    public function medico()
    {
        return $this->belongsTo(medico::class);
    }
}
