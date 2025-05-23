<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
            <p class="text-lg mt-6 mb-6">به سامانه مدیریت خودرو های استیجاری واحد چشمه خوش خوش آمدید.</p>
        </div>
    </header>
    
    
    

    <!-- Navbar -->
    <nav class="flex justify-center bg-white py-4 transition-all duration-300 ease-in-out">
        <ul class="flex space-x-reverse space-x-20 text-black text-xl">
            <!-- ماموریت -->
            <li class="group relative cursor-pointer">
                <span class="hover:text-yellow-600 transition-colors duration-300">ماموریت</span>
                <ul class="absolute dropdown-menu bg-white text-black mt-2 rounded shadow-md min-w-max z-10 origin-top transform scale-y-0 opacity-0 group-hover:scale-y-100 group-hover:opacity-100">
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200">جدید</li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200">در جریان</li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200">خاتمه یافته</li>
                </ul>
            </li>
            <!-- خودرو -->
            <li class="group relative cursor-pointer">
                <span class="hover:text-yellow-600 transition-colors duration-300">خودرو</span>
                <ul class="absolute dropdown-menu bg-white text-black mt-2 rounded shadow-md min-w-max z-10 origin-top transform scale-y-0 opacity-0 group-hover:scale-y-100 group-hover:opacity-100">
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200">در ماموریت</li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200">حضور و غیاب</li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200">آماده کار</li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200">مرخصی</li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"> تعمیر</li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"><a href="{{ route('cars.create') }}">افزودن خودرو</a></li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"><a href="{{ route('cars.show') }}">نمایش اطلاعات خودروها</a></li>
                </ul>
            </li>
            <!-- مسیر -->
            <li class="group relative cursor-pointer">
                <span class="hover:text-yellow-600 transition-colors duration-300">مسیر</span>
                <ul class="absolute dropdown-menu bg-white text-black mt-2 rounded shadow-md min-w-max z-10 origin-top transform scale-y-0 opacity-0 group-hover:scale-y-100 group-hover:opacity-100">
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"><a href="{{ route('destination.create') }}">افزودن مسیر</a></li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"><a href="{{ route('destination.show') }}">نمایش مسیر ها</a></li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"><a href="{{ route('destination.edit') }}">ویرایش مسیر</a></li>
                </ul>
            </li>
            <!--رانندگان -->
            <li class="group relative cursor-pointer">
                <span class="hover:text-yellow-600 transition-colors duration-300">رانندگان</span>
                <ul class="absolute dropdown-menu bg-white text-black mt-2 rounded shadow-md min-w-max z-10 origin-top transform scale-y-0 opacity-0 group-hover:scale-y-100 group-hover:opacity-100">
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"> <a href="{{ route('drivers.create') }}">افزودن راننده</a></li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"> <a href="{{ route('drivers.active') }}">رانندگان فعال</a></li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"> <a href="{{ route('drivers.inactive') }}">رانندگان غیر فعال</a></li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"><a href="{{ route('drivers.search') }}">ویرایش اطلاعات</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- User Name Section -->
   

    <!-- Main Content Placeholder -->
    <main class="p-6 flex-grow">
        <p class="text-center text-gray-700">محتوای صفحه اصلی در این بخش نمایش داده می‌شود.</p>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        <p>© 2025 شرکت نفت و گاز غرب - واحد چشمه خوش</p>
    </footer>
</body>
</html>


