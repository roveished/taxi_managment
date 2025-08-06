<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>لیست خودروها</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-blue-900 text-white relative">
        <div class="flex justify-between items-center py-10 px-4">
            <img src="{{ asset('main-logo.png') }}" alt="Logo" class="w-auto h-auto" />
        </div>
        <div class="absolute inset-0 flex flex-col justify-center items-center text-center">
            <h2 class="text-2xl font-bold">{{ Auth::user()->name }} {{ Auth::user()->last_name }}</h2>
            <p class="text-lg mt-6 mb-6">به سامانه مدیریت خودرو های استیجاری واحد چشمه خوش خوش آمدید.</p>
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

    <!-- Main -->
    <main class="flex-grow flex justify-center items-center py-10 bg-gray-100">
        <div class="bg-white shadow-lg rounded-3xl p-8 w-full max-w-screen-xl border border-gray-300">
            <h2 class="text-3xl font-extrabold mb-8 text-center text-blue-800 tracking-wide">لیست خودروهای ثبت‌شده</h2>

            @if ($routes->isEmpty())
                <p class="text-center text-gray-600">هیچ خودرویی ثبت نشده است.</p>
            @else
                <div class="overflow-x-auto bg-white rounded-lg shadow">
                    <table class="min-w-full table-auto text-sm text-center">
                        <thead class="bg-blue-800 text-white">
                            <tr>
                                <th class="px-4 py-3">تاریخ ساخت</th>
                                <th class="px-4 py-3">نام مالک</th>
                                <th class="px-4 py-3">نام خانوادگی مالک</th>
                                <th class="px-4 py-3">شماره تماس</th>
                                <th class="px-4 py-3">پلاک</th>
                                <th class="px-4 py-3">نام خودرو</th>
                                <th class="px-4 py-3">وضعیت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($routes as $route)
                                <tr
                                    class="{{ $loop->even ? 'bg-blue-50' : 'bg-white' }} border-b hover:bg-blue-100 transition">
                                    <td class="px-4 py-2 text-gray-800">
                                        {{ $route->manufacture_year->format('Y/m/d') }}</td>
                                    <td class="px-4 py-2 text-gray-800">{{ $route->owner_name }}</td>
                                    <td class="px-4 py-2 text-gray-800">{{ $route->owner_lsetname }}</td>
                                    <td class="px-4 py-2 text-gray-800">{{ $route->owner_phonenumber }}</td>
                                    <td class="px-4 py-2 text-gray-800">{{ $route->car_plate }}</td>
                                    <td class="px-4 py-2 text-gray-800">{{ $route->car_model }}</td>
                                    <td
                                        class="px-4 py-2 font-bold 
    {{ $route->status == 'active'
        ? 'text-green-600'
        : ($route->status == 'inactive'
            ? 'text-red-500'
            : ($route->status == 'inmission'
                ? 'text-blue-600'
                : 'text-gray-500')) }}">

                                        {{ $route->status == 'active'
                                            ? 'فعال'
                                            : ($route->status == 'inactive'
                                                ? 'غیرفعال'
                                                : ($route->status == 'inmission'
                                                    ? 'در مأموریت'
                                                    : 'نامشخص')) }}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        <p>© 2025 شرکت نفت و گاز غرب - واحد چشمه خوش</p>
    </footer>

</body>

</html>
