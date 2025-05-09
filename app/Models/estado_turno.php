<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class estado_turno extends Model
{
    //
    protected $fillable = ['nombre_estado'];

    public function turno(){
        return $this->hasMany(turno::class);
    }

    public function derivacion(){
        return $this->hasMany(derivacion::class);
    }
}
