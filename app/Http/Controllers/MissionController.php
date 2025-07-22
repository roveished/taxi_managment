<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mission;
use App\Models\DestinationMission;
use App\Models\Destination;
use App\Models\Driver;
use App\Models\Car;
use Illuminate\Support\Facades\Log;

class MissionController extends Controller
{
    public function create()
    {
        $origins = Destination::distinct()->pluck('origin');
        $destinations = Destination::all();
        return view('missions.create', compact('origins', 'destinations'));
    }

    public function store(Request $request)
{
   
    $request->validate([
        'departure_date' => 'required|date',
        'departure_time' => 'required',
        'description' => 'required|string',
        'car_type' => 'required',
        'car_id' => 'required|exists:cars,id',
        //'destinations' => 'required|array|min:1',
        'routes' => 'required|array|min:1',
    'routes.*.origin' => 'required|string',
    'routes.*.destination' => 'required|string',
    ]);

       $car = Car::with('driver')->findOrFail($request->car_id);
    $realCarType = $request->car_type;
    if ($request->car_type === 'vp') {
        $car = Car::findOrFail($request->car_id);
        $realCarType = $car->car_type;     }
    Log::info('📦 داده‌های دریافتی از فرم ایجاد ماموریت:', $request->all());

    
    $mission = Mission::create([
        'departure_date' => $request->departure_date,
        'departure_time' => $request->departure_time,
        'description' => $request->description,
        'car_type' =>  $realCarType,
        'car_id' => $request->car_id,
        'driver_id' => $car->driver_id,
        'status' => 'wait',
    ]);

       foreach ($request->routes as $index => $route) {
        $destination = Destination::where('origin', $route['origin'])
                                  ->where('destination', $route['destination'])
                                  ->first();
                                  
        if ($destination)
       {
            DestinationMission::create([
                'mission_id' => $mission->id,
                'destinations_id' => $destination->id,
                'order' => $index + 1,
            ]);
           
        }
    }

    return redirect()->back()->with('success', 'ماموریت با موفقیت ثبت شد.');
}
    

}
