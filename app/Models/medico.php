<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class medico extends Model
{
    //
    protected $fillable = ['usuario_id', 'especialidad_id'];

    protected $hidden = [
        'usuario_id',
        'especialidad_id',
        'created_at',
        'updated_at'
    ];

    protected $appends = [
        'nombre_usuario',
        'nombre_especialidad',
        'dni',
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'telefono',
        'direccion'
    ];


    public function turno(){
        return $this->hasMany(turno::class);
    }

    public function usuario()
    {
        return $this->belongsTo(usuario::class);
    }

    public function especialidad()
    {
        return $this->belongsTo(especialidad::class);
    }

    public function agenda_medica(){
        return $this->hasMany(agenda_medica::class);
    }

    public function derivacion(){
        return $this->hasMany(derivacion::class);
    }

    public function getNombreUsuarioAttribute()
    {
        return optional($this->usuario->persona)->nombres . ' ' . optional($this->usuario->persona)->apellidos;
    }

    public function getNombreEspecialidadAttribute()
    {
        return optional($this->especialidad)->nombre_especialidad;
    }

    public function getDniAttribute()
    {
        return optional($this->usuario->persona)->dni;
    }

    public function getNombresAttribute()
    {
        return optional($this->usuario->persona)->nombres;
    }

    public function getApellidosAttribute()
    {
        return optional($this->usuario->persona)->apellidos;
    }

    public function getFechaNacimientoAttribute()
    {
        return optional($this->usuario->persona)->fecha_nacimiento;
    }

    public function getTelefonoAttribute()
    {
        return optional($this->usuario->persona)->telefono;
    }

    public function getDireccionAttribute()
    {
        return optional($this->usuario->persona)->direccion;
    }
}
