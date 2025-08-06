<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Car;
use Carbon\Carbon;

class DriverController extends Controller
{
    public function create()
    {
        return view('drivers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15|unique:drivers,phone_number',
            'national_id' => 'required|string|size:10|unique:drivers,national_id',
            'date_of_birth' => 'required|date',
            'status' => 'required|in:active,inactive',
        ], [
            'phone_number.unique' => 'شماره تلفن وارد شده قبلاً ثبت شده است.',
            'national_id.unique' => 'کد ملی وارد شده قبلاً ثبت شده است.',
        ]);
        $birthDate = Carbon::parse($validated['date_of_birth']);
        $age = $birthDate->age;
        if ($age < 18) {
            return redirect()->back()->withInput()->with('error', 'سن راننده باید حداقل ۱۸ سال باشد.');
        }

        try {
            $driver = Driver::create($validated);
            // Driver::create($validated);
            // return redirect()->back()->with('success', 'راننده با موفقیت ثبت شد.');
            return redirect()->back()
            ->with('success', 'راننده با موفقیت ثبت شد.')
            ->with('redirect_to', route('permits.create', ['driver_id' => $driver->id]));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'در ثبت اطلاعات مشکلی پیش آمد. لطفاً دوباره تلاش کنید.');
        }
    }

    public function search(Request $request)
    {
        $driver = null;

        if ($request->has('national_id')) {
            $request->validate([
                'national_id' => 'required|digits:10',
            ]);

            $driver = Driver::where('national_id', $request->national_id)->first();

            if (!$driver) {
                return view('drivers.edit')->with('error', 'راننده‌ای با این کد ملی یافت نشد.');
            }
        }

        return view('drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15|unique:drivers,phone_number',

            'date_of_birth' => 'required|date',
            'status' => 'required|in:active,inactive',
        ], [
            'phone_number.unique' => 'شماره تلفن برای راننده دیگری وارد شده است.',

        ]);

        $driver->update($request->only('name', 'last_name', 'phone_number', 'date_of_birth', 'status'));

        return redirect()->route('drivers.search', ['national_id' => $driver->national_id])
                         ->with('success', 'اطلاعات راننده با موفقیت به‌روزرسانی شد.');
    }

    public function active()
    {
        $activeDrivers = Driver::where('status', 'active')->get();
        return view('drivers.active', compact('activeDrivers'));
    }

    public function inactive()
    {
        $inactiveDrivers = Driver::where('status', 'inactive')->get();

        return view('drivers.inactive', compact('inactiveDrivers'));
    }


    // نمایش فرم جستجو
    public function showChangeDriverForm()
    {
        return view('drivers.change-driver');
    }

    // جستجوی خودرو با پلاک
    public function searchByPlate(Request $request)
    {
        $plate = $request->query('plate'); // مثال: 12B34567
        $normalized = str_replace('-', '', $plate);

        $car = Car::with('driver')->where('car_plate', $normalized)->first();

        if (!$car) {
            return response()->json([
                'success' => false,
                'message' => 'خودرو یافت نشد.'
            ]);
        }

        return response()->json([
            'success' => true,
            'model' => $car->car_model,
            'owner' => $car->owner_name . ' ' . $car->owner_lsetname,
            'driver_name' => $car->driver->name . ' ' . $car->driver->last_name,
            'car_id' => $car->id,
            'current_driver_id' => $car->driver_id
        ]);
    }

    // بروزرسانی راننده
    public function updateDriver(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'driver_id' => 'required|exists:drivers,id',
        ]);

        $car = Car::find($request->car_id);

        // اگر راننده جدید راننده خودرو دیگری است
        $existingCar = Car::where('driver_id', $request->driver_id)->first();

        if ($existingCar && $existingCar->id != $car->id) {
            return response()->json([
                'success' => false,
                'message' => 'راننده انتخابی، راننده خودروی دیگری است.'
            ]);
        }

        // تغییر راننده
        $car->driver_id = $request->driver_id;
        $car->save();

        return response()->json([
            'success' => true,
            'message' => 'راننده با موفقیت تغییر کرد.'
        ]);
    }

}
