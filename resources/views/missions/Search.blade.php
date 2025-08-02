<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>جستجوی ماموریت‌ها</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    <main class="container mx-auto px-4 py-6 flex-grow">

        {{-- پیام خطا --}}
        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded mb-6 text-center">
                {{ session('error') }}
            </div>
        @endif

        {{-- فرم جستجو --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-8 max-w-3xl mx-auto">
            <h3 class="text-xl font-bold mb-4">جستجوی ماموریت</h3>

            <form action="{{ route('missions.lookup.submit') }}" method="POST" class="space-y-6">
                @csrf

                {{-- پلاک --}}
                <label class="block font-semibold text-gray-700">پلاک خودرو:</label>
                <div class="flex items-center gap-2 mb-4 justify-center">
                    <div class="w-16">
                        <input type="text" name="car_plate_part1" maxlength="2" placeholder="12"
                            class="text-center w-full p-2 border border-gray-300 rounded-md" required
                            value="{{ old('car_plate_part1') }}">
                    </div>
                    <div class="w-20">
                        <select name="car_plate_letter" class="w-full p-2 border border-gray-300 rounded-md" required>
                            @foreach (range('A', 'Z') as $letter)
                                <option value="{{ $letter }}" @if (old('car_plate_letter') == $letter) selected @endif>
                                    {{ $letter }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-20">
                        <input type="text" name="car_plate_part2" maxlength="3" placeholder="345"
                            class="text-center w-full p-2 border border-gray-300 rounded-md" required
                            value="{{ old('car_plate_part2') }}">
                    </div>
                    <span class="font-bold text-lg px-2">ایران</span>
                    <div class="w-16">
                        <input type="text" name="car_plate_part3" maxlength="2" placeholder="67"
                            class="text-center w-full p-2 border border-gray-300 rounded-md" required
                            value="{{ old('car_plate_part3') }}">
                    </div>
                </div>

                {{-- از تاریخ --}}
                <div class="flex items-center gap-6 justify-center">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1" for="from_date">از تاریخ:</label>
                        <input type="date" id="from_date" name="from_date"
                            class="p-2 border border-gray-300 rounded-md" value="{{ old('from_date') }}">
                    </div>

                    {{-- تا تاریخ --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1" for="to_date">تا تاریخ:</label>
                        <input type="date" id="to_date" name="to_date"
                            class="p-2 border border-gray-300 rounded-md" value="{{ old('to_date') }}">
                    </div>
                </div>

                {{-- وضعیت ماموریت --}}
                <div class="mt-4 max-w-xs mx-auto">
                    <label class="block font-semibold text-gray-700 mb-1" for="status">وضعیت ماموریت:</label>
                    <select name="status" id="status" class="w-full p-2 border border-gray-300 rounded-md">
                        <option value="all">همه</option>
                        <option value="inprogress" @if (old('status') == 'inprogress') selected @endif>در جریان</option>
                        <option value="wait" @if (old('status') == 'wait') selected @endif>در انتظار</option>
                        <option value="finish" @if (old('status') == 'finish') selected @endif>خاتمه یافته</option>
                    </select>
                </div>

                {{-- دکمه جستجو --}}
                <div class="mt-6 text-center">
                    <button type="submit"
                        class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-2 rounded-md transition-colors duration-300">
                        جستجو
                    </button>
                </div>
            </form>
        </div>

        {{-- نمایش نتایج ماموریت اگر وجود داشته باشد --}}
        @isset($missions)
            <div class="max-w-7xl mx-auto">
                @if ($missions->isEmpty())
                    <p class="text-center text-gray-600">هیچ ماموریتی یافت نشد.</p>
                @else
                    <div class="overflow-x-auto bg-white rounded-lg shadow">
                        <table class="min-w-full table-auto text-sm text-center">
                            <thead class="bg-blue-800 text-white">
                                <tr>
                                    <th class="px-4 py-3">پلاک خودرو</th>
                                    <th class="px-4 py-3">مبدا</th>
                                    <th class="px-4 py-3">مقاصد</th>
                                    <th class="px-4 py-3">تاریخ حرکت</th>
                                    <th class="px-4 py-3">ساعت حرکت</th>
                                    <th class="px-4 py-3">تاریخ برگشت</th>
                                    <th class="px-4 py-3">ساعت برگشت</th>
                                    <th class="px-4 py-3">وضعیت</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($missions as $mission)
                                    <tr
                                        class="{{ $loop->even ? 'bg-blue-50' : 'bg-white' }} border-b hover:bg-blue-100 transition">
                                        <td class="px-4 py-2 font-bold text-gray-900">{{ $mission->car->car_plate }}</td>
                                        <td class="px-4 py-2 text-gray-800">
                                            {{ $mission->destinations->first()->origin ?? '---' }}</td>
                                        <td class="px-4 py-2 text-gray-800">
                                            @foreach ($mission->destinations as $destination)
                                                <div>{{ $destination->destination }}</div>
                                            @endforeach
                                        </td>
                                        <td class="px-4 py-2 text-gray-800">{{ $mission->departure_date }}</td>
                                        <td class="px-4 py-2 text-gray-800">
                                            {{ \Carbon\Carbon::parse($mission->departure_time)->format('H:i') }}</td>
                                        <td class="px-4 py-2 text-gray-800">{{ $mission->return_date }}</td>
                                        <td class="px-4 py-2 text-gray-800">
                                            {{ \Carbon\Carbon::parse($mission->return_time)->format('H:i') }}</td>
                                        <td class="px-4 py-2 text-gray-800">
                                            @switch($mission->status)
                                                @case('wait')
                                                    در انتظار
                                                @break

                                                @case('inprogress')
                                                    در حال انجام
                                                @break

                                                @case('finish')
                                                    خاتمه یافته
                                                @break

                                                @default
                                                    {{ $mission->status }}
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endisset


    </main>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        <p>© 2025 شرکت نفت و گاز غرب - واحد چشمه خوش</p>
    </footer>

</body>

</html>
