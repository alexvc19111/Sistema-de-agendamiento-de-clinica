<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;




class usuario extends Authenticatable
{
    //
    use HasApiTokens, HasFactory;
  
    protected $fillable=['username','password','persona_id'];

    protected $hidden = ['password']; // Oculta el campo password en las respuestas JSON

    public function persona(){
        return $this->belongsTo(persona::class);
    }

    public function paciente(){
        return $this->hasMany(paciente::class);
    }

    public function usuario_rol(){
        return $this->hasMany(usuario_rol::class);
    }
    public function roles(){
        return $this->belongsToMany(
            rol::class,      // Modelo relacionado
            'usuario_rols',   // Tabla pivote
            'usuario_id',    // FK usuario en pivote
            'rol_id'         // FK rol en pivote
        );
    }
    
    public function hasRole($roleName)
{
    return $this->roles()->where('nombre_rol', $roleName)->exists();
}
}
