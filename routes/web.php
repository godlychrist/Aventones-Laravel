<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehicleController;


// =======================
// RUTA PRINCIPAL
// =======================
Route::get('/', function () {
    return view('welcome');
});


// =======================
// LOGIN
// =======================
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'auth'])
    ->name('loginAttempt');

Route::get('loginRedirect', function () {
    return view('login');
})->name('loginRedirect');


// =======================
// REGISTRO
// =======================
Route::get('/registration_driver', function () {
    return view('registration_driver');
})->name('registration_driver');

Route::get('/registration_passenger', function () {
    return view('registration_passenger');
})->name('registration_passenger');


// =======================
// PERFIL
// =======================
Route::get('/profile', function () {
    return view('profile');
})->name('profile');


// =======================
// RIDES
// =======================
Route::get('/rides', function () {
    return view('ride');   // Importante: SIN la “s”
})->name('rides');


// =======================
// BOOKINGS
// =======================
Route::get('/mybookings', function () {
    return view('mybookings');
})->name('mybookings');


// =======================
// PANEL PRINCIPAL
// =======================
Route::get('/indexM', function () {
    return view('index');
})->name('indexM');


// =======================
// CRUD USERS
// =======================
Route::get('register', [UserController::class, 'create'])->name('register');
Route::post('register', [UserController::class, 'store'])->name('saveUser');

Route::get('users', [UserController::class, 'index'])->name('showUsers');

Route::get('users/{cedula}/edit', [UserController::class, 'edit'])->name('editUser');
Route::put('users/{cedula}', [UserController::class, 'update'])->name('updateUser');

Route::delete('users/{cedula}', [UserController::class, 'destroy'])->name('deleteUser');


// =======================
// CRUD DRIVERS
// =======================
Route::get('registerDriver', [DriverController::class, 'create'])->name('registerDriver');
Route::post('registerDriver', [DriverController::class, 'store'])->name('saveDriver');

Route::get('drivers', [DriverController::class, 'index'])->name('showDrivers');

Route::get('drivers/{cedula}/edit', [DriverController::class, 'edit'])->name('editDriver');
Route::put('drivers/{cedula}', [DriverController::class, 'update'])->name('updateDriver');

Route::delete('drivers/{cedula}', [DriverController::class, 'destroy'])->name('deleteDriver');


// =======================
// CRUD VEHICLES (MVC REAL)
// =======================
Route::middleware('auth')->group(function () {

    // LISTA DE VEHÍCULOS
    Route::get('/vehicles', [VehicleController::class, 'index'])
        ->name('vehicles');

    // FORMULARIO CREAR VEHÍCULO
    Route::get('/vehicles/create', [VehicleController::class, 'create'])
        ->name('vehicle.create');

    // GUARDAR VEHÍCULO
    Route::post('/vehicles', [VehicleController::class, 'store'])
        ->name('vehicles.store');

    // FORMULARIO EDITAR
    Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])
        ->name('vehicles.edit');

    // ACTUALIZAR
    Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])
        ->name('vehicles.update');

    // ELIMINAR
    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])
        ->name('vehicles.destroy');
});
