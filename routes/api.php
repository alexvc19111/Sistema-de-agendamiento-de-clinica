<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\personaController;
use app\Http\Controllers\usuarioController;
use app\Http\Controllers\rolController;
use app\Http\Controllers\usuario_rolController;
use app\Http\Controllers\especialidadController;
use app\Http\Controllers\medicoController;
use app\Http\Controllers\pacienteController;
use app\Http\Controllers\estado_turnoController;
use app\Http\Controllers\turnoController;
use app\Http\Controllers\derivacionController;
use app\Http\Controllers\atencionController;



//Persona
Route::get('/retornar-personas', [personaController::class, 'index']);
Route::post('/guardar-personas', [personaController::class, 'store']);
Route::get('/retornar-personas/{id}', [personaController::class, 'show']);
Route::put('/actualizar-personas/{id}', [personaController::class, 'update']);
Route::delete('/borrar-personas/{id}', [personaController::class, 'destroy']);

//Usuario
Route::get('/retornar-usuarios', [usuarioController::class, 'index']); 
Route::post('/guardar-usuarios', [usuarioController::class, 'store']); 
Route::get('/retornar-usuarios/{id}', [usuarioController::class, 'show']); 
Route::put('/actualizar-usuarios/{id}', [usuarioController::class, 'update']); 
Route::delete('/borrar-usuarios/{id}', [usuarioController::class, 'destroy']); 

//Rol
Route::get('/retornar-roles', [rolController::class, 'index']);
Route::post('/guardar-roles', [rolController::class, 'store']);  
Route::get('/retornar-roles/{id}', [rolController::class, 'show']); 
Route::put('/actualizar-roles/{id}', [rolController::class, 'update']); 
Route::delete('/borrar-roles/{id}', [rolController::class, 'destroy']); 

//Usuario_Rol
Route::get('/retornar-usuario-rols', [usuario_rolController::class, 'index']); 
Route::post('/guardar-usuario-rols', [usuario_rolController::class, 'store']);  
Route::get('/retornar-usuario-rols/{id}', [usuario_rolController::class, 'show']);  
Route::put('/actualizar-usuario-rols/{id}', [usuario_rolController::class, 'update']);  
Route::delete('/borrar-usuario-rols/{id}', [usuario_rolController::class, 'destroy']);

//Especialidad
Route::get('/retornar-especialidads', [especialidadController::class, 'index']);
Route::post('/guardar-especialidads', [especialidadController::class, 'store']); 
Route::get('/retornar-especialidads/{id}', [especialidadController::class, 'show']); 
Route::put('/actualizar-especialidads/{id}', [especialidadController::class, 'update']); 
Route::delete('/borrar-especialidads/{id}', [especialidadController::class, 'destroy']);  

//Medico
Route::get('/retornar-medicos', [medicoController::class, 'index']);
Route::post('/guardar-medicos', [medicoController::class, 'store']);
Route::get('/retornar-medicos/{id}', [medicoController::class, 'show']);
Route::put('/actualizar-medicos/{id}', [medicoController::class, 'update']);
Route::delete('/borrar-medicos/{id}', [medicoController::class, 'destroy']);

//Paciente
Route::get('/retornar-pacientes', [pacienteController::class, 'index']);
Route::post('/guardar-pacientes', [pacienteController::class, 'store']);
Route::get('/retornar-pacientes/{id}', [pacienteController::class, 'show']);
Route::put('/actualizar-pacientes/{id}', [pacienteController::class, 'update']);
Route::delete('/borrar-pacientes/{id}', [pacienteController::class, 'destroy']);

//Estado_turno
Route::get('/retornar-estados-turno', [estado_turnoController::class, 'index']);
Route::post('/guardar-estado-turno', [estado_turnoController::class, 'store']);
Route::get('/retornar-estado-turno/{id}', [estado_turnoController::class, 'show']);
Route::put('/actualizar-estado-turno/{id}', [estado_turnoController::class, 'update']);
Route::delete('/borrar-estado-turno/{id}', [estado_turnoController::class, 'destroy']);

//Turno
Route::get('/retornar-turnos', [turnoController::class, 'index']);
Route::post('/guardar-turno', [turnoController::class, 'store']);
Route::get('/retornar-turno/{id}', [turnoController::class, 'show']);
Route::put('/actualizar-turno/{id}', [turnoController::class, 'update']);
Route::delete('/borrar-turno/{id}', [turnoController::class, 'destroy']);

//Derivacion
Route::get('/retornar-derivaciones', [derivacionController::class, 'index']);
Route::post('/guardar-derivacion', [derivacionController::class, 'store']);
Route::get('/retornar-derivacion/{id}', [derivacionController::class, 'show']);
Route::put('/actualizar-derivacion/{id}', [derivacionController::class, 'update']);
Route::delete('/borrar-derivacion/{id}', [derivacionController::class, 'destroy']);

//Atencion
Route::get('/retornar-atencions', [atencionController::class, 'index']);
Route::post('/guardar-atencions', [atencionController::class, 'store']);
Route::get('/retornar-atencions/{id}', [atencionController::class, 'show']);
Route::put('/actualizar-atencions/{id}', [atencionController::class, 'update']);
Route::delete('/borrar-atencions/{id}', [atencionController::class, 'destroy']);


