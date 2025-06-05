<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rol extends Model
{
    //
        protected $table = 'rols'; // Indica la tabla correcta

    protected $fillable=['nombre_rol'];

    public function usuario_rol(){
        return $this->hasMany(usuario_rol::class);

    }
}
