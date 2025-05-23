<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رانندگان فعال</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .dropdown-menu {
            transition: all 0.3s ease-in-out;
            transform-origin: top;
            transform: scaleY(0);
            opacity: 0;
        }
        .group:hover .dropdown-menu {
            transform: scaleY(1);
            opacity: 1;
        }
    </style>
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
            <p class="text-lg mt-6 mb-6">به سامانه مدیریت خودرو های استیجاری واحد چشمه خوش.</p>
        </div>
    </header>

    <!-- Navbar -->
    <nav class="flex justify-center bg-white py-4 transition-all duration-300 ease-in-out">
        <ul class="flex space-x-reverse space-x-20 text-black text-xl">
            <!-- این قسمت را مثل فایل اولت نگه دار -->
            ...
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="p-6 flex-grow">
        <h2 class="text-2xl font-bold text-center mb-4">لیست رانندگان فعال</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="py-2 px-4 border-b text-center align-middle">نام</th>
                        <th class="py-2 px-4 border-b text-center align-middle">نام خانوادگی</th>
                        <th class="py-2 px-4 border-b text-center align-middle">کد ملی</th>
                        <th class=" bg-gray-100 py-2 px-4 border-b text-center align-middle">وضعیت</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activeDrivers as $driver)
                        <tr>
                            <td class="py-2 px-4 border-b text-center align-middle">{{ $driver->name }}</td>
                            <td class="py-2 px-4 border-b text-center align-middle">{{ $driver->last_name }}</td>
                            <td class="py-2 px-4 border-b text-center align-middle">{{ $driver->national_id }}</td>
                            <td class="py-2 px-4 border-b text-center align-middle">{{ $driver->phone_number }}</td>
                            <td class="py-2 px-4 border-b text-green-600 font-bold text-center align-middle">{{ $driver->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        <p>© 2025 شرکت نفت و گاز غرب - واحد چشمه خوش</p>
    </footer>
</body>
</html>
