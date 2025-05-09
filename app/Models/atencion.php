<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class atencion extends Model
{
    //
    protected $fillable = ['turno_id', 'diagnostico', 'tratamiento', 'observaciones'];

    public function turno() {
        return $this->belongsTo(turno::class);
    }
}
