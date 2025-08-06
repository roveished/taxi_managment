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
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('car_working.store') }}" method="POST" onsubmit="return confirmSubmit(event)">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="py-2 px-4 border-b text-center">پلاک</th>
                            <th class="py-2 px-4 border-b text-center">نام خودرو</th>
                            <th class="py-2 px-4 border-b text-center">نام راننده</th>
                            <th class="py-2 px-4 border-b text-center">وضعیت حضور</th>
                            <th class="py-2 px-4 border-b text-center">توضیحات</th>
                            <th class="py-2 px-4 border-b text-center">تاریخ</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($routes as $route)
                            <tr>
                                <td class="py-2 px-4 border-b text-center">{{ $route->car_plate }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $route->car_model }}</td>
                                <td class="py-2 px-4 border-b text-center">
                                    {{ $route->driver ? $route->driver->name . ' ' . $route->driver->last_name : 'نامشخص' }}
                                </td>
                                <td class="py-2 px-4 border-b text-center">
                                    <div class="flex items-center justify-center gap-10">
                                        <select name="statuses[{{ $route->id }}]" class="border rounded-2xl p-1">
                                            <option value="present">حضور</option>
                                            <option value="not_working">عدم کارکرد</option>
                                            <option value="absent">غیبت</option>
                                            <option value="leave">مرخصی</option>
                                        </select>
                                        <input type="number" name="hours[{{ $route->id }}]" value="24"
                                            min="1" class="border rounded-2xl p-1 w-20" />
                                    </div>
                                <td class="py-2 px-4 border-b text-center">
                                    <input type="text" name="descriptions[{{ $route->id }}]"
                                        placeholder="توضیحات" class="border rounded-2xl p-1 w-full text-center" />
                                </td>
                                <td class="py-2 px-4 border-b text-center">
                                    <input type="date" name="dates[{{ $route->id }}]"
                                        value="{{ \Carbon\Carbon::now()->toDateString() }}"
                                        class="border rounded-2xl p-1 w-full" />
                                </td>

                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-500">هیچ خودرویی ثبت نشده است.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-6">
                <button type="submit" class="bg-blue-700 text-white py-2 px-6 rounded hover:bg-blue-800 transition">
                    ذخیره وضعیت حضور
                </button>
            </div>
        </form>
    </main>

    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        © 2025 شرکت نفت و گاز غرب - واحد چشمه خوش
    </footer>
    <script>
        function toggleInput(selectElement, id) {
            const input = document.getElementById('hours-input-' + id);
            if (selectElement.value === 'عدم کارکرد' || selectElement.value === 'غیبت') {
                input.classList.remove('hidden');
            } else {
                input.classList.add('hidden');
            }
        }
    </script>



    <script>
        function confirmSubmit(event) {
            event.preventDefault(); // جلوگیری از ارسال فرم به صورت پیش‌فرض

            Swal.fire({
                title: 'آیا مطمئن هستید که می‌خواهید وضعیت حضور را ثبت کنید؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'بله، ثبت کن',
                cancelButtonText: 'خیر، منصرف شدم',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit(); // اگر کاربر تأیید کرد، فرم ارسال شود
                }
            });

            return false; // جلوگیری از رفتار پیش‌فرض فرم
        }
    </script>

</body>
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'عملیات موفق',
            text: '{{ session('success') }}',
            confirmButtonText: 'باشه'
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'خطا',
            text: '{{ session('error') }}',
            confirmButtonText: 'باشه'
        });
    </script>
@endif

</html>
