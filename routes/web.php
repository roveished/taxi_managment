<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarWorkingController;
use App\Http\Controllers\PermitController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\CarInspectionController;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/home', function () {
    return view('home');
})->middleware('auth');
Route::get('/check', function () {
    return view('check');
})->middleware('auth');
Route::get('/drivers/create', [DriverController::class, 'create'])->name('drivers.create')->middleware('auth');
Route::post('/drivers', [DriverController::class, 'store'])->name('drivers.store')->middleware('auth');
Route::get('/permits/create/{driver_id}', [PermitController::class, 'create'])->name('permits.create');
Route::post('/permits', [PermitController::class, 'store'])->name('permits.store');
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
Route::get('/cars/attendance', [CarController::class, 'attendance'])->name('cars.attendance');

Route::post('/car-working/store', [CarWorkingController::class, 'store'])->name('car_working.store');
Route::get('/cars/attendance/edit', [CarWorkingController::class, 'editAttendance'])->name('cars.attendance.edit');
Route::get('/car-working/search', [CarWorkingController::class, 'search'])->name('car_working.search');
Route::get('/car-working/search', [CarWorkingController::class, 'search'])->name('car_working.search');
Route::put('/car-working/update', [CarWorkingController::class, 'update'])->name('car_working.update');

Route::get('/permits/edit', [PermitController::class, 'editForm'])->name('permits.edit');
Route::post('/permits/search', [PermitController::class, 'search'])->name('permits.search');
Route::post('/permits/update/{permit}', [PermitController::class, 'update'])->name('permits.update');

Route::get('/missions/create', [MissionController::class, 'create'])->name('missions.create');

Route::get('/api/destinations', function () {
    return \App\Models\Destination::all();
})->name('api.destinations')->middleware('auth');
Route::get('/api/destinations/by-origin/{origin}', [DestinationController::class, 'getByOrigin'])->name('api.destinations.byOrigin')->middleware('auth');

Route::get('/get-cars-by-type/{type}', [CarController::class, 'getByType']);
Route::get('/get-car-info/{car_id}', [\App\Http\Controllers\CarController::class, 'getCarInfo']);
Route::get('/get-all-drivers', [CarController::class, 'getAllDrivers']);
Route::post('/update-car-driver/{car}', [CarController::class, 'updateDriver']);
Route::post('/missions/store', [MissionController::class, 'store'])->name('missions.store');

Route::get('/cars/search', [CarController::class, 'searchByPlate']);

Route::post('/inspections/store', [CarInspectionController::class, 'store'])->name('inspections.store');

Route::get('/missions/inprogress', [MissionController::class, 'inprogress'])->name('missions.inprogress');
Route::get('/missions/inprogress', [MissionController::class, 'showInProgress'])->name('missions.inprogress');


Route::post('/missions/calculate-defaults', [MissionController::class, 'calculateDefaults'])->name('missions.calculate.defaults');
Route::post('/missions/end', [MissionController::class, 'endMission'])->name('missions.end');
Route::get('/missions/finished', [MissionController::class, 'showInfinished'])->name('missions.finished');
Route::get('/missions/{id}/edit', [MissionController::class, 'edit'])->name('missions.edit');
Route::put('/missions/update', [MissionController::class, 'update'])->name('missions.update');
Route::get('/missions/waiting', [MissionController::class, 'showWaiting'])->name('missions.waiting');

Route::get('/missions/waiting', [MissionController::class, 'showWaiting'])->name('missions.waiting');
Route::post('/missions/change-status', [MissionController::class, 'changeStatus'])->name('missions.changeStatus');
Route::post('/missions/{id}/cancel', [MissionController::class, 'cancel']);

Route::get('/missions/lookup', [MissionController::class, 'showLookupForm'])->name('missions.lookup.form');
Route::post('/missions/lookup', [MissionController::class, 'performLookup'])->name('missions.lookup.submit');

Route::get('/missions/priority', [MissionController::class, 'priority'])->name('missions.priority');
Route::get('/missions/unique-destinations', [MissionController::class, 'getUniqueDestinations'])->name('missions.unique-destinations');
Route::post('/missions/car-priority', [MissionController::class, 'getCarPriority'])->name('missions.car-priority');
Route::post('/permits/check-expired', [PermitController::class, 'checkExpired'])
    ->name('permits.check-expired')
    ->middleware('auth');
Route::post('/inspections/check-expired', [CarInspectionController::class, 'checkAndUpdateExpiredInspections'])->name('inspections.check-expired');
Route::get('/cars-needing-inspection', [App\Http\Controllers\CarInspectionController::class, 'carsNeedingInspection'])
->name('cars.needingInspection');
Route::get('/permits/status', [App\Http\Controllers\PermitController::class, 'status'])->name('permits.status');
Route::get('/home', function () {
    return view('home');
})->name('home');
