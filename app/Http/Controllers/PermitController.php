<?php
namespace App\Http\Controllers;

use App\Models\Permit;
use App\Models\Driver;
use Illuminate\Http\Request;

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
    ]);

    $permit->update($request->only('issue_date', 'expiration_date', 'status'));

    return redirect()->route('permits.edit')->with('success', 'وضعیت پرمیت با موفقیت به‌روزرسانی شد.');
}



}
