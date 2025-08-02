<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\personaController;
use App\Http\Controllers\usuarioController;
use App\Http\Controllers\rolController;
use App\Http\Controllers\usuario_rolController;
use App\Http\Controllers\especialidadController;
use App\Http\Controllers\medicoController;
use App\Http\Controllers\pacienteController;
use App\Http\Controllers\estado_turnoController;
use App\Http\Controllers\turnoController;
use App\Http\Controllers\derivacionController;
use App\Http\Controllers\atencionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgendaMedicaController;



//Autenticación
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Rutas de agenda médica protegidas que requieren autenticación
    Route::middleware('role:medico')->group(function () {
        Route::post('/agenda', [AgendaMedicaController::class, 'store']);
    });

    Route::middleware('role:medico,Administrador,recepcionista')->group(function () {
        //Obtener agenda de medico por ID
        Route::get('/agenda/medico/{medico_id}', [AgendaMedicaController::class, 'porMedico']);
       
        Route::put('/agenda/{id}', [AgendaMedicaController::class, 'update']);
        //Obtener turnos disponibles para un médico
        Route::get('/turnos/disponibles/{medico_id}', [TurnoController::class, 'turnosDisponiblesPorMedico']);
        //Generar turnos disponibles para un médico en un rango de fechas verificando la agenda
        Route::post('/turnos/generarturnos/{medico_id}', [TurnoController::class, 'generarTurnos']);
        //Asignar un turno a un paciente


        //Obtener turnos reservados desde hoy por médico
        Route::get('/turnos/reservados/{medicoId}', [TurnoController::class, 'turnosReservadosDesdeHoyPorMedico']);

        Route::get('turnos/historial/{medicoId}', [TurnoController::class, 'historialPorMedico']);


    });
    Route::get('/turnos/disponibles', [TurnoController::class, 'turnosDisponiblesDesdeHoy']);
        Route::put('/turnos/{id}/agendar', [TurnoController::class, 'agendarTurno']);
        //Cambiar estado de un turno
        Route::put('/turnos/{id}/estado', [TurnoController::class, 'cambiarEstado']);
    Route::get('/atenciones/turno/{turnoId}', [AtencionController::class, 'porTurno']);
    Route::apiResource('medicos', MedicoController::class);
    Route::get('/turnos/{medicoID}',[TurnoController::class,'show']);
    Route::apiResource('turnos', TurnoController::class);
    //


});



    //Route::get('/usuarios', [usuarioController::class, 'index']);

Route::middleware(['auth:sanctum', 'log.accesos'])->group(function () {
    // Rutas  de usuarios protegidas que requieren autenticación
    Route::get('/usuarios', [usuarioController::class, 'index']);
    Route::get('/usuarios/{id}', [usuarioController::class, 'show']);
    Route::put('/usuarios/{id}', [usuarioController::class, 'update']);
    Route::delete('/usuarios/{id}', [usuarioController::class, 'destroy']);
    Route::post('/usuarios', [usuarioController::class, 'store']);

    // Rutas de personas protegidas que requieren autenticación
    Route::get('/personas', [personaController::class, 'index']);
    Route::post('/personas', [personaController::class, 'store']);
    Route::get('/personas/{id}', [personaController::class, 'show']);
    Route::put('/personas/{id}', [personaController::class, 'update']);
    Route::delete('/personas/{id}', [personaController::class, 'destroy']);


    // Rutas de roles protegidas que requieren autenticación
    Route::get('/roles', [rolController::class, 'index']);
    Route::post('/roles', [rolController::class, 'store']);  
    Route::get('/roles/{id}', [rolController::class, 'show']); 
    Route::put('/roles/{id}', [rolController::class, 'update']); 
    Route::delete('/roles/{id}', [rolController::class, 'destroy']); 

    // Rutas de usuario_rol protegidas que requieren autenticación
    Route::get('/usuario-roles', [usuario_rolController::class, 'index']);
    Route::post('/usuario-roles', [usuario_rolController::class, 'store']);
    Route::get('/usuario-roles/{id}', [usuario_rolController::class, 'show']);
    Route::put('/usuario-roles/{id}', [usuario_rolController::class, 'update']);
    Route::delete('/usuario-roles/{id}', [usuario_rolController::class, 'destroy']);

    // Rutas de especialidades protegidas que requieren autenticación
    Route::get('/especialidades', [especialidadController::class, 'index']);
    Route::post('/especialidades', [especialidadController::class, 'store']);
    Route::get('/especialidades/{id}', [especialidadController::class, 'show']);
    Route::put('/especialidades/{id}', [especialidadController::class, 'update']);
    Route::delete('/especialidades/{id}', [especialidadController::class, 'destroy']);

    Route::get('/medicos', [medicoController::class, 'index']);
    Route::post('/medicos', [medicoController::class, 'store']);
    Route::get('/medicos/{id}', [medicoController::class, 'show']);
    Route::put('/medicos/{id}', [medicoController::class, 'update']);
    Route::delete('/medicos/{id}', [medicoController::class, 'destroy']);
    Route::get('/medicos/usuario/{usuario_id}', [medicoController::class, 'findByUsuarioId']);


//Paciente
    Route::get('/pacientes', [pacienteController::class, 'index']);
    Route::post('/pacientes', [pacienteController::class, 'store']);
    Route::get('/pacientes/buscar', [pacienteController::class, 'buscar']);
    Route::get('/pacientes/{id}', [pacienteController::class, 'show']);
    Route::put('/pacientes/{id}', [pacienteController::class, 'update']);
    Route::delete('/pacientes/{id}', [pacienteController::class, 'destroy']);

//Estado_turno
    Route::get('/estado-turnos', [estado_turnoController::class, 'index']);
    Route::post('/estado-turnos', [estado_turnoController::class, 'store']);
    Route::get('/estado-turnos/{id}', [estado_turnoController::class, 'show']);
    Route::put('/estado-turnos/{id}', [estado_turnoController::class, 'update']);
    Route::delete('/estado-turnos/{id}', [estado_turnoController::class, 'destroy']);

//Turno
    Route::get('/turnos', [turnoController::class, 'index']);
    Route::post('/turnos', [turnoController::class, 'store']);
    Route::get('/turnos/{id}', [turnoController::class, 'show']);
    Route::put('/turnos/{id}', [turnoController::class, 'update']);
    Route::delete('/turnos/{id}', [turnoController::class, 'destroy']);


//Derivacion
    Route::get('/derivaciones', [derivacionController::class, 'index']);
    Route::post('/derivaciones', [derivacionController::class, 'store']);
    Route::get('/derivaciones/{id}', [derivacionController::class, 'show']);
    Route::put('/derivaciones/{id}', [derivacionController::class, 'update']);
    Route::delete('/derivaciones/{id}', [derivacionController::class, 'destroy']);

//Atencion
    Route::get('/atenciones', [atencionController::class, 'index']);
    Route::post('/atenciones', [atencionController::class, 'store']);
    Route::get('/atenciones/{id}', [atencionController::class, 'show']);
    Route::put('/atenciones/{id}', [atencionController::class, 'update']);
    Route::delete('/atenciones/{id}', [atencionController::class, 'destroy']);



});

//Route::post('/usuarios', [usuarioController::class, 'store']); // creación de usuarios sin login




//Medico


