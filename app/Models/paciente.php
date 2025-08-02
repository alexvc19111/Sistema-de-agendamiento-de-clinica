<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class paciente extends Model
{
    //
    protected $fillable = ['persona_id'];

    public function turno(){
        return $this->hasMany(turno::class);
    }

    
    public function derivacion(){
        return $this->hasMany(derivacion::class);
    }
    public function persona()
    {
        return $this->belongsTo(persona::class);
    }
}
