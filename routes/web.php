<?php

use App\Http\Controllers\DriverController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\RidesController;
use Illuminate\Support\Facades\Route;

/**
 * Redirection Routes
 */

// La ruta raíz debe llamar al controlador para enviar $origins / $destinations a la vista
Route::get('/', [RidesController::class, 'available'])->name('home');

Route::get('/profile', function () {
    return view ('Users.profile');
})->name('/profile')->middleware('auth');

Route::get('/login', function () {
    return view('Users.login');
})->name('login');

Route::get('/index', function () {
    return view('Users.index');
})->name('/index')->middleware('auth');


/**
 * CRUD Users
 */
Route::get('register', [UserController::class, 'create'])->name('register');
Route::post('register', [UserController::class, 'store'])->name('saveUser');

Route::middleware('auth')->group(function () { // Authenticated users only
    Route::get('users', [UserController::class, 'index'])->name('showUsers');

    Route::get('users/{cedula}/edit', [UserController::class, 'edit'])->name('editUser');
    Route::put('users/{cedula}', [UserController::class, 'update'])->name('updateUser');

    Route::delete('users/{cedula}', [UserController::class, 'destroy'])->name('deleteUser');
});

/**
 * Login
 */
Route::post('login', [LoginController::class, 'auth'])->name('loginAttempt');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('activate/{token}', [UserController::class, 'activate'])->name('activate');

/**
 * CRUD Drivers
 */
Route::get('registerDriver', [DriverController::class, 'create'])->name('registerDriver');
Route::post('registerDriver', [DriverController::class, 'store'])->name('saveDriver');

Route::middleware('auth')->group(function () { // Authenticated users only
    Route::get('drivers', [DriverController::class, 'index'])->name('showDrivers');

    Route::get('drivers/{cedula}/edit', [DriverController::class, 'edit'])->name('editDriver');

    Route::put('drivers/{cedula}', [DriverController::class, 'update'])->name('updateDriver');

    Route::delete('drivers/{cedula}', [DriverController::class, 'destroy'])->name('deleteDriver');
});

/**
 * CRUD Vehicles
 */
Route::middleware('auth')->group(function () { // Authenticated users only
    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles');

    Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('vehicle.create');

    Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');

    Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');

    Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');

    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');
});

/**
 * CRUD Rides
 */
Route::middleware('auth')->group(function () { // Authenticated users only
    Route::get('/rides', [RidesController::class, 'index'])->name('rides');

    Route::get('/rides/create', [RidesController::class, 'create'])->name('ride.create');

    Route::post('/rides', [RidesController::class, 'store'])->name('rides.store');

    Route::get('/rides/{ride}/edit', [RidesController::class, 'edit'])->name('rides.edit');

    Route::put('/rides/{ride}', [RidesController::class, 'update'])->name('rides.update');

    Route::delete('/rides/{ride}', [RidesController::class, 'destroy'])->name('rides.destroy');
});