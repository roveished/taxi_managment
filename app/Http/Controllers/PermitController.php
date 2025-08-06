<?php

namespace App\Http\Controllers;

use App\Models\Permit;
use App\Models\Driver;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PermitController extends Controller
{
    public function create($driver_id)
    {
        return view('drivers.permit', compact('driver_id'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'issue_date' => 'required|date',
            'expiration_date' => 'required|date|after_or_equal:issue_date',
            'status' => 'required|in:valid,invalid',
        ], [
            'expiration_date.after_or_equal' => 'تاریخ انقضا باید بعد از تاریخ صدور باشد.',
        ]);


        Permit::create($validated);


        return redirect()->route('drivers.create')->with('success', 'مجوز با موفقیت ثبت شد.');
    }
    public function editForm()
    {
        return view('permits.edit');
    }
    public function search(Request $request)
    {
        $request->validate([
            'national_id' => 'required|digits:10',
        ]);

        $driver = Driver::where('national_id', $request->national_id)->first();

        if (!$driver) {
            return back()->withErrors(['national_id' => 'راننده‌ای با این کد ملی یافت نشد.']);
        }

        $permit = Permit::where('driver_id', $driver->id)->first();

        if (!$permit) {
            return back()->withErrors(['permit' => 'پرمیتی برای این راننده یافت نشد.']);
        }

        return view('permits.edit', compact('driver', 'permit'));
    }
    public function update(Request $request, Permit $permit)
    {
        $request->validate([
            'issue_date' => 'required|date',
            'expiration_date' => 'required|date|after_or_equal:issue_date',
            'status' => 'required|in:valid,invalid',
        ], [
            'expiration_date.after_or_equal' => 'تاریخ انقضا باید بعد از تاریخ صدور باشد.',
        ]);

        $permit->update($request->only('issue_date', 'expiration_date', 'status'));
        if ($request->ajax()) {
            return response()->json(['message' => 'پرمیت با موفقیت بروزرسانی شد.']);
        } else {

            return redirect()->route('permits.edit')->with('success', 'وضعیت پرمیت با موفقیت به‌روزرسانی شد.');
        }
    }

    public function checkExpired(Request $request)
    {
        $now = Carbon::now();

        // گرفتن پرمیت‌های منقضی با وضعیت valid
        $expiredPermits = Permit::where('expiration_date', '<', $now)
        ->where('status', 'valid')
            ->get();

        // گرفتن آی‌دی رانندگان مرتبط (منحصربفرد)
        $driverIds = $expiredPermits->pluck('driver_id')->unique();

        // به‌روزرسانی وضعیت پرمیت‌ها به invalid
        Permit::whereIn('id', $expiredPermits->pluck('id'))->update(['status' => 'invalid']);

        // به‌روزرسانی وضعیت رانندگان به inactive
        Driver::whereIn('id', $driverIds)->update(['status' => 'inactive']);

        // گرفتن اطلاعات رانندگان برای نمایش
        $drivers = Driver::whereIn('id', $driverIds)
            ->get(['name', 'last_name', 'national_id', 'phone_number']);

        return response()->json($drivers);
    }
    public function status()
    {
        $permits = Permit::with('driver')->get();

        return view('permits.status', [
            'permits' => $permits,
        ]);
    }

}
