<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>افزودن خودرو</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-blue-900 text-white relative">
        <div class="flex justify-between items-center py-10 px-4">
            <div class="flex-shrink-0">
                <img src="{{ asset('main-logo.png') }}" alt="Logo" class="w-auto h-auto">
            </div>
        </div>
        <div class="absolute inset-0 flex flex-col justify-center items-center text-center">
            <h2 class="text-2xl font-bold text-white">
                {{ Auth::user()->name }} {{ Auth::user()->last_name }}
            </h2>
            <p class="text-lg mt-6 mb-6">به سامانه مدیریت خودروهای استیجاری واحد چشمه خوش خوش آمدید.</p>
        </div>
        <a href="{{ route('home') }}"
            class="absolute bottom-4 left-4 bg-red-100 text-red-700 hover:bg-red-200 px-4 py-2 rounded-lg shadow-sm transition-all duration-300 text-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 22V12h6v10" />
            </svg>
            بازگشت به خانه
        </a>
    </header>


    <div class="flex justify-center mt-10">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-5xl text-center">
            <h3 class="text-xl font-semibold mb-6 text-blue-800">خودروهای آماده کار</h3>

            @if ($cars->isEmpty())
                <p class="text-gray-600">هیچ خودرویی با وضعیت <strong>active </strong> یافت نشد.</p>
            @else
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full table-auto text-sm text-center">
                    <thead class="bg-blue-800 text-white">
                        <tr>
                            <th class="px-4 py-3">ردیف</th>
                            <th class="px-4 py-3">شماره پلاک</th>
                            <th class="px-4 py-3">مدل خودرو</th>
                            <th class="px-4 py-3">نام راننده</th>
                            <th class="px-4 py-3">شماره تماس راننده</th>
                            <th class="px-4 py-3">نام مالک</th>
                            <th class="px-4 py-3">کاربری</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cars as $index => $car)
                            <tr class="{{ $loop->even ? 'bg-blue-50' : 'bg-white' }} border-b hover:bg-blue-100 transition">
                                <td class="px-4 py-2 text-gray-800">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 text-gray-800">{{ $car->car_plate }}</td>
                                <td class="px-4 py-2 text-gray-800">{{ $car->car_model }}</td>
                                <td class="px-4 py-2 text-gray-800">
                                    {{ $car->driver->name ?? '—' }} {{ $car->driver->last_name ?? '' }}
                                </td>
                                <td class="px-4 py-2 text-gray-800">{{ $car->driver->phone_number ?? '—' }}</td>
                                <td class="px-4 py-2 text-gray-800">{{ $car->owner_name }} {{ $car->owner_lsetname }}</td>
                                <td class="px-4 py-2 text-gray-800">
                                    @if ($car->car_type === 'passenger')
                                        سواری
                                    @elseif ($car->car_type === 'truck')
                                        وانت
                                    @elseif ($car->car_type === 'vip')
                                        تشریفاتی
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @endif
        </div>
    </div>


    <!-- Footer -->
    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        <p>© 2025 شرکت نفت و گاز غرب - واحد چشمه خوش</p>
    </footer>
</body>

</html>
