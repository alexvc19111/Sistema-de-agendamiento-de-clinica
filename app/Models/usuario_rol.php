<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usuario_rol extends Model
{
    //
    protected $fillable=['usuario_id','rol_id'];

    public function rol(){
        return $this->belongsTo(rol::class);
    }
    public function usuario(){
        return $this->belongsTo(usuario::class);
    }
}
