<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ویرایش وضعیت حضور خودروها</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
<header class="bg-blue-900 text-white py-6 text-center text-2xl font-bold">
    ویرایش وضعیت حضور خودروها
</header>

<main class="p-6 flex-grow">
    <!-- فرم سرچ -->
    <form action="{{ route('car_working.search') }}" method="GET" class="mb-6 flex justify-center items-center gap-4">
        <label for="date" class="font-bold">تاریخ:</label>
        <input type="date" name="date" id="date" value="{{ $date ?? '' }}" class="border rounded-2xl p-2">
        <button type="submit" class="bg-blue-700 text-white py-2 px-4 rounded hover:bg-blue-800 transition">
            جستجو
        </button>
    </form>

    <!-- پیام -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded text-center">
            {{ session('success') }}
        </div>
    @endif

    @if(isset($message))
        <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded text-center">
            {{ $message }}
        </div>
    @endif

    <!-- جدول رکوردها -->
    @if(isset($records) && $records->count() > 0)
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
                                @if($record->driver)
                                    {{ $record->driver->name }} {{ $record->driver->last_name }}
                                @elseif($record->car && $record->car->driver)
                                    {{ $record->car->driver->name }} {{ $record->car->driver->last_name }}
                                @else
                                    نامشخص
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b text-center">
                                <select name="statuses[{{ $record->id }}]" class="border rounded-2xl p-1">
                                    <option value="present" {{ $record->work_status == 'present' ? 'selected' : '' }}>حضور</option>
                                    <option value="not_working" {{ $record->work_status == 'not_working' ? 'selected' : '' }}>عدم کارکرد</option>
                                    <option value="absent" {{ $record->work_status == 'absent' ? 'selected' : '' }}>غیبت</option>
                                    <option value="leave" {{ $record->work_status == 'leave' ? 'selected' : '' }}>مرخصی</option>
                                </select>
                                <input type="hidden" name="ids[]" value="{{ $record->id }}">
                            </td>
                            <td class="py-2 px-4 border-b text-center">
                                <input type="text" name="descriptions[{{ $record->id }}]"
                                       value="{{ $record->description }}" class="border rounded-2xl p-1 w-full text-center">
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
                <button type="submit" class="bg-blue-700 text-white py-2 px-6 rounded hover:bg-blue-800 transition">
                    ذخیره تغییرات
                </button>
            </div>
        </form>
    @endif
</main>

<footer class="bg-blue-900 text-white text-center py-4 mt-auto">
    © 2025 شرکت نفت و گاز غرب - واحد چشمه خوش
</footer>
</body>
</html>
