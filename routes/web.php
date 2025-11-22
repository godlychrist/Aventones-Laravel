<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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