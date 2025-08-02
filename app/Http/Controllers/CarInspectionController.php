<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarInspection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CarInspectionController extends Controller
{
    public function store(Request $request)
    {


        Log::info("Request payload", $request->all());
        $username = Auth::id();
        $user = User::where('username', $username)->first();
        if ($user) {
            $userId = $user->id;
        } else {

            $userId = null;
            return back()->withErrors([' ایدی با این مشخصات یافت نشد']);
        }
        $car = Car::where('car_plate', $request->car_plate)->first();

        if (!$car) {
            return back()->withErrors(['car_plate' => 'خودرویی با این پلاک پیدا نشد']);
        }
        Log::info("خودرو با پلاک {$request->car_plate} پیدا شد: شناسه خودرو {$car->id}");

        CarInspection::create([
            'car_id' => $car->id,
            'driver_id' => $car->driver_id,
            'inspection_date' => now(),
            'expiration_date' => $request->expiration_date,
            'status' => $request->status,
            'description' => $request->description,
            'user_id' =>  $userId,
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


    public function checkAndUpdateExpiredInspections(Request $request)
    {
        // فقط تاریخ امروز (مثلا '2025-08-01')
        $now = Carbon::now()->toDateString();

        $carIds = Car::pluck('id');
        $expiredInspections = collect();

        foreach ($carIds as $carId) {
            $lastInspection = CarInspection::where('car_id', $carId)
                ->orderBy('inspection_date', 'desc')
                ->first();

            if ($lastInspection) {
                // expiration_date به صورت 'YYYY-MM-DD'
                $expirationDate = $lastInspection->expiration_date;

                // اگر وضعیت valid است و تاریخ انقضا کمتر از امروز است
                if ($lastInspection->status == 'valid' && $expirationDate < $now) {
                    $expiredInspections->push($lastInspection);
                }
            }
        }

        if ($expiredInspections->isEmpty()) {
            return response()->json([]);
        }

        // به‌روزرسانی وضعیت بازرسی‌ها به invalid
        foreach ($expiredInspections as $inspection) {
            $inspection->status = 'invalid';
            $inspection->save();
        }

        // گرفتن شناسه خودروهای منقضی شده
        $expiredCarIds = $expiredInspections->pluck('car_id')->unique();

        // به‌روزرسانی وضعیت خودروها به inactive
        Car::whereIn('id', $expiredCarIds)->update(['status' => 'inactive']);

        // گرفتن اطلاعات خودروها برای ارسال به کلاینت
        $updatedCars = Car::whereIn('id', $expiredCarIds)->get(['car_plate', 'car_model', 'status']);

        return response()->json($updatedCars);
    }

    public function carsNeedingInspection()
    {
        // 1. گرفتن همه بازرسی‌های invalid مرتب شده بر اساس تاریخ انقضا به صورت نزولی (جدیدترین اول)
        $invalidInspections = CarInspection::where('status', 'invalid')
            ->orderBy('expiration_date', 'desc')
            ->get();

        // 2. گروه‌بندی بر اساس car_id و گرفتن اولین (یعنی جدیدترین) بازرسی هر خودرو
        $latestInspections = $invalidInspections->groupBy('car_id')->map(function ($inspections) {
            return $inspections->first();
        });

        // 3. حالا اطلاعات خودروها را بارگذاری می‌کنیم
        $latestInspections->load('car');

        // 4. آماده‌سازی آرایه داده برای ارسال به ویو
        $data = $latestInspections->map(function ($inspection) {
    $car = $inspection->car;

    return [
        'car_plate' => $car ? $car->car_plate : 'نامشخص',
        'owner_name' => $car ? $car->owner_name : 'نامشخص',
        'owner_last_name' => $car ? $car->owner_lsetname : 'نامشخص',
        'owner_phone' => $car ? $car->owner_phonenumber : 'نامشخص',
        'expiration_date' => $inspection->expiration_date,
    ];
});


        return view('cars.inspection-needed', ['cars' => $data]);
    }



}
