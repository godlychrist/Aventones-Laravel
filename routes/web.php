<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
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

Route::get('registerUser', function () {
    return view('register');
})->name('registerUser');

Route::get('indexM', function () {
    return view('index');
})->name('indexM');

Route::get('loginRedirect', function () {
    return view('login');
})->name('loginRedirect');

// User Routes
Route::get('register', [UserController::class, 'create'])->name('register');
Route::post('register', [UserController::class, 'store'])->name('saveUser');

Route::get('users', [UserController::class, 'index'])->name('showUsers');

Route::get('users/{cedula}/edit', [UserController::class, 'edit'])->name('editUser');
Route::put('users/{cedula}', [UserController::class, 'update'])->name('updateUser');

Route::delete('users/{cedula}', [UserController::class, 'destroy'])->name('deleteUser');

// Login Route
Route::post('login', [LoginController::class, 'auth'])->name('loginAttempt');