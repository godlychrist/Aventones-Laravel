<?php

use Illuminate\Support\Facades\Route;

// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login', function () {
    return view('login');
})->name('login');

// Registro conductor
Route::get('/registration_driver', function () {
    return view('registration_driver');
})->name('registration_driver');

// Registro pasajero
Route::get('/registration_passenger', function () {
    return view('registration_passenger');
})->name('registration_passenger');

// Perfil
Route::get('/profile', function () {
    return view('profile');
})->name('profile');


// routes/web.php
Route::get('/rides', function () {
    return view('ride');   // <-- SIN la “s”
})->name('rides');


Route::get('/vehicles', function () {
    return view('vehicles'); // resources/views/vehicles.blade.php
})->name('vehicles');

Route::get('/vehicles/create', function () {
    return view('vehicle_create'); 
})->name('vehicle.create');

Route::get('/mybookings', function () {
    return view('mybookings');
})->name('mybookings');
