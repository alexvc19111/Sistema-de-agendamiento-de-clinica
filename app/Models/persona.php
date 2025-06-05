<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class persona extends Model
{
    use HasFactory;
    //
        protected $fillable=['nombres','apellidos','dni','fecha_nacimiento','direccion','telefono'];

    public function usuario(){
        return $this->hasMany(usuario::class);
    }


}
