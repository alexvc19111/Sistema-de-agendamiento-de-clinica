<?php

use Illuminate\Support\Facades\Route;

// Opcionalmente, redirecciona al frontend si quieres
Route::get('/', function () {
    return redirect('http://localhost:5173'); // O el puerto de tu Vite React
});
