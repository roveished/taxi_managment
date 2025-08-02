<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Destination;
use App\Models\DestinationMission;
use Carbon\Carbon;

class CarController extends Controller
{
    public function create()
    {
        $drivers = Driver::all();
        return view('cars.create', compact('drivers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_plate_part1' => 'required|digits:2',
            'car_plate_letter' => 'required|alpha|size:1',
            'car_plate_part2' => 'required|digits:3',
            'car_plate_part3' => 'required|digits:2',
            'driver_id' => 'required|exists:drivers,id',
            'manufacture_year' => 'required|date',
            'car_model' => 'required|string|max:100',
            'car_type' => 'required|in:vip,passenger,truck',
            'status' => 'required|in:inmission,active,inactive',
            'collaboration_end_date' => 'nullable|date',
            'owner_name' => 'required|string|max:100',
            'owner_lsetname' => 'required|string|max:100',
            'owner_phonenumber' => 'required|string|max:20',
            'owner_nationl_id' => 'required|string|max:20',
        ]);


        $full_plate = $validated['car_plate_part1'] .
                      $validated['car_plate_letter'] .
                      $validated['car_plate_part2'] .
                      $validated['car_plate_part3'];


        Car::create([
            'car_plate' => $full_plate,
            'driver_id' => $validated['driver_id'],
            'manufacture_year' => $validated['manufacture_year'],
            'car_model' => $validated['car_model'],
            'car_type' => $validated['car_type'],
            'status' => $validated['status'],
            'collaboration_end_date' => $validated['collaboration_end_date'],
            'owner_name' => $validated['owner_name'],
            'owner_lsetname' => $validated['owner_lsetname'],
            'owner_phonenumber' => $validated['owner_phonenumber'],
            'owner_nationl_id' => $validated['owner_nationl_id'],
        ]);

        return redirect()->route('cars.create')->with('success', 'خودرو با موفقیت ثبت شد.');
    }

    public function show()
    {
        $routes = Car::with('driver')->get();
        return view('cars.show', compact('routes'));
    }
    public function attendance()
    {
        $routes = Car::with('driver')->get();
        return view('cars.AttendanceCar', compact('routes'));
    }


    public function getByType($type, Request $request)
    {

        $destinationName = $request->query('destination');
        //Log::info('پارامتر destination دریافت شد: ' . $destinationName);
        $destinations = Destination::where('destination', $destinationName)->get();
        //  Log::info('تعداد مقصدهای یافت شده:', ['count' => $destinations->count(), 'destination' => $destinationName]);
        if ($destinations->isEmpty()) {
            return response()->json(['error' => 'مقصدی یافت نشد.'], 404);
        }

        $destinationIds = $destinations->pluck('id');
        $destinationIds = $destinations->pluck('id');
        // Log::info('📌 لیست destination IDs:', ['ids' => $destinationIds->toArray()]);

        /* $cars = $type === 'vp'
             ? Car::whereIn('car_type', ['vip', 'passenger'])->get()
             : Car::where('car_type', $type)->get();*/
        $cars = $type === 'vp'
    ? Car::whereIn('car_type', ['vip', 'passenger'])->get()
    : (
        $type === 'all'
        ? Car::with('driver')->get()
        : Car::with('driver')->where('car_type', $type)->get()
    );

        /* Log::info('🚘 لیست پلاک خودروهای فیلترشده:', [
             'plates' => $cars->pluck('car_plate')->toArray()
         ]);*/
        $carPriorityList = [];

        foreach ($cars as $car) {
            $missions = \App\Models\Mission::where('car_id', $car->id)
                ->whereHas('destinations', function ($q) use ($destinationIds) {
                    $q->whereIn('destinations_id', $destinationIds);
                })
                ->orderByDesc('departure_date')
                ->orderByDesc('departure_time')
                ->get();
            /* Log::info("📄 مأموریت‌های خودرو {$car->car_plate} با مقصدهای مشخص:", $missions->map(function ($mission) {
                 return [
                     'id' => $mission->id,
                     'departure_date' => $mission->departure_date,
                     'departure_time' => $mission->departure_time,
                 ];
             })->toArray());*/
            $lastDateTime = Carbon::createFromFormat('Y-m-d H:i:s', '1900-01-01 00:00:00');

            if ($missions->isNotEmpty()) {
                $lastMission = $missions->first();
                /*  Log::info("📌 اولین مأموریت (جدیدترین) برای خودرو {$car->car_plate}:", [
                      'mission_id' => $lastMission->id,
                      'departure_date' => $lastMission->departure_date,
                      'departure_time' => $lastMission->departure_time,
                  ]);*/

                $date = $lastMission->departure_date;
                $time = $lastMission->departure_time;

                $lastDateTime = Carbon::parse("$date $time");
                /*Log::info("🕒 آخرین مأموریت خودرو {$car->car_plate}: ", [
                    'mission_id' => $lastMission->id,
                    'departure_date' => $date,
                    'departure_time' => $time,
                    'datetime' => $lastDateTime->toDateTimeString(),
                    'timestamp' => $lastDateTime->timestamp
                ]);*/
            }


            $carPriorityList[] = [
                'id' => $car->id,
                'car_plate' => $car->car_plate,
                'last_mission_to_destination' => $lastDateTime->toDateTimeString(),
                'driver' => optional($car->driver)->name . ' ' . optional($car->driver)->last_name,
             'owner_name' => $car->owner_name,
             'owner_lsetname' => $car->owner_lsetname,
                'timestamp' => $lastDateTime->timestamp, // برای مرتب‌سازی بهتر
            ];

            /*Log::info("📊 ثبت خودرو در لیست اولویت:", [
                'car_plate' => $car->car_plate,
                'last_mission_to_destination' => $lastDateTime->toDateTimeString(),
                'timestamp' => $lastDateTime->timestamp,
            ]);*/
        }


        usort($carPriorityList, function ($a, $b) {
            return $a['timestamp'] <=> $b['timestamp'];
        });


        $carPriorityList = array_map(function ($item) {
            unset($item['timestamp']);
            return $item;
        }, $carPriorityList);
        //  Log::info('🚗 Car priority list: ', $carPriorityList);
        return response()->json($carPriorityList);
    }





    public function getCarInfo($car_id)
    {
        $car = Car::with('driver')->find($car_id);

        if (!$car) {
            return response()->json(['success' => false, 'message' => 'خودرو یافت نشد.'], 404);
        }

        return response()->json([
            'success' => true,
            'car' => [
                'id' => $car->id,
                'car_model' => $car->car_model,
                'car_plate' => $car->car_plate,
                'owner_name' => $car->owner_name,
                'owner_lsetname' => $car->owner_lsetname,
                'owner_phonenumber' => $car->owner_phonenumber,
                'owner_nationl_id' => $car->owner_nationl_id,
                'driver_id' => $car->driver->id ?? null,
                'driver_name' => $car->driver ? $car->driver->name . ' ' . $car->driver->last_name : 'نامشخص',
            ]
        ]);
    }
    public function getAllDrivers()
    {
        $drivers = Driver::select('id', 'name', 'last_name')->get();
        return response()->json($drivers);
    }
    public function updateDriver(Request $request, Car $car)
    {
        $request->validate([
          'driver_id' => 'required|exists:drivers,id',
        ]);

        $car->driver_id = $request->driver_id;
        $car->save();

        return response()->json(['success' => true]);
    }


    public function searchByPlate(Request $request)
    {
        $plate = $request->query('plate'); // مثال: 12-B-345-67
        $normalized = str_replace('-', '', $plate); // نتیجه: 12B34567

        $car = Car::where('car_plate', $normalized)->first();

        if (!$car) {
            return response()->json([
                'success' => false,
                'message' => 'خودرو یافت نشد.'
            ]);
        }

        return response()->json([
            'success' => true,
            'model' => $car->car_model,
            'owner' => $car->owner_name . ' ' . $car->owner_lsetname
        ]);
    }





}
