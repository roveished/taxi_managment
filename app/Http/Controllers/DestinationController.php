<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;

class DestinationController extends Controller
{
    public function create()
    {
        return view('destination.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'distonce' => 'required|string|max:15',
            
        ]);

        try {
            Destination::create($validated);
            return redirect()->back()->with('success', 'مسیر با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'در ثبت اطلاعات مشکلی پیش آمد. لطفاً دوباره تلاش کنید.');
        }
    }
    
    public function edit()
    {
        return view('destination.edit');
    }

    // جستجو بر اساس مبدا و مقصد
    public function search(Request $request)
    {
        $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
        ]);

        $route = Destination::where('origin', $request->origin)
            ->where('destination', $request->destination)
            ->first();

        if (!$route) {
            return redirect()->back()->with('error', 'مسیر با این مشخصات یافت نشد.');
        }

        return view('destination.edit', compact('route'));
    }

    //مبدا و مقصد به‌روزرسانی فاصله
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'distonce' => 'required|integer|min:0',
        ]);
    
        $route = Destination::findOrFail($id);
        $route->origin = $validated['origin'];
        $route->destination = $validated['destination'];
        $route->distonce = $validated['distonce'];
        $route->save();
    
        return redirect()->route('destination.edit')->with('success', 'اطلاعات مسیر با موفقیت به‌روزرسانی شد.');
    }
// نمایش همه مسیر ها
    public function show()
{
    $routes = Destination::all();
    return view('destination.show', compact('routes'));
}


}
