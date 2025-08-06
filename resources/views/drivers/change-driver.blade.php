<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>تغییر راننده</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    <!-- محتوا -->
    <main class="flex-grow flex justify-center mt-20 px-4">
        <div class="bg-white p-6 rounded-2xl shadow-xl w-full max-w-2xl space-y-6 text-center">
            <h2 class="text-3xl font-extrabold mb-8 text-center text-blue-800 tracking-wide">تغییر راننده خودرو
            </h2>


            <!-- فرم پلاک -->
            <form id="search-plate-form" class="flex items-center gap-2 mb-4 justify-center">
                <div class="w-16">
                    <input type="text" id="part1" maxlength="2" placeholder="12"
                        class="text-center w-full p-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="w-20">
                    <select id="part2" class="w-full p-2 border border-gray-300 rounded-md" required>
                        @foreach (range('A', 'Z') as $letter)
                            <option value="{{ $letter }}">{{ $letter }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-20">
                    <input type="text" id="part3" maxlength="3" placeholder="345"
                        class="text-center w-full p-2 border border-gray-300 rounded-md" required>
                </div>

                <span class="font-bold text-lg px-2">ایران</span>

                <div class="w-16">
                    <input type="text" id="part4" maxlength="2" placeholder="67"
                        class="text-center w-full p-2 border border-gray-300 rounded-md" required>
                </div>

                <button type="submit"
                    class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded transition duration-200"
                    id="search-btn">جستجو</button>
            </form>


            <!-- نتیجه -->
            <div id="result-section" class="hidden mt-6 text-right space-y-4">
                <p><strong>مدل خودرو: </strong><span id="car-model" class="text-blue-700"></span></p>
                <p><strong>مالک خودرو: </strong><span id="car-owner" class="text-blue-700"></span></p>
                <p><strong>راننده فعلی: </strong><span id="car-driver" class="text-blue-700"></span></p>

                <!-- انتخاب راننده -->
                <div class="mt-4 text-right">
                    <label for="new-driver" class="block font-semibold mb-1">انتخاب راننده جدید:</label>
                    <select id="new-driver" class="w-full border rounded px-2 py-2">
                        <option value="">-- انتخاب کنید --</option>
                        @foreach (\App\Models\Driver::where('status', 'active')->get() as $driver)
                            <option value="{{ $driver->id }}">
                                {{ $driver->name }} {{ $driver->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- دکمه تغییر -->
                <div class="mt-6 flex justify-center">
                    <button id="change-driver-btn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        تغییر راننده
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white text-center py-4 mt-10">
        <p>© 2025 شرکت نفت و گاز غرب - واحد چشمه خوش</p>
    </footer>

    <script>
        let foundCarId = null;

        document.getElementById('search-plate-form').addEventListener('submit', function(event) {
            event.preventDefault(); // جلوگیری از ارسال فرم

            const part1 = document.getElementById('part1').value;
            const part2 = document.getElementById('part2').value.toUpperCase();
            const part3 = document.getElementById('part3').value;
            const part4 = document.getElementById('part4').value;
            const plate = `${part1}${part2}${part3}${part4}`;

            fetch(`{{ route('driver.search.car') }}?plate=${plate}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        Swal.fire('خطا', data.message, 'error');
                        document.getElementById('result-section').classList.add('hidden');
                        return;
                    }

                    // نمایش اطلاعات
                    document.getElementById('car-model').textContent = data.model;
                    document.getElementById('car-owner').textContent = data.owner;
                    document.getElementById('car-driver').textContent = data.driver_name;
                    document.getElementById('result-section').classList.remove('hidden');
                    foundCarId = data.car_id;
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire('خطا', 'در دریافت اطلاعات مشکلی پیش آمد.', 'error');
                });
        });

        document.getElementById('change-driver-btn').addEventListener('click', function() {
            const newDriverId = document.getElementById('new-driver').value;
            if (!newDriverId || !foundCarId) {
                Swal.fire('خطا', 'لطفاً ابتدا خودرو را جستجو کرده و راننده جدید را انتخاب کنید.', 'warning');
                return;
            }

            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: "تغییر راننده انجام خواهد شد!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله، تغییر بده',
                cancelButtonText: 'لغو'
            }).then((result) => {
                if (result.isConfirmed) {
                    // اگر تایید شد، ارسال اطلاعات به سرور
                    fetch(`{{ route('driver.update') }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                car_id: foundCarId,
                                driver_id: newDriverId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                Swal.fire('هشدار', data.message, 'warning');
                            } else {
                                Swal.fire('موفق', data.message, 'success');
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            Swal.fire('خطا', 'در ارسال اطلاعات مشکلی پیش آمد.', 'error');
                        });
                } else {
                    // اگر لغو شد (result.isDismissed)، هیچ کاری انجام نشود
                }
            });
        });
    </script>

</body>

</html>
