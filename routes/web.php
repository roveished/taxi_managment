<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\CarController;


Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/home', function () {
    return view('home');
})->middleware('auth');
Route::get('/drivers/create', [DriverController::class, 'create'])->name('drivers.create')->middleware('auth');
Route::post('/drivers', [DriverController::class, 'store'])->name('drivers.store')->middleware('auth');
Route::get('/drivers/edit', [DriverController::class, 'edit'])->name('drivers.edit')->middleware('auth');
Route::get('/drivers/search', [DriverController::class, 'search'])->name('drivers.search')->middleware('auth');
Route::put('/drivers/{driver}', [DriverController::class, 'update'])->name('drivers.update')->middleware('auth');
Route::get('/drivers/active', [DriverController::class, 'active'])->name('drivers.active');
Route::get('/drivers/inactive', [DriverController::class, 'inactive'])->name('drivers.inactive');
Route::get('/destination/create', [DestinationController::class, 'create'])->name('destination.create')->middleware('auth');
Route::post('/destination', [DestinationController::class, 'store'])->name('destination.store')->middleware('auth');


Route::get('/destination', [DestinationController::class, 'edit'])->name('destination.edit')->middleware('auth');
Route::get('/destination/search', [DestinationController::class, 'search'])->name('destination.search')->middleware('auth');
Route::put('/destination/{id}/', [DestinationController::class, 'update'])->name('destination.update')->middleware('auth');

Route::get('/destinations', [DestinationController::class, 'show'])->name('destination.show')->middleware('auth');
Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');
Route::post('/cars', [CarController::class, 'store'])->name('cars.store');

Route::get('/car', [CarController::class, 'show'])->name('cars.show')->middleware('auth');
