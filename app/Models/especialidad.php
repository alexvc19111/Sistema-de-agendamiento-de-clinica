<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class especialidad extends Model
{
    //
    protected $fillable = ['nombre_especialidad'];

    public function medico(){
        return $this->hasMany(medico::class);
    }
}
