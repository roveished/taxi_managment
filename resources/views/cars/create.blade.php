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

    <!-- Main -->
    <main class="flex-grow flex items-center justify-center p-6">
        <div class="bg-white shadow-lg rounded-2xl w-full max-w-2xl p-8">


            @if ($errors->any())
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded mb-4">
                    <strong>خطا:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cars.store') }}" method="POST" class="space-y-4">
                @csrf
                <h2 class="text-xl font-bold text-center text-gray-800 mb-4">افزودن خودرو جدید</h2>

                <!-- پلاک خودرو -->
                <div class="flex items-center gap-2">
                    <div class="w-16">
                        <input type="text" name="car_plate_part1" maxlength="2" placeholder="12"
                            class="text-center w-full p-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="w-20">
                        <select name="car_plate_letter" class="w-full p-2 border border-gray-300 rounded-md" required>
                            @foreach (range('A', 'Z') as $letter)
                                <option value="{{ $letter }}">{{ $letter }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-20">
                        <input type="text" name="car_plate_part2" maxlength="3" placeholder="345"
                            class="text-center w-full p-2 border border-gray-300 rounded-md" required>
                    </div>
                    <span class="font-bold text-lg px-2">ایران</span>
                    <div class="w-16">
                        <input type="text" name="car_plate_part3" maxlength="2" placeholder="67"
                            class="text-center w-full p-2 border border-gray-300 rounded-md" required>
                    </div>
                </div>

                <!-- سایر فیلدها -->
                <div>
                    <label class="block text-gray-700">مدل خودرو:</label>
                    <input type="text" name="car_model" class="w-full mt-1 p-2 border border-gray-300 rounded-md"
                        required>
                </div>
                <div>
                    <label class="block text-gray-700">نوع خودرو:</label>
                    <select name="car_type" class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                        <option value="vip">ویژه</option>
                        <option value="passenger">سواری</option>
                        <option value="truck">کامیون</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">وضعیت:</label>
                    <select name="status" class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                        <option value="inmission">در ماموریت</option>
                        <option value="active">فعال</option>
                        <option value="inactive">غیرفعال</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">تاریخ ساخت:</label>
                    <input type="date" name="manufacture_year"
                        class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-gray-700">تاریخ پایان همکاری:</label>
                    <input type="date" name="collaboration_end_date"
                        class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-gray-700">نام مالک:</label>
                    <input type="text" name="owner_name" class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-gray-700">نام خانوادگی مالک:</label>
                    <input type="text" name="owner_lsetname"
                        class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-gray-700">شماره تلفن مالک:</label>
                    <input type="text" name="owner_phonenumber"
                        class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-gray-700">کد ملی مالک:</label>
                    <input type="text" name="owner_nationl_id"
                        class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                </div>

                <!-- راننده -->
                <div>
                    <label class="block text-gray-700">انتخاب راننده:</label>
                    <select name="driver_id" class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                        @foreach ($drivers as $driver)
                            <option value="{{ $driver->id }}">{{ $driver->name }} {{ $driver->last_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-blue-700 hover:bg-blue-800 text-white py-2 px-4 rounded-md transition">ثبت
                        خودرو</button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        <p>© 2025 شرکت نفت و گاز غرب - واحد چشمه خوش</p>
    </footer>
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

</body>

</html>
