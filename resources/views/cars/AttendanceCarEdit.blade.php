<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>لیست مسیرها</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    <main class="p-6 flex-grow">
        <!-- فرم سرچ -->
        <form action="{{ route('car_working.search') }}" method="GET"
            class="mb-6 flex justify-center items-center gap-4">
            <label for="date" class="font-bold">تاریخ:</label>
            <input type="date" name="date" id="date" value="{{ $date ?? '' }}"
                class="border rounded-2xl p-2">
            <button type="submit" class="bg-blue-700 text-white py-2 px-4 rounded hover:bg-blue-800 transition">
                جستجو
            </button>
        </form>


        <!-- جدول رکوردها -->
        @if (isset($records) && $records->count() > 0)
            <form action="{{ route('car_working.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="py-2 px-4 border-b">پلاک</th>
                                <th class="py-2 px-4 border-b">نام خودرو</th>
                                <th class="py-2 px-4 border-b">نام راننده</th>
                                <th class="py-2 px-4 border-b">وضعیت</th>
                                <th class="py-2 px-4 border-b">توضیحات</th>
                                <th class="py-2 px-4 border-b">تاریخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $record)
                                <tr>
                                    <td class="py-2 px-4 border-b text-center">
                                        {{ $record->car ? $record->car->car_plate : 'نامشخص' }}
                                    </td>
                                    <td class="py-2 px-4 border-b text-center">
                                        {{ $record->car ? $record->car->car_model : 'نامشخص' }}
                                    </td>
                                    <td class="py-2 px-4 border-b text-center">
                                        @if ($record->driver)
                                            {{ $record->driver->name }} {{ $record->driver->last_name }}
                                        @elseif($record->car && $record->car->driver)
                                            {{ $record->car->driver->name }} {{ $record->car->driver->last_name }}
                                        @else
                                            نامشخص
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <select name="statuses[{{ $record->id }}]" class="border rounded-2xl p-1">
                                            <option value="present"
                                                {{ $record->work_status == 'present' ? 'selected' : '' }}>حضور</option>
                                            <option value="not_working"
                                                {{ $record->work_status == 'not_working' ? 'selected' : '' }}>عدم
                                                کارکرد</option>
                                            <option value="absent"
                                                {{ $record->work_status == 'absent' ? 'selected' : '' }}>غیبت</option>
                                            <option value="leave"
                                                {{ $record->work_status == 'leave' ? 'selected' : '' }}>مرخصی</option>
                                        </select>
                                        <input type="hidden" name="ids[]" value="{{ $record->id }}">
                                    </td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <input type="text" name="descriptions[{{ $record->id }}]"
                                            value="{{ $record->description }}"
                                            class="border rounded-2xl p-1 w-full text-center">
                                    </td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <input type="date" name="dates[{{ $record->id }}]"
                                            value="{{ $record->date ? $record->date->format('Y-m-d') : '' }}"
                                            class="border rounded-2xl p-1 w-full text-center">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-6">
                    <button type="submit"
                        class="bg-blue-700 text-white py-2 px-6 rounded hover:bg-blue-800 transition">
                        ذخیره تغییرات
                    </button>
                </div>
            </form>
        @endif
    </main>

    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        © 2025 شرکت نفت و گاز غرب - واحد چشمه خوش
    </footer>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'موفقیت',
                text: '{{ session('success') }}',
                confirmButtonText: 'باشه'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'خطا',
                text: '{{ session('error') }}',
                confirmButtonText: 'باشه'
            });
        @endif

        @if (isset($message))
            Swal.fire({
                icon: 'warning',
                title: 'پیام',
                text: '{{ $message }}',
                confirmButtonText: 'باشه'
            });
        @endif
    </script>

</body>

</html>
