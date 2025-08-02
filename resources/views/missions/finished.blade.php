<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ماموریت های خاتمه یافته</title>
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

            <h2 class="text-3xl font-extrabold mb-8 text-center text-blue-800 tracking-wide">ماموریت‌های خاتمه یافته
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
                                        <th class="px-4 py-3"> نمایش اطلاعات/ویرایش</th>

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


    <div id="modal-backdrop" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

    <!-- Modal -->

    <div id="endMissionModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-2xl shadow-lg w-96 p-6 max-w-full mx-4">
            <h3 class="text-xl font-bold mb-6 text-center">خاتمه دادن ماموریت</h3>
            <form id="endMissionForm" method="POST" action="{{ route('missions.end') }}">
                @csrf
                <input type="hidden" name="mission_id" id="modal_mission_id" value="">

                <!-- تاریخ و ساعت برگشت -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <!-- تاریخ برگشت -->
                    <div>
                        <label for="return_date" class="block text-gray-700 mb-1 font-semibold">تاریخ برگشت:</label>
                        <input type="date" id="return_date" name="return_date" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500" />
                    </div>

                    <!-- ساعت برگشت -->
                    <div>
                        <label for="return_time" class="block text-gray-700 mb-1 font-semibold">ساعت برگشت:</label>
                        <div class="relative">
                            <input type="text" id="return_time" name="return_time" placeholder="انتخاب ساعت..."
                                readonly required
                                class="w-full border border-gray-300 rounded px-3 py-2 pr-10 focus:outline-none focus:ring focus:border-blue-500 cursor-pointer hover:shadow" />
                            <!-- آیکون ساعت -->
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- فاصله طی شده -->
                <div class="mb-4">
                    <label for="distance" class="block mb-1 font-semibold text-gray-700">فاصله طی شده (کیلومتر)</label>
                    <input type="number" id="distance" name="distance" min="0" step="any"
                        class="w-full border border-gray-300 rounded px-3 py-2" />
                </div>

                <!-- صبحانه و ناهار -->
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label for="breakfast_count" class="block mb-1 font-semibold text-gray-700">تعداد صبحانه</label>
                        <input type="number" id="breakfast_count" name="breakfast_count" min="0"
                            class="w-full border border-gray-300 rounded px-3 py-2" />
                    </div>
                    <div>
                        <label for="lunch_count" class="block mb-1 font-semibold text-gray-700">تعداد ناهار</label>
                        <input type="number" id="lunch_count" name="lunch_count" min="0"
                            class="w-full border border-gray-300 rounded px-3 py-2" />
                    </div>
                </div>

                <!-- شام و خواب -->
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label for="dinner_count" class="block mb-1 font-semibold text-gray-700">تعداد شام</label>
                        <input type="number" id="dinner_count" name="dinner_count" min="0"
                            class="w-full border border-gray-300 rounded px-3 py-2" />
                    </div>
                    <div>
                        <label for="sleep_count" class="block mb-1 font-semibold text-gray-700">تعداد خواب</label>
                        <input type="number" id="sleep_count" name="sleep_count" min="0"
                            class="w-full border border-gray-300 rounded px-3 py-2" />
                    </div>
                </div>

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
        const modal = document.getElementById('endMissionModal');
        const modalCloseBtn = document.getElementById('modalCloseBtn');

        function openEditModal(missionId) {
            fetch(`/missions/${missionId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modal_mission_id').value = missionId;
                    document.getElementById('return_date').value = data.return_date ?? 0;
                    document.getElementById('return_time').value = data.return_time ?? 0;
                    document.getElementById('distance').value = data.distance ?? 0;
                    document.getElementById('breakfast_count').value = data.breakfast_count ?? 0;
                    document.getElementById('lunch_count').value = data.lunch_count ?? 0;
                    document.getElementById('dinner_count').value = data.dinner_count ?? 0;
                    document.getElementById('sleep_count').value = data.sleep_count ?? 0;

                    modal.classList.remove('hidden');
                });
        }

        modalCloseBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success') && session('source') == 'finished_mission')
        <script>
            Swal.fire({
                icon: 'success',
                title: 'موفقیت!',
                text: "{{ session('success') }}",
                confirmButtonText: 'باشه'
            });
        </script>
    @endif

    @if (session('info') && session('source') == 'finished_mission')
        <script>
            Swal.fire({
                icon: 'info',
                title: 'اطلاع!',
                text: "{{ session('info') }}",
                confirmButtonText: 'باشه'
            });
        </script>
    @endif

</body>

</html>
