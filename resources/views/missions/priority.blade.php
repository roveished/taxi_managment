<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>نوبت مأموریت‌ها</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-blue-900 text-white relative">
        <div class="flex justify-between items-center py-10 px-4">
            <img src="{{ asset('main-logo.png') }}" alt="Logo" class="w-auto h-auto" />
        </div>
        <div class="absolute inset-0 flex flex-col justify-center items-center text-center">
            <h2 class="text-2xl font-bold">{{ Auth::user()->name }} {{ Auth::user()->last_name }}</h2>
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

    <main class="flex-grow py-10 bg-gray-100">
        <div class="max-w-5xl mx-auto bg-white shadow rounded p-6 mt-10">
            <h1 class="text-2xl font-bold mb-6 text-center text-blue-800">جستجوی نوبت مأموریت‌ها</h1>

            <!-- فرم جستجو -->
            <form id="priorityForm" class="flex flex-col md:flex-row gap-4 mb-6">
                <!-- انتخاب مقصد -->
                <div class="flex-1">
                    <label for="destination" class="block mb-1 font-semibold">مقصد</label>
                    <select id="destination" name="destination" class="w-full p-2 border rounded">
                        <option value="">انتخاب کنید...</option>
                        {{-- پر می‌شود با جاوااسکریپت --}}
                    </select>
                </div>

                <!-- انتخاب نوع خودرو -->
                <div class="flex-1">
                    <label for="car_type" class="block mb-1 font-semibold">نوع کاربری خودرو</label>
                    <select id="car_type" name="car_type" class="w-full p-2 border rounded">
                        <option value="all">همه</option>
                        <option value="truck">وانت</option>
                        <option value="vip">تشریفاتی</option>
                        <option value="passenger">سواری</option>
                        <option value="vp">سواری/تشریفاتی</option>
                    </select>
                </div>

                <!-- دکمه جستجو -->
                <div class="flex items-end">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                        جستجو
                    </button>
                </div>
            </form>

            <!-- جدول نتایج -->
            <div id="resultsTable" class="overflow-x-auto hidden">
                <div class="overflow-x-auto bg-white rounded-lg shadow mt-6">
                    <table class="min-w-full table-auto text-sm text-center">
                        <thead class="bg-blue-800 text-white">
                            <tr>
                                <th class="px-4 py-3">ردیف</th>
                                <th class="px-4 py-3">شماره خودرو</th>
                                <th class="px-4 py-3">آخرین تاریخ رفتن</th>
                                <th class="px-4 py-3">نام مالک</th>
                                <th class="px-4 py-3">نام راننده</th>
                            </tr>
                        </thead>
                        <tbody id="priorityData">
                            {{-- پر می‌شود با JavaScript --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        <p>© 2025 شرکت نفت و گاز غرب - واحد چشمه خوش</p>
    </footer>

    <!-- دریافت مقاصد و پر کردن لیست مقصد -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch("{{ route('missions.unique-destinations') }}")
                .then(response => response.json())
                .then(destinations => {
                    const select = document.getElementById('destination');
                    destinations.forEach(dest => {
                        const option = document.createElement('option');
                        option.value = dest;
                        option.textContent = dest;
                        select.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error("خطا در دریافت مقاصد:", error);
                });
        });
    </script>

    <!-- ارسال فرم و دریافت لیست خودروها -->
    <script>
        document.getElementById('priorityForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const destination = document.getElementById('destination').value;
            const carType = document.getElementById('car_type').value;

            if (!destination || !carType) {
                alert('لطفا مقصد و نوع کاربری خودرو را انتخاب کنید.');
                return;
            }

            const resultsTable = document.getElementById('resultsTable');
            const tbody = document.getElementById('priorityData');

            resultsTable.classList.remove('hidden');
            tbody.innerHTML =
                `<tr><td class="border px-4 py-3 text-center" colspan="5">در حال دریافت اطلاعات...</td></tr>`;

            fetch("{{ route('missions.car-priority') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        destination: destination,
                        car_type: carType
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('خطا در دریافت اطلاعات');
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        tbody.innerHTML =
                            `<tr><td class="border px-4 py-3 text-center" colspan="5">${data.error}</td></tr>`;
                        return;
                    }

                    if (data.length === 0) {
                        tbody.innerHTML =
                            `<tr><td class="border px-4 py-3 text-center" colspan="5">هیچ داده‌ای یافت نشد.</td></tr>`;
                        return;
                    }

                    tbody.innerHTML = '';
                    data.forEach((item, index) => {
                        tbody.innerHTML += `
                            <tr class="${index % 2 === 0 ? 'bg-blue-50' : 'bg-white'} hover:bg-blue-100 transition">
                                <td class="px-4 py-2 font-bold text-gray-900">${index + 1}</td>
                                <td class="px-4 py-2 text-gray-800">${item.car_plate}</td>
                                <td class="px-4 py-2 text-gray-800"> ${item.last_mission_to_destination === '1900-01-01 00:00:00' ? '' : item.last_mission_to_destination}</td>
                                <td class="px-4 py-2 text-gray-800">${item.owner_name} ${item.owner_lsetname}</td>
                                <td class="px-4 py-2 text-gray-800">${item.driver ?? '-'}</td>
                            </tr>
                        `;
                    });
                })
                .catch(err => {
                    tbody.innerHTML =
                        `<tr><td class="border px-4 py-3 text-center" colspan="5">خطا در ارتباط با سرور</td></tr>`;
                    console.error(err);
                });
        });
    </script>
</body>

</html>
