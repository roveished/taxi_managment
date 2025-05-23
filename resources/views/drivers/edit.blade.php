<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش اطلاعات راننده</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    </header>

    <main class="flex-grow flex items-center justify-center p-6">
        <div class="bg-white shadow-lg rounded-2xl w-full max-w-md p-8">
            {{-- پیام‌ها --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded relative mb-4">
                    <strong>خطا در اعتبارسنجی:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- فرم جستجوی راننده --}}
            <form action="{{ route('drivers.search') }}" method="GET" class="space-y-4">
                <h2 class="text-xl font-bold text-center text-gray-800 mb-4">جستجوی راننده</h2>
                <div>
                    <label class="block text-gray-700">کد ملی راننده:</label>
                    <input type="text" name="national_id" placeholder="کد ملی را وارد کنید"
                           class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>
                <div class="pt-2">
                    <button type="submit"
                            class="w-full bg-blue-700 hover:bg-blue-800 text-white py-2 px-4 rounded-md transition">
                        جستجو
                    </button>
                </div>
            </form>

            {{-- فرم ویرایش در صورت یافت شدن راننده --}}
            @isset($driver)
                <form action="{{ route('drivers.update', $driver->id) }}" method="POST" class="space-y-4 mt-8">
                    @csrf
                    @method('PUT')
                    <h2 class="text-xl font-bold text-center text-gray-800 mb-4">ویرایش راننده</h2>

                    <div>
                        <label class="block text-gray-700">نام:</label>
                        <input type="text" name="name" value="{{ old('name', $driver->name) }}"
                               class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700">نام خانوادگی:</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $driver->last_name) }}"
                               class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700">شماره تلفن همراه:</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number', $driver->phone_number) }}"
                               class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700">کد ملی:</label>
                        <input type="text" name="national_id" value="{{ old('national_id', $driver->national_id) }}"
                               class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700">تاریخ تولد:</label>
                        <input type="date" name="date_of_birth" 
                               value="{{ old('date_of_birth', optional($driver->date_of_birth)->format('Y-m-d')) }}"
                               class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700">وضعیت:</label>
                        <select name="status"
                                class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="active" {{ old('status', $driver->status) == 'active' ? 'selected' : '' }}>فعال</option>
                            <option value="inactive" {{ old('status', $driver->status) == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                        </select>
                    </div>
                    <div class="pt-4">
                        <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md transition">
                            ویرایش راننده
                        </button>
                    </div>
                </form>
            @endisset
        </div>
    </main>

    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        <p>© 2025 شرکت نفت و گاز غرب - واحد چشمه خوش</p>
    </footer>
</body>
</html>
