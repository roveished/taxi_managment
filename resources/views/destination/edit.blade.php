<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ویرایش اطلاعات مسیر</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-blue-900 text-white relative">
        <div class="flex justify-between items-center py-10 px-4">
            <div class="flex-shrink-0">
                <img src="{{ asset('main-logo.png') }}" alt="Logo" class="w-auto h-auto" />
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

            {{-- فرم جستجوی مسیر --}}
            <form action="{{ route('destination.search') }}" method="GET" class="space-y-4">
                <h2 class="text-xl font-bold text-center text-gray-800 mb-4">جستجوی مسیر</h2>
                <div>
                    <label class="block text-gray-700">مبدا مسیر را وارد کنید :</label>
                    <input type="text" name="origin" placeholder="مبدا مسیر را وارد کنید"
                           class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>
                <div>
                    <label class="block text-gray-700">مقصد مسیر را وارد کنید :</label>
                    <input type="text" name="destination" placeholder="مقصد مسیر را وارد کنید"
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

            {{-- نمایش و فرم ویرایش مسیر در صورت یافتن --}}
            @isset($route)
                <div class="mt-8 bg-blue-50 p-4 rounded shadow">
                    <h2 class="text-lg font-bold text-blue-800 mb-4 text-center">ویرایش اطلاعات مسیر یافت شده</h2>

                    <form action="{{ route('destination.update', $route->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-gray-700">مبدا مسیر:</label>
                            <input type="text" name="origin" value="{{ old('origin', $route->origin) }}"
                                   class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-gray-700">مقصد مسیر:</label>
                            <input type="text" name="destination" value="{{ old('destination', $route->destination) }}"
                                   class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-gray-700">مسافت (کیلومتر):</label>
                            <input type="number" name="distonce" value="{{ old('distonce', $route->distonce) }}"
                                   class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required min="0">
                        </div>

                        <div>
                            <button type="submit"
                                    class="w-full bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-4 rounded-md transition">
                                به‌روزرسانی مسیر
                            </button>
                        </div>
                    </form>
                </div>
            @endisset

        </div>
    </main>

    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        <p>© 2025 شرکت نفت و گاز غرب - واحد چشمه خوش</p>
    </footer>

</body>
</html>
