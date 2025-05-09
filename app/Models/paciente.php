<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class paciente extends Model
{
    //
    protected $fillable = ['usuario_id'];

    public function turno(){
        return $this->hasMany(turno::class);
    }

    public function usuario()
    {
        return $this->belongsTo(usuario::class);
    }
    
    public function derivacion(){
        return $this->hasMany(derivacion::class);
    }
}
