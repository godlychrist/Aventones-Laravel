<?php

use App\Http\Controllers\DriverController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\RidesController;
use App\Http\Controllers\BookingsController;
use Illuminate\Support\Facades\Route;


/**
 * Redirection Routes
 */

// Home: página pública con rides disponibles
Route::get('/', [RidesController::class, 'available'])->name('home');

// Perfil (protegido)
// PERFIL (ver y actualizar) – protegidas
Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
});
// Login
Route::get('/login', function () {

    if (Auth::check()) {
        return redirect()->route('/index'); 
    }

    return view('Users.Login');
})->name('login');


Route::get('/index', function () {
    return view('Users.Index');
})->name('/index')->middleware('auth');

/**
 * CRUD Users
 */
Route::get('register', [UserController::class, 'create'])->name('register');
Route::post('register', [UserController::class, 'store'])->name('saveUser');

Route::middleware('auth')->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('showUsers');
    Route::get('registerAdmin', [UserController::class, 'createAdmin'])->name('registerAdmin');
    Route::get('users/{cedula}/edit', [UserController::class, 'edit'])->name('editUser');
    Route::put('users/{cedula}/state', [UserController::class, 'update'])->name('updateUser');

    Route::delete('users/{cedula}', [UserController::class, 'destroy'])->name('deleteUser');
});

/**
 * Login
 */
Route::post('login', [LoginController::class, 'auth'])->name('loginAttempt');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('activate/{token}', [UserController::class, 'activate'])->name('activate');

/**
 * Passwordless Login (Magic Link)
 */
Route::get('/magic-link', [LoginController::class, 'showMagicLinkForm'])->name('magic-link.request');
Route::post('/magic-link', [LoginController::class, 'sendMagicLink'])->name('magic-link.send');
Route::get('/magic-link/login/{token}', [LoginController::class, 'loginWithToken'])->name('magic-link.login');

/**
 * CRUD Drivers
 */
Route::get('registerDriver', [DriverController::class, 'create'])->name('registerDriver');
Route::post('registerDriver', [DriverController::class, 'store'])->name('saveDriver');

Route::middleware('auth')->group(function () {
    Route::get('drivers', [DriverController::class, 'index'])->name('showDrivers');
    Route::get('drivers/{cedula}/edit', [DriverController::class, 'edit'])->name('editDriver');
    Route::put('drivers/{cedula}', [DriverController::class, 'update'])->name('updateDriver');
    Route::delete('drivers/{cedula}', [DriverController::class, 'destroy'])->name('deleteDriver');
});

/**
 * CRUD Vehicles
 */
Route::middleware('auth')->group(function () {
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
Route::middleware('auth')->group(function () {
    Route::get('/rides', [RidesController::class, 'index'])->name('rides');
    Route::get('/rides/create', [RidesController::class, 'create'])->name('ride.create');
    Route::post('/rides', [RidesController::class, 'store'])->name('rides.store');
    Route::get('/rides/{ride}/edit', [RidesController::class, 'edit'])->name('rides.edit');
    Route::put('/rides/{ride}', [RidesController::class, 'update'])->name('rides.update');
    Route::delete('/rides/{ride}', [RidesController::class, 'destroy'])->name('rides.destroy');
});

/**
 * CRUD Bookings
 */
Route::middleware('auth')->group(function () { // Authenticated users only
    Route::get('/bookings', [BookingsController::class, 'index'])->name('bookings');

    Route::get('/bookings/create/{ride_id}', [BookingsController::class, 'create'])->name('booking.create');

    Route::post('/bookings', [BookingsController::class, 'store'])->name('bookings.store');

    Route::get('/bookings/{id}', [BookingsController::class, 'show'])->name('bookings.show');

    Route::get('/bookings/{id}/edit', [BookingsController::class, 'edit'])->name('bookings.edit');

    Route::put('/bookings/{id}', [BookingsController::class, 'update'])->name('bookings.update');

    Route::put('/bookings/{id}/status', [BookingsController::class, 'updateStatus'])->name('bookings.status');

    Route::delete('/bookings/{id}', [BookingsController::class, 'destroy'])->name('bookings.destroy');
});