<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
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
            'phone_number' => 'required|string|max:15',
            'national_id' => 'required|string|size:10',
            'date_of_birth' => 'required|date',
            'status' => 'required|in:active,inactive',
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
        $request->validate([
            'name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'required|string',
            'date_of_birth' => 'required|date',
            'status' => 'required|in:active,inactive',
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

}
