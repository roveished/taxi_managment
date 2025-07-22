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
</header>

<!-- ===== محتوا ===== -->
<main class="flex-grow flex justify-center items-center p-6">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">

        <h2 class="text-2xl font-bold mb-4 text-center">ویرایش وضعیت پرمیت</h2>

        <!-- پیام‌ها -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- فرم جستجو -->
        @if (!isset($permit))
            <form method="POST" action="{{ route('permits.search') }}">
                @csrf
                <label class="block mb-2 font-semibold">کد ملی راننده:</label>
                <input type="text" name="national_id" maxlength="10" class="border border-gray-300 p-2 w-full rounded mb-4" required>
                <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 w-full">جستجو</button>
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
                <input type="date" name="issue_date" value="{{ $permit->issue_date }}" class="border border-gray-300 p-2 w-full rounded mb-4" required>

                <label class="block mb-2 font-semibold">تاریخ انقضا:</label>
                <input type="date" name="expiration_date" value="{{ $permit->expiration_date }}" class="border border-gray-300 p-2 w-full rounded mb-4" required>

                <label class="block mb-2 font-semibold">وضعیت:</label>
                <select name="status" class="border border-gray-300 p-2 w-full rounded mb-4">
                    <option value="valid" {{ $permit->status == 'valid' ? 'selected' : '' }}>معتبر</option>
                    <option value="invalid" {{ $permit->status == 'invalid' ? 'selected' : '' }}>نامعتبر</option>
                </select>

                <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 w-full">ذخیره تغییرات</button>
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
