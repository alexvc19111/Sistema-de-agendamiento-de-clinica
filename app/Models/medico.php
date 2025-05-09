<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class medico extends Model
{
    //
    protected $fillable = ['usuario_id', 'especialidad_id'];


    public function turno(){
        return $this->hasMany(turno::class);
    }

    public function usuario()
    {
        return $this->belongsTo(usuario::class);
    }

    public function especialidad()
    {
        return $this->belongsTo(especialidad::class);
    }

    public function derivacion(){
        return $this->hasMany(derivacion::class);
    }
}
