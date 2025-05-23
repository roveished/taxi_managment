<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>افزودن راننده</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-blue-900 text-white relative">
        <div class="flex justify-between items-center py-10 px-4">
            <!-- لوگو -->
            <div class="flex-shrink-0">
                <img src="{{ asset('main-logo.png') }}" alt="Logo" class="w-auto h-auto">
            </div>
        </div>
    
        <!-- اطلاعات کاربر -->
        <div class="absolute inset-0 flex flex-col justify-center items-center text-center">
            <h2 class="text-2xl font-bold text-white">
                {{ Auth::user()->name }} {{ Auth::user()->last_name }}
            </h2>
            <p class="text-lg mt-6 mb-6">به سامانه مدیریت خودرو های استیجاری واحد چشمه خوش خوش آمدید.</p>
        </div>
    </header>

    <!-- Main Form Content -->
    <main class="flex-grow flex items-center justify-center p-6">
       
        <div class="bg-white shadow-lg rounded-2xl w-full max-w-md p-8">
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

            <form action="{{ route('drivers.store') }}" method="POST" class="space-y-4">
                @csrf
                <h2 class="text-xl font-bold text-center text-gray-800 mb-4">افزودن راننده جدید</h2>

                <div>
                    <label class="block text-gray-700">نام :</label>
                    <input placeholder="لطفا نام را وارد کنید." type="text" name="name" class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700">نام خانوادگی :</label>
                    <input placeholder="لطفا نام خانوادگی را وارد کنید." type="text" name="last_name" class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700">شماره تلفن همراه :</label>
                    <input placeholder="لطفا شماره تلفن همراه را وارد کنید" type="text" name="phone_number" class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700">کد ملی :</label>
                    <input placeholder="لطفا کد ملی را وارد کنید." type="text" name="national_id" class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700">تاریخ تولد : </label>
                    <input type="date" name="date_of_birth" class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700">وضعیت :</label>
                    <select name="status" class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="active">فعال</option>
                        <option value="inactive">غیرفعال</option>
                    </select>
                </div>
                <div class="pt-4">
                    <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white py-2 px-4 rounded-md transition">ثبت راننده</button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        <p>© 2025 شرکت نفت و گاز غرب - واحد چشمه خوش</p>
    </footer>

</body>
</html>
