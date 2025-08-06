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
                <ul
                    class="absolute dropdown-menu bg-white text-black mt-2 rounded shadow-md min-w-max z-10 origin-top transform scale-y-0 opacity-0 group-hover:scale-y-100 group-hover:opacity-100">
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"> <a
                            href="{{ route('missions.create') }}"class="text-gray-700 hover:text-blue-600">جدید</a></li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"><a
                            href="{{ route('missions.inprogress') }}"class="text-gray-700 hover:text-blue-600">در
                            جریان</a></li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"><a
                            href="{{ route('missions.finished') }}"class="text-gray-700 hover:text-blue-600">خاتمه
                            یافته</a></li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"><a
                            href="{{ route('missions.waiting') }}"class="text-gray-700 hover:text-blue-600">در
                            انتظار</a></li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"> <a
                            href="{{ route('missions.lookup.form') }}"class="text-gray-700 hover:text-blue-600">جستجو</a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"> <a
                            href="{{ route('missions.priority') }}"class="text-gray-700 hover:text-blue-600">نوبت</a>
                    </li>

                </ul>
            </li>
            <!-- خودرو -->
            <li class="group relative cursor-pointer">
                <span class="hover:text-yellow-600 transition-colors duration-300">خودرو</span>
                <ul
                    class="absolute dropdown-menu bg-white text-black mt-2 rounded shadow-md min-w-max z-10 origin-top transform scale-y-0 opacity-0 group-hover:scale-y-100 group-hover:opacity-100">
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200">در ماموریت</li>
                    <li
                        class="px-4 py-2 hover:bg-gray-100 transition duration-200"class="text-gray-700 hover:text-blue-600">
                        <a href="{{ route('cars.attendance') }}">حضور و غیاب</a>
                    </li>
                    <li
                        class="px-4 py-2 hover:bg-gray-100 transition duration-200"class="text-gray-700 hover:text-blue-600">
                        <a href="{{ route('cars.active') }}" class="text-gray-700 hover:text-blue-600">آماده کار</a>
                    </li>

                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"><a
                            href="{{ route('cars.create') }}"class="text-gray-700 hover:text-blue-600">افزودن خودرو</a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"><a
                            href="{{ route('cars.show') }}"class="text-gray-700 hover:text-blue-600">نمایش اطلاعات
                            خودروها</a></li>
                    <li
                        class="px-4 py-2 hover:bg-gray-100 transition duration-200"class="text-gray-700 hover:text-blue-600">
                        <a href="{{ route('cars.attendance.edit') }}"class="text-gray-700 hover:text-blue-600">ویرایش
                            وضعیت حضور</a>
                    </li>
                    <li
                        class="px-4 py-2 hover:bg-gray-100 transition duration-200"class="text-gray-700 hover:text-blue-600">
                        <a href="{{ route('cars.needingInspection') }}"class="text-gray-700 hover:text-blue-600">خودروهای
                            نیازمند بازرسی</a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"><a
                            href="{{ route('driver.change.form') }}"class="text-gray-700 hover:text-blue-600">تغییر
                            راننده</a> </li>
                </ul>
            </li>
            <!-- مسیر -->
            <li class="group relative cursor-pointer">
                <span class="hover:text-yellow-600 transition-colors duration-300">مسیر</span>
                <ul
                    class="absolute dropdown-menu bg-white text-black mt-2 rounded shadow-md min-w-max z-10 origin-top transform scale-y-0 opacity-0 group-hover:scale-y-100 group-hover:opacity-100">
                    <li
                        class="px-4 py-2 hover:bg-gray-100 transition duration-200"class="text-gray-700 hover:text-blue-600">
                        <a href="{{ route('destination.create') }}"class="text-gray-700 hover:text-blue-600">افزودن
                            مسیر</a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"><a
                            href="{{ route('destination.show') }}"class="text-gray-700 hover:text-blue-600">نمایش/ویرایش</a>
                    </li>
                    <!-- <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"><a
                            href="{{ route('destination.edit') }}"class="text-gray-700 hover:text-blue-600">ویرایش مسیر</a></li>-->
                </ul>
            </li>
            <!--رانندگان -->
            <li class="group relative cursor-pointer">
                <span class="hover:text-yellow-600 transition-colors duration-300">رانندگان</span>
                <ul
                    class="absolute dropdown-menu bg-white text-black mt-2 rounded shadow-md min-w-max z-10 origin-top transform scale-y-0 opacity-0 group-hover:scale-y-100 group-hover:opacity-100">
                    <li
                        class="px-4 py-2 hover:bg-gray-100 transition duration-200"class="text-gray-700 hover:text-blue-600">
                        <a href="{{ route('drivers.create') }}"class="text-gray-700 hover:text-blue-600">افزودن
                            راننده</a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"> <a
                            href="{{ route('drivers.active') }}"class="text-gray-700 hover:text-blue-600">رانندگان
                            فعال</a></li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"> <a
                            href="{{ route('drivers.inactive') }}"class="text-gray-700 hover:text-blue-600">رانندگان
                            غیر فعال</a></li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"><a
                            href="{{ route('drivers.search') }}"class="text-gray-700 hover:text-blue-600">ویرایش
                            اطلاعات</a></li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"><a
                            href="{{ route('permits.edit') }}" class="text-gray-700 hover:text-blue-600">ویرایش وضعیت
                            پرمیت</a></li>
                    <li class="px-4 py-2 hover:bg-gray-100 transition duration-200"><a
                            href="{{ route('permits.status') }}" class="text-gray-700 hover:text-blue-600">وضعیت پرمیت
                            رانندگان</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <div class="flex justify-center mt-10">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-3xl text-center">
            <h3 class="text-xl font-semibold mb-4 text-blue-800">بررسی پرمیت‌های منقضی‌شده</h3>
            <button id="check-expired-btn"
                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                بررسی و غیرفعال‌سازی
            </button>

            <div id="expired-drivers" class="mt-6 hidden">
                <h4 class="text-lg font-bold text-gray-700 mb-3">رانندگان غیرفعال‌شده:</h4>
                <div class="space-y-4" id="driver-list"></div>
            </div>
        </div>
    </div>
    <div class="flex justify-center mt-10">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-3xl text-center">
            <h3 class="text-xl font-semibold mb-4 text-blue-800">بررسی بازرسی خودروها</h3>
            <button id="check-inspections-btn"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                بررسی و به‌روزرسانی
            </button>

            <div id="updated-cars" class="mt-6 hidden">
                <h4 class="text-lg font-bold text-gray-700 mb-3">خودروهای به‌روزرسانی‌شده:</h4>
                <div class="space-y-4" id="car-list"></div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('check-expired-btn').addEventListener('click', function() {
            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: 'در صورت وجود، تمام پرمیت‌های منقضی غیرفعال شده و رانندگان غیرفعال خواهند شد.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'بله، بررسی کن',
                cancelButtonText: 'لغو',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {

                    Swal.fire({
                        title: 'لطفا صبر کنید...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch("{{ route('permits.check-expired') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            const container = document.getElementById('expired-drivers');
                            const list = document.getElementById('driver-list');
                            list.innerHTML = '';
                            Swal.close();


                            if (data.length === 0) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'نتیجه',
                                    text: 'هیچ راننده‌ای برای غیرفعالسازی یافت نشد.',
                                    confirmButtonText: 'باشه'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'عملیات انجام شد',
                                    text: `${data.length} راننده غیرفعال شد.`,
                                    confirmButtonText: 'نمایش رانندگان'
                                });

                                let table = document.createElement('table');
                                table.className =
                                    "min-w-full bg-white border border-gray-300 text-right";

                                table.innerHTML = `
                                                         <thead class="bg-gray-200 text-gray-700 text-sm">
                                                                 <tr>
                                                                    <th class="py-2 px-4 border">ردیف</th>
                                                                   <th class="py-2 px-4 border">نام</th>
                                                                 <th class="py-2 px-4 border">نام خانوادگی</th>
                                                                        <th class="py-2 px-4 border">کد ملی</th>
                                                                         <th class="py-2 px-4 border">شماره تماس</th>
                                                                                     </tr>
                                                                                    </thead>
                                                                                         <tbody>
                                                                                 ${data.map((driver, index) => `
                                                                                                                                                                        <tr class="hover:bg-gray-50">
                                                                                                                                                                        <td class="py-2 px-4 border">${index + 1}</td>
                                                                                                                                                                                                <td class="py-2 px-4 border">${driver.name}</td>
                                                                                                                                                                       <td class="py-2 px-4 border">${driver.last_name}</td>
                                                                                                                                                                            <td class="py-2 px-4 border">${driver.national_id}</td>
                                                                                                                                                                                                <td class="py-2 px-4 border">${driver.phone_number}</td>
                                                                                                                                                            </tr>
                                                                                                                                                                             `).join('')}
                                                                                                   </tbody>
                                                                                            `;

                                list.appendChild(table);


                                container.classList.remove('hidden');
                            }
                        })
                        .catch(error => {
                            Swal.close();

                            Swal.fire({
                                icon: 'error',
                                title: 'خطا!',
                                text: 'در انجام عملیات مشکلی پیش آمد.',
                                confirmButtonText: 'باشه'
                            });
                            console.error(error);
                        });
                }
            });
        });
    </script>
    <script>
        document.getElementById('check-inspections-btn').addEventListener('click', function() {
            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: 'در صورت وجود، بازرسی‌های منقضی به invalid تغییر یافته و خودروهای مرتبط به active به‌روزرسانی خواهند شد.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'بله، بررسی کن',
                cancelButtonText: 'لغو',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'لطفا صبر کنید...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch("{{ route('inspections.check-expired') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            const container = document.getElementById('updated-cars');
                            const list = document.getElementById('car-list');
                            list.innerHTML = '';
                            Swal.close();

                            if (data.length === 0) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'نتیجه',
                                    text: 'هیچ بازرسی منقضی برای به‌روزرسانی یافت نشد.',
                                    confirmButtonText: 'باشه'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'عملیات انجام شد',
                                    text: `${data.length} خودرو به‌روزرسانی شد.`,
                                    confirmButtonText: 'نمایش خودروها'
                                });

                                let table = document.createElement('table');
                                table.className =
                                    "min-w-full bg-white border border-gray-300 text-right";

                                table.innerHTML = `
                            <thead class="bg-gray-200 text-gray-700 text-sm">
                                <tr>
                                    <th class="py-2 px-4 border">ردیف</th>
                                    <th class="py-2 px-4 border">پلاک خودرو</th>
                                    <th class="py-2 px-4 border">مدل خودرو</th>
                                    <th class="py-2 px-4 border">وضعیت</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.map((car, index) => `
                                                                                                    <tr class="hover:bg-gray-50">
                                                                                                        <td class="py-2 px-4 border">${index + 1}</td>
                                                                                                        <td class="py-2 px-4 border">${car.car_plate}</td>
                                                                                                        <td class="py-2 px-4 border">${car.car_model}</td>
                                                                                                        <td class="py-2 px-4 border">${car.status}</td>
                                                                                                    </tr>
                                                                                                `).join('')}
                            </tbody>
                        `;

                                list.appendChild(table);
                                container.classList.remove('hidden');
                            }
                        })
                        .catch(error => {
                            Swal.close();
                            Swal.fire({
                                icon: 'error',
                                title: 'خطا!',
                                text: 'در انجام عملیات مشکلی پیش آمد.',
                                confirmButtonText: 'باشه'
                            });
                            console.error(error);
                        });
                }
            });
        });
    </script>


    <!-- User Name Section -->


    <!-- Main Content Placeholder -->


    <!-- Footer -->
    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        <p>© 2025 شرکت نفت و گاز غرب - واحد چشمه خوش</p>
    </footer>

</body>


</html>
