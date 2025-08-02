<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mission;
use App\Models\DestinationMission;
use App\Models\Destination;
use App\Models\Driver;
use App\Models\Car;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CarController;

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
            'status_type' => 'required',
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
            $realCarType = $car->car_type;
        }
        Log::info('📦 داده‌های دریافتی از فرم ایجاد ماموریت:', $request->all());


        $mission = Mission::create([
            'departure_date' => $request->departure_date,
            'departure_time' => $request->departure_time,
            'description' => $request->description,
            'car_type' =>  $realCarType,
            'car_id' => $request->car_id,
            'driver_id' => $car->driver_id,
            'status' => $request->status_type,
        ]);

        foreach ($request->routes as $index => $route) {
            $destination = Destination::where('origin', $route['origin'])
                                      ->where('destination', $route['destination'])
                                      ->first();

            if ($destination) {
                DestinationMission::create([
                    'mission_id' => $mission->id,
                    'destinations_id' => $destination->id,
                    'order' => $index + 1,
                ]);

            }
        }

        return redirect()->back()->with('success', 'ماموریت با موفقیت ثبت شد.');
    }

    public function inprogress()
    {
        return view('missions.inprogress');
    }

    // app/Http/Controllers/MissionController.php



    public function showInProgress()
    {
        $missions = Mission::with(['car', 'destinations' => function ($query) {
            $query->orderBy('destination_mission.order');
        }])
        ->where('status', 'inprogress')
        ->orWhere(function ($query) {
            $query->whereNull('lounch_count')
                  ->whereNull('dinner_count')
                  ->whereNull('breakfasts_count')

                  ->whereNull('return_date')
                  ->whereNull('return_time')
                  ->whereNull('distonce');
        })
        ->get();
        //Log::info('📦 In-progress missions fetched:', $missions->toArray());
        return view('missions.inprogress', compact('missions'));
    }
    public function showInfinished()
    {
        $missions = Mission::with(['car', 'destinations' => function ($query) {
            $query->orderBy('destination_mission.order');
        }])
        ->where('status', 'finish')->get();


        //Log::info('📦 In-progress missions fetched:', $missions->toArray());
        return view('missions.finished', compact('missions'));
    }


    public function calculateDefaults(Request $request)
    {
        $request->validate([
            'mission_id' => 'required|exists:missions,id',
            'return_date' => 'required|date',
            'return_time' => 'required',
        ]);

        $mission = Mission::findOrFail($request->mission_id);
        $destinations = DestinationMission::with('destination')
        ->where('mission_id', $mission->id)
        ->orderBy('order')
        ->get();

        $totalDistance = 0;

        foreach ($destinations as $dm) {
            if ($dm->destination) {
                $totalDistance += $dm->destination->distonce ?? 0;
            }
        }
        $departure = Carbon::parse($mission->departure_date . ' ' . $mission->departure_time);
        $return = Carbon::parse($request->return_date . ' ' . $request->return_time);

        if ($return <= $departure) {
            return response()->json(['error' => 'تاریخ و ساعت بازگشت باید بعد از حرکت باشد.'], 422);
        }

        $breakfast = 0;
        $lunch = 0;
        $dinner = 0;


        $timeCheck = $departure->copy();

        // حلقه از حرکت تا برگشت
        while ($timeCheck->lessThanOrEqualTo($return)) {
            $currentDay = $timeCheck->copy()->startOfDay();

            // ساعت حرکت و برگشت در این روز
            $isFirstDay = $timeCheck->isSameDay($departure);
            $isLastDay = $timeCheck->isSameDay($return);

            if ($isFirstDay) {
                // روز اول: شرط‌ها با ساعت حرکت
                $depHour = $departure->hour;
                $retHour = $return->hour;

                // صبحانه
                if ($depHour < 6 && $return->greaterThanOrEqualTo($currentDay->copy()->hour(7))) {
                    $breakfast++;
                }
                // ناهار
                if ($depHour < 12 && $return->greaterThanOrEqualTo($currentDay->copy()->hour(13))) {
                    $lunch++;
                }
                // شام
                if ($depHour < 19 && $return->greaterThanOrEqualTo($currentDay->copy()->hour(20))) {
                    $dinner++;
                }



            } elseif ($isLastDay) {
                // روز آخر: شرط‌ها با ساعت برگشت
                $retHour = $return->hour;

                if ($retHour >= 7) {
                    $breakfast++;
                }
                if ($retHour >= 13) {
                    $lunch++;
                }
                if ($retHour >= 20) {
                    $dinner++;
                }

            } else {
                // روزهای میانی: همه وعده ها
                $breakfast++;
                $lunch++;
                $dinner++;

            }


            $timeCheck = $currentDay->addDay();
        }

        return response()->json([
            'breakfast_count' => $breakfast,
            'lunch_count' => $lunch,
            'dinner_count' => $dinner,
            'distance' => $totalDistance,

        ]);
    }

    public function endMission(Request $request)
    {
        $request->validate([
            'mission_id' => 'required|exists:missions,id',
            'return_date' => 'required|date',
            'return_time' => 'required',
            'distance' => 'required|numeric|min:0',
            'breakfast_count' => 'required|integer|min:0',
            'lunch_count' => 'required|integer|min:0',
            'dinner_count' => 'required|integer|min:0',
           'sleep_count' => 'required|integer|min:0',
        ]);

        $mission = Mission::findOrFail($request->mission_id);

        $mission->return_date = $request->return_date;
        $mission->return_time = $request->return_time;
        $mission->distonce = $request->distance;
        $mission->breakfasts_count = $request->breakfast_count;
        $mission->lounch_count = $request->lunch_count;
        $mission->dinner_count = $request->dinner_count;


        $mission->status = 'finish';

        $mission->save();

        return redirect()->back()->with('success', 'ماموریت با موفقیت به‌روزرسانی شد.');
    }



    public function edit($id)
    {

        $mission = Mission::findOrFail($id);
        Log::info('mission', [
            'id' => $mission->id,
            'distance' => $mission->distonce,
            'breakfast_count' => $mission->breakfasts_count,
            'lunch_count' => $mission->lounch_count,
            'dinner_count' => $mission->dinner_count,
            'sleep_count' => $mission->sleep_count,
        ]);
        return response()->json([
            'return_date' => $mission->return_date ,
            'return_time' => $mission->return_time,
            'distance' => $mission->distonce,
            'breakfast_count' => $mission->breakfasts_count,
            'lunch_count' => $mission->lounch_count,
            'dinner_count' => $mission->dinner_count,
            'sleep_count' => $mission->sleep_count,
        ]);
    }

    public function update(Request $request)
    {
        $mission = Mission::findOrFail($request->mission_id);

        $fields = [
            'return_date', 'return_time', 'distance',
            'breakfast_count', 'lunch_count',
            'dinner_count', 'sleep_count'
        ];

        $numericFields = [
            'distance', 'breakfast_count', 'lunch_count', 'dinner_count', 'sleep_count'
        ];

        $originalData = $mission->only($fields);
        $newData = $request->only($fields);

        // نرمال‌سازی null برای فیلدهای عددی
        foreach ($fields as $field) {
            if (in_array($field, $numericFields)) {
                $originalData[$field] = $originalData[$field] ?? 0;
                $newData[$field] = $newData[$field] ?? 0;
            }
        }

        $hasChange = false;
        foreach ($fields as $field) {
            if ($originalData[$field] != $newData[$field]) {
                $hasChange = true;
                break;
            }
        }

        // این قسمت اضافه شده تا واقعاً اطلاعات ذخیره شود
        if ($hasChange) {
            $mission->update([
                'return_date' => $request->return_date,
                'return_time' => $request->return_time,
                'distance' => $request->distance ?? 0,
                'breakfast_count' => $request->breakfast_count ?? 0,
                'lunch_count' => $request->lunch_count ?? 0,
                'dinner_count' => $request->dinner_count ?? 0,
                'sleep_count' => $request->sleep_count ?? 0,
            ]);
            Log::info('Session before redirect:', session()->all());

            return redirect()->route('missions.finished')
                ->with([
                    'success' => 'ماموریت با موفقیت ویرایش شد.',
                    'source' => 'finished_mission',
                ]);
        } else {
            return redirect()->route('missions.finished')
                ->with([
                    'info' => 'تغییری در اطلاعات انجام نشد.',
                    'source' => 'finished_mission',
                ]);
        }

    }
    public function showWaiting()
    {
        $missions = Mission::with(['car', 'destinations' => function ($query) {
            $query->orderBy('destination_mission.order');
        }])
        ->where('status', 'wait')
        ->get();

        return view('missions.wait', compact('missions'));
    }
    public function changeStatus(Request $request)
    {
        // اعتبارسنجی
        $request->validate([
            'mission_id' => 'required|exists:missions,id',
            'departure_date' => 'required|date',
            'departure_time' => 'required',
            'status_type' => 'required|in:inprogress,finish',
        ]);

        // دریافت ماموریت
        $mission = Mission::findOrFail($request->mission_id);

        // بروزرسانی فیلدها
        $mission->departure_date = $request->departure_date;
        $mission->departure_time = $request->departure_time;
        $mission->status = $request->status_type;

        // ذخیره در دیتابیس
        $mission->save();

        // بازگشت با پیام موفقیت
        return back()->with('success', 'وضعیت ماموریت با موفقیت تغییر یافت.');
    }

    public function cancel($id)
    {
        $mission = Mission::findOrFail($id);

        $mission->canceled = true;
        $mission->save();

        // آپدیت تمام مقصدها
        DB::table('destination_mission')
            ->where('mission_id', $id)
            ->update(['canceled' => true]);

        return response()->json(['success' => true]);
    }
    public function showLookupForm()
    {
        return view('missions.search');
    }
    public function performLookup(Request $request)
    {
        $plate = strtoupper(
            trim($request->car_plate_part1) .
            trim($request->car_plate_letter) .
            trim($request->car_plate_part2) .
            trim($request->car_plate_part3)
        );

        $car = Car::where('car_plate', $plate)->first();

        if (!$car) {
            return back()->with('error', 'خودرویی با این پلاک یافت نشد.');
        }

        $missionsQuery = Mission::with('destinations')->where('car_id', $car->id);

        // فیلتر بر اساس departure_date
        if ($request->filled('from_date')) {
            $missionsQuery->whereDate('departure_date', '>=', $request->from_date);
        }

        // فیلتر بر اساس return_date فقط اگر مقدار داشته باشه
        if ($request->filled('to_date')) {
            $missionsQuery->where(function ($query) use ($request) {
                $query->whereDate('return_date', '<=', $request->to_date)
                      ->orWhereNull('return_date');
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $missionsQuery->where('status', $request->status);
        }


        $missions = $missionsQuery->orderByDesc('departure_date')->get();

        return view('missions.search', compact('missions', 'car'));
    }


    public function priority()
    {
        return view('missions.priority');

    }
    public function getUniqueDestinations()
    {
        $uniqueDestinations = Destination::select('destination')
            ->distinct()
            ->orderBy('destination')
            ->pluck('destination');

        return response()->json($uniqueDestinations);
    }

    public function getCarPriority(Request $request)
    {
        $type = $request->input('car_type');
        $destination = $request->input('destination');

        Log::info('ورودی‌های متد getByType:', [
            'car_type' => $type,
            'destination' => $destination,
            'request_input' => $request->all()
        ]);

        // فراخوانی متد getByType در CarController
        $modifiedRequest = Request::create('/fake-url', 'GET', ['destination' => $destination]);
        $response = app(CarController::class)->getByType($type, $modifiedRequest);
        Log::info('پاسخ متد getByType:', ['status' => $response->status(), 'data' => $response->getData()]);
        // بررسی پاسخ
        if ($response->status() !== 200) {
            return response()->json(['error' => 'داده‌ای یافت نشد.'], 404);
        }


        return response()->json($response->getData());

    }



}
