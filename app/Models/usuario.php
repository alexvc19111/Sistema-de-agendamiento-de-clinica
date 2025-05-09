<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usuario extends Model
{
    //  
    protected $fillable=['username','password','persona_id'];

    public function persona(){
        return $this->belongsTo(persona::class);
    }

    public function paciente(){
        return $this->hasMany(paciente::class);
    }
}
