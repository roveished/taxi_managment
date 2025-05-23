<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Driver;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * نمایش فرم افزودن خودرو
     */
    public function create()
    {
        $drivers = Driver::all();
        return view('cars.create', compact('drivers'));
    }

    /**
     * ذخیره اطلاعات خودرو در پایگاه داده
     */
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

        // ترکیب کردن پلاک
        $full_plate = $validated['car_plate_part1'] . 
                      $validated['car_plate_letter'] . 
                      $validated['car_plate_part2'] . 
                      
                      $validated['car_plate_part3'];

        // ایجاد رکورد خودرو
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
        $routes = Car::all();
        return view('cars.show', compact('routes'));
    }
}
