<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use Illuminate\Support\Facades\Validator;

class DestinationController extends Controller
{
    public function create()
    {
        return view('destination.create');
    }

    /* public function store(Request $request)
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
     }*/
    /* public function store(Request $request)
{
     $validated = $request->validate([
         'origin' => 'required|string|max:255',
         'destination' => 'required|string|max:255',
         'distonce' => 'required|string|max:15',
     ]);

     try {
         $route = Destination::create($validated);

        
         if ($request->ajax()) {
             return response()->json([
                 'success' => true,
                 'message' => 'مسیر با موفقیت ثبت شد.',
                 'route' => $route
             ]);
         }

         // 🔑 اگر فرم معمولی بود:
         return redirect()->back()->with('success', 'مسیر با موفقیت ثبت شد.');

     } catch (\Exception $e) {
         if ($request->ajax()) {
             return response()->json([
                 'success' => false,
                 'message' => 'خطا در ثبت اطلاعات. دوباره تلاش کنید.',
                 'error' => $e->getMessage()
             ], 500);
         }

         return redirect()->back()->with('error', 'در ثبت اطلاعات مشکلی پیش آمد. لطفاً دوباره تلاش کنید.');
     }
}*/
    /*public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'distonce' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'اعتبارسنجی با خطا مواجه شد.',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $destination = Destination::create($validator->validated());

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'مسیر با موفقیت ثبت شد.',
                    'data' => $destination
                ]);
            }

            return redirect()->back()->with('success', 'مسیر با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در ثبت مسیر!',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'خطا در ثبت مسیر!');
        }
    }*/
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'origin' => 'required|string|max:255',
          'destination' => 'required|string|max:255',
          'distonce' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                  'success' => false,
                  'message' => 'اعتبارسنجی با خطا مواجه شد.',
                  'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

      
        $exists = Destination::where('origin', $request->origin)
                             ->where('destination', $request->destination)
                             ->exists();

        if ($exists) {
            if ($request->ajax()) {
                return response()->json([
                  'success' => false,
                  'message' => 'این مسیر قبلاً ثبت شده است!'
                ], 409); 
            }
            return redirect()->back()->with('error', 'این مسیر قبلاً ثبت شده است!')->withInput();
        }

        try {
            $destination = Destination::create($validator->validated());

            if ($request->ajax()) {
                return response()->json([
                  'success' => true,
                  'message' => 'مسیر با موفقیت ثبت شد.',
                  'data' => $destination
                ]);
            }

            return redirect()->back()->with('success', 'مسیر با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                  'success' => false,
                  'message' => 'خطا در ثبت مسیر!',
                  'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'خطا در ثبت مسیر!');
        }
    }


    public function getByOrigin($origin)
    {
        $destinations = Destination::where('origin', $origin)->get();
        return response()->json($destinations);
    }

    //////////////////////////////////////
    public function edit()
    {
        return view('destination.edit');
    }

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
  
    public function show()
    {
        $routes = Destination::all();
        return view('destination.show', compact('routes'));
    }


}
