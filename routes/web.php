<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home'); // Asegúrate que sea 'home' y no otro nombre
});
Route::get('/login', function () {
    return view('login');
});