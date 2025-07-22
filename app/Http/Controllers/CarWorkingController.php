<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarWorking;
use App\Models\Car;

class CarWorkingController extends Controller
{
    public function store(Request $request)
    {
        $statuses = $request->input('statuses', []);
        $hours = $request->input('hours', []);
        $descriptions = $request->input('descriptions', []);
        $dates = $request->input('dates', []);

        $errors = [];

        foreach ($statuses as $car_id => $status) {
            $date = $dates[$car_id] ?? now()->toDateString();

            $exists = CarWorking::where('car_id', $car_id)
                ->where('date', $date)
                ->exists();

            if ($exists) {
                $car = Car::find($car_id);
                $errors[] = "برای خودرو با پلاک " . ($car->car_plate ?? "نامشخص") . " در تاریخ $date وضعیت ثبت شده است.";
            }
        }

        if (count($errors) > 0) {
            return redirect()->back()->withErrors($errors);
        }

        foreach ($statuses as $car_id => $status) {
            $date = $dates[$car_id] ?? now()->toDateString();

            $car = Car::with('driver')->find($car_id);
            if (!$car) continue;

            CarWorking::create([
                'car_id' => $car->id,
                'driver_id' => $car->driver ? $car->driver->id : null,
                'work_status' => $status,
                'hours_number' => $hours[$car_id] ?? null,
                'description' => $descriptions[$car_id] ?? null,
                'date' => $date,
            ]);
        }

        return redirect()->back()->with('success', 'وضعیت حضور خودروها ثبت شد.');
    }

    public function editAttendance()
    {
        return view('cars.AttendanceCarEdit');
    }

    public function search(Request $request)
    {
        $date = $request->input('date');

        if (!$date) {
            return view('cars.AttendanceCarEdit')->with('message', 'لطفاً تاریخ را انتخاب کنید.');
        }

               $records = CarWorking::with(['car.driver', 'driver'])
            ->where('date', $date)
            ->get();

        if ($records->isEmpty()) {
            return view('cars.AttendanceCarEdit')->with('message', 'اطلاعاتی برای این تاریخ وجود ندارد.');
        }

        return view('cars.AttendanceCarEdit', compact('records', 'date'));
    }

    public function update(Request $request)
    {
        $ids = $request->input('ids', []);
        $statuses = $request->input('statuses', []);
        $descriptions = $request->input('descriptions', []);
        $dates = $request->input('dates', []);

        foreach ($ids as $id) {
            $record = CarWorking::find($id);
            if ($record) {
                $record->update([
                    'work_status' => $statuses[$id] ?? $record->work_status,
                    'description' => $descriptions[$id] ?? $record->description,
                    'date' => $dates[$id] ?? $record->date,
                ]);
            }
        }

        return redirect()->back()->with('success', 'اطلاعات با موفقیت به‌روزرسانی شد.');
    }
}
