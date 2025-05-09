<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class persona extends Model
{
    //
    protected $fillable=['nombres','apellidos','dni','fecha_nacimiento','direccion','telefono'];

    public function usuario(){
        return $this->hasMany(usuario::class);
    }


}
