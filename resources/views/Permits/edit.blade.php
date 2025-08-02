<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش وضعیت پرمیت</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- ===== هدر ===== -->
    <header class="bg-blue-900 text-white relative">
        <div class="flex justify-between items-center py-10 px-4">
            <div class="flex-shrink-0">
                <img src="{{ asset('main-logo.png') }}" alt="Logo" class="w-auto h-auto">
            </div>
        </div>

        <div class="absolute inset-0 flex flex-col justify-center items-center text-center">
            <h2 class="text-2xl font-bold text-white">
                {{ Auth::user()->name ?? '' }} {{ Auth::user()->last_name ?? '' }}
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

    <!-- ===== محتوا ===== -->
    <main class="flex-grow flex justify-center items-center p-6">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-md">

            <h2 class="text-2xl font-bold mb-4 text-center">ویرایش وضعیت پرمیت</h2>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                @if (session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'موفقیت',
                        text: '{{ session('success') }}',
                        confirmButtonText: 'باشه'
                    });
                @endif

                @if ($errors->any())
                    let errorMessages = @json($errors->all());
                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        html: `<ul style="text-align: right; direction: rtl;">${errorMessages.map(e => `<li>${e}</li>`).join('')}</ul>`,
                        confirmButtonText: 'متوجه شدم'
                    });
                @endif
            </script>

            <!-- فرم جستجو -->
            @if (!isset($permit))
                <form method="POST" action="{{ route('permits.search') }}">
                    @csrf
                    <label class="block mb-2 font-semibold">کد ملی راننده:</label>
                    <input type="text" name="national_id" maxlength="10"
                        class="border border-gray-300 p-2 w-full rounded mb-4" required>
                    <button type="submit"
                        class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 w-full">جستجو</button>
                </form>
            @endif

            <!-- فرم ویرایش پرمیت -->
            @if (isset($permit))
                <div class="mb-4">
                    <p><strong>نام راننده:</strong> {{ $driver->name }} {{ $driver->last_name }}</p>
                    <p><strong>کد ملی:</strong> {{ $driver->national_id }}</p>
                </div>
                <form method="POST" action="{{ route('permits.update', $permit->id) }}">
                    @csrf

                    <label class="block mb-2 font-semibold">تاریخ صدور:</label>
                    <input type="date" name="issue_date" value="{{ $permit->issue_date }}"
                        class="border border-gray-300 p-2 w-full rounded mb-4" required>

                    <label class="block mb-2 font-semibold">تاریخ انقضا:</label>
                    <input type="date" name="expiration_date" value="{{ $permit->expiration_date }}"
                        class="border border-gray-300 p-2 w-full rounded mb-4" required>

                    <label class="block mb-2 font-semibold">وضعیت:</label>
                    <select name="status" class="border border-gray-300 p-2 w-full rounded mb-4">
                        <option value="valid" {{ $permit->status == 'valid' ? 'selected' : '' }}>معتبر</option>
                        <option value="invalid" {{ $permit->status == 'invalid' ? 'selected' : '' }}>نامعتبر</option>
                    </select>

                    <button type="submit"
                        class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 w-full">ذخیره
                        تغییرات</button>
                </form>
            @endif

        </div>
    </main>

    <!-- ===== فوتر ===== -->
    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        <p>© 2025 شرکت نفت و گاز غرب - واحد چشمه خوش</p>
    </footer>

</body>

</html>
