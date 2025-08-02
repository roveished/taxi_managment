<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ماموریت های در انتظار</title>
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
            <p class="text-lg mt-6 mb-6">به سامانه مدیریت خودرو های استیجاری واحد چشمه خوش خوش آمدید.</p>
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

    <main class="flex-grow flex justify-center items-center py-10 bg-gray-100 min-h-screen">
        <div class="bg-white shadow-lg rounded-3xl p-8 w-full max-w-screen-xl border border-gray-300">

            <h2 class="text-3xl font-extrabold mb-8 text-center text-blue-800 tracking-wide">ماموریت‌های در حال انتظار
            </h2>

            @isset($missions)
                <div class="max-w-7xl mx-auto">
                    @if ($missions->isEmpty())
                        <p class="text-center text-gray-600">هیچ ماموریتی یافت نشد.</p>
                    @else
                        <div class="overflow-x-auto bg-white rounded-lg shadow">
                            <table class="min-w-full table-auto text-sm text-center">
                                <thead class="bg-blue-800 text-white">
                                    <tr>
                                        <th class="px-4 py-3">پلاک خودرو</th>
                                        <th class="px-4 py-3">مبدا</th>
                                        <th class="px-4 py-3">مقاصد</th>
                                        <th class="px-4 py-3">تاریخ حرکت</th>
                                        <th class="px-4 py-3">ساعت حرکت</th>
                                        <th class="px-4 py-3">تغییر وضغیت</th>
                                        <th class="px-4 py-3">کنسل کردن</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($missions as $mission)
                                        <tr
                                            class="{{ $loop->even ? 'bg-blue-50' : 'bg-white' }} border-b hover:bg-blue-100 transition">
                                            <td class="px-4 py-2 font-bold text-gray-900">{{ $mission->car->car_plate }}
                                            </td>
                                            <td class="px-4 py-2 text-gray-800">
                                                {{ $mission->destinations->first()->origin ?? '---' }}</td>
                                            <td class="px-4 py-2 text-gray-800">
                                                @foreach ($mission->destinations as $destination)
                                                    <div>{{ $destination->destination }}</div>
                                                @endforeach
                                            </td>
                                            <td class="px-4 py-2 text-gray-800">{{ $mission->departure_date }}</td>
                                            <td class="px-4 py-2 text-gray-800">
                                                {{ \Carbon\Carbon::parse($mission->departure_time)->format('H:i') }}</td>
                                            <td class="px-4 py-2 text-gray-800">
                                                <button type="button"
                                                    class="end-mission-btn inline-flex items-center gap-2 bg-blue-600 text-white text-sm px-3 py-1.5 rounded-xl hover:bg-blue-700 transition-colors duration-200 font-semibold"
                                                    title="خاتمه دادن ماموریت" data-mission-id="{{ $mission->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    تغییر وضعیت
                                                </button>

                                            </td>
                                            <td class="px-4 py-2 text-gray-800">
                                                <button onclick="cancelMission({{ $mission->id }})"
                                                    class="inline-flex items-center gap-2 bg-red-500 text-white text-sm px-3 py-1.5 rounded-xl hover:bg-red-600 transition-colors duration-200 font-semibold border border-red-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    کنسل کردن
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endisset

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        <p>© 2025 شرکت نفت و گاز غرب - واحد چشمه خوش</p>
    </footer>





    <!-- Flatpickr time picker script -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <div id="endMissionModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6 mx-4">
            <h3 class="text-xl font-bold mb-6 text-center text-blue-800">تغییر وضعیت ماموریت</h3>
            <form id="endMissionForm" action="{{ route('missions.changeStatus') }}" method="POST"">
                @csrf
                <input type="hidden" name="mission_id" id="modal_mission_id" value="">

                <!-- تاریخ و ساعت رفت -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <!-- تاریخ -->
                    <div>
                        <label for="departure_date" class="block text-gray-700 mb-1 font-semibold">تاریخ حرکت:</label>
                        <input type="date" id="departure_date" value="{{ $mission->departure_date }}"
                            name="departure_date" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500" />
                    </div>

                    <!-- ساعت -->
                    <div>
                        <label for="departure_time" class="block text-gray-700 mb-1 font-semibold">ساعت حرکت:</label>
                        <input type="text" id="departure_time" value="{{ $mission->departure_time }}"
                            name="departure_time" required placeholder="انتخاب ساعت..."
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500 cursor-pointer" />
                    </div>
                </div>

                <!-- وضعیت -->
                <div class="mb-6">
                    <label for="status" class="block text-gray-700 mb-1 font-semibold">وضعیت ماموریت:</label>
                    <select id="status" name="status_type" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500">
                        <option value="">انتخاب کنید...</option>
                        <option value="inprogress">در جریان</option>
                        <option value="finish">خاتمه یافته</option>
                    </select>
                </div>

                <!-- دکمه‌ها -->
                <div class="flex justify-between mt-6">
                    <button type="button" id="modalCloseBtn"
                        class="bg-gray-400 text-white px-6 py-2 rounded-xl hover:bg-gray-500 transition-colors duration-200 font-semibold">
                        بستن
                    </button>
                    <button type="submit"
                        class="bg-blue-700 text-white px-6 py-2 rounded-xl hover:bg-blue-800 transition-colors duration-200 font-semibold">
                        ثبت
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // وقتی روی دکمه "تغییر وضعیت" کلیک شد
        document.querySelectorAll('.end-mission-btn').forEach(button => {
            button.addEventListener('click', function() {
                const missionId = this.getAttribute('data-mission-id');
                document.getElementById('modal_mission_id').value = missionId;
                document.getElementById('endMissionModal').classList.remove('hidden');
                document.getElementById('modal-backdrop').classList.remove('hidden');
            });
        });

        // وقتی روی دکمه "بستن" کلیک شد
        document.getElementById('modalCloseBtn').addEventListener('click', function() {
            document.getElementById('endMissionModal').classList.add('hidden');
            document.getElementById('modal-backdrop').classList.add('hidden');
        });

        // فعال‌سازی انتخاب ساعت با Flatpickr
        flatpickr("#departure_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'موفقیت!',
                text: "{{ session('success') }}",
                confirmButtonText: 'باشه',
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif

    <script>
        function cancelMission(missionId) {
            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: "این عملیات ماموریت را لغو می‌کند!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'بله، کنسل شود',
                cancelButtonText: 'خیر',
            }).then((result) => {
                if (result.isConfirmed) {
                    // ارسال درخواست به کنترلر
                    fetch(`/missions/${missionId}/cancel`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({})
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('موفق!', 'ماموریت با موفقیت کنسل شد.', 'success')
                                    .then(() => window.location.reload());
                            } else {
                                Swal.fire('خطا!', 'خطایی در کنسل کردن ماموریت رخ داد.', 'error');
                            }
                        });
                }
            });
        }
    </script>



</body>

</html>
