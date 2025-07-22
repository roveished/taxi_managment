<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarInspection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CarInspectionController extends Controller
{
    public function store(Request $request)
{
    Log::info("Request payload", $request->all());
    $car = Car::where('car_plate', $request->car_plate)->first();

    if (!$car) {
        return back()->withErrors(['car_plate' => 'خودرویی با این پلاک پیدا نشد']);
    }
    
   /* $inspection = new CarInspection();
    $inspection->car_id = $car->id;
    $inspection->driver_id = $car->driver_id;
    $inspection->inspection_date = now();
    $inspection->expiration_date = $request->expiration_date;
    $inspection->status = $request->status;
    $inspection->description = $request->description;
    $inspection->user_id = Auth::id();

    $inspection->front_glass =  $request->boolean('front_glass');
    $inspection->rear_glass =  $request->boolean('rear_glass');
    $inspection->toolbox =  $request->boolean('toolbox');
    $inspection->first_aid_kit =  $request->boolean('first_aid_kit');
    $inspection->spare_tire =  $request->boolean('spare_tire');
    $inspection->front_tires =  $request->boolean('front_tires');
    $inspection->rear_tires =  $request->boolean('rear_tires');
    $inspection->front_lights =  $request->boolean('front_lights');
    $inspection->rear_lights =  $request->boolean('rear_lights');
    $inspection->front_fog_lights =  $request->boolean('front_fog_lights');
    $inspection->rear_fog_lights =  $request->boolean('rear_fog_lights'); // اضافه شده
    $inspection->brake_system =  $request->boolean('brake_system');
    $inspection->mechanical_condition =  $request->boolean('mechanical_condition'); // اصلاح شد
    $inspection->cabin_appearance =  $request->boolean('cabin_appearance'); // اضافه شد
    $inspection->body_appearance =  $request->boolean('body_appearance');
   
    
    $inspection->save();*/
    CarInspection::create([
        'car_id' => $car->id,
        'driver_id' => $car->driver_id,
        'inspection_date' => now(),
        'expiration_date' => $request->expiration_date,
        'status' => $request->status,
        'description' => $request->description,
        'user_id' => Auth::id(),
        'front_glass' => $request->boolean('front_glass'),
        'rear_glass' => $request->boolean('rear_glass'),
        'toolbox' => $request->boolean('toolbox'),
        'first_aid_kit' => $request->boolean('first_aid_kit'),
        'spare_tire' => $request->boolean('spare_tire'),
        'front_tires' => $request->boolean('front_tires'),
        'rear_tires' => $request->boolean('rear_tires'),
        'front_lights' => $request->boolean('front_lights'),
        'rear_lights' => $request->boolean('rear_lights'),
        'front_fog_lights' => $request->boolean('front_fog_lights'),
        'rear_fog_lights' => $request->boolean('rear_fog_lights'),
        'brake_system' => $request->boolean('brake_system'),
        'mechanical_condition' => $request->boolean('mechanical_condition'),
        'cabin_appearance' => $request->boolean('cabin_appearance'),
        'body_appearance' => $request->boolean('body_appearance'),
    ]);
    

    return redirect()->back()->with('success', 'بازدید خودرو با موفقیت ثبت شد.');
}

}
