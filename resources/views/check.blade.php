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


    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg p-10 mt-16 mb-20">

        <!-- جستجوی پلاک خودرو -->
        <div class="flex items-center gap-2 mb-4">
            <div class="w-16">
                <input type="text" id="car_plate_part1" maxlength="2" placeholder="12"
                    class="text-center w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="w-20">
                <select id="car_plate_letter" class="w-full p-2 border border-gray-300 rounded-md" required>
                    @foreach (range('A', 'Z') as $letter)
                        <option value="{{ $letter }}">{{ $letter }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-20">
                <input type="text" id="car_plate_part2" maxlength="3" placeholder="345"
                    class="text-center w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <span class="font-bold text-lg px-2">ایران</span>
            <div class="w-16">
                <input type="text" id="car_plate_part3" maxlength="2" placeholder="67"
                    class="text-center w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <!-- دکمه جستجو -->
            <button id="searchButton"
                class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-4 py-2 rounded-lg transition">
                جستجو
            </button>
        </div>

        <!-- ناحیه نمایش نتیجه -->
        <div id="searchResult" class="text-center text-green-700 font-medium mt-16 hidden mb-16"></div>

        <!-- چک‌لیست با رادیو پشت سر هم -->
        <section class="mb-10">
            <h3 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-2">چک‌لیست بازرسی خودرو</h3>

            <div class="flex flex-col gap-5">
                <input type="hidden" name="car_id" id="car_id">

                <!-- هر آیتم چک‌لیست -->
                <div class="flex items-center justify-between">

                    <span class="w-40 text-gray-700 font-medium select-none">شیشه جلو:</span>

                    <div class="flex gap-6 rtl:space-x-reverse">

                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="front_glass" value="1"
                                class="form-radio text-green-600 w-5 h-5" />
                            <span class="text-green-700 font-semibold select-none">قابل قبول</span>
                        </label>

                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="front_glass" value="0"
                                class="form-radio text-red-600 w-5 h-5" />
                            <span class="text-red-700 font-semibold select-none">غیر قابل قبول</span>
                        </label>

                    </div>

                </div>

                <!-- شیشه عقب -->
                <div class="flex items-center justify-between">
                    <span class="w-40 text-gray-700 font-medium select-none">شیشه عقب:</span>
                    <div class="flex gap-6 rtl:space-x-reverse">
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="rear_glass" value="1"
                                class="form-radio text-green-600 w-5 h-5" />
                            <span class="text-green-700 font-semibold select-none">قابل قبول</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="rear_glass" value="0"
                                class="form-radio text-red-600 w-5 h-5" />
                            <span class="text-red-700 font-semibold select-none">غیر قابل قبول</span>
                        </label>
                    </div>
                </div>

                <!-- جعبه ابزار -->
                <div class="flex items-center justify-between">
                    <span class="w-40 text-gray-700 font-medium select-none">جعبه ابزار:</span>
                    <div class="flex gap-6 rtl:space-x-reverse">
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="toolbox" value="1"
                                class="form-radio text-green-600 w-5 h-5" />
                            <span class="text-green-700 font-semibold select-none">قابل قبول</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="toolbox" value="0"
                                class="form-radio text-red-600 w-5 h-5" />
                            <span class="text-red-700 font-semibold select-none">غیر قابل قبول</span>
                        </label>
                    </div>
                </div>

                <!-- جعبه کمک‌های اولیه -->
                <div class="flex items-center justify-between">
                    <span class="w-40 text-gray-700 font-medium select-none">جعبه کمک‌های اولیه:</span>
                    <div class="flex gap-6 rtl:space-x-reverse">
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="first_aid_kit" value="1"
                                class="form-radio text-green-600 w-5 h-5" />
                            <span class="text-green-700 font-semibold select-none">قابل قبول</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="first_aid_kit" value="0"
                                class="form-radio text-red-600 w-5 h-5" />
                            <span class="text-red-700 font-semibold select-none">غیر قابل قبول</span>
                        </label>
                    </div>
                </div>

                <!-- زاپاس -->
                <div class="flex items-center justify-between">
                    <span class="w-40 text-gray-700 font-medium select-none">زاپاس:</span>
                    <div class="flex gap-6 rtl:space-x-reverse">
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="spare_tire" value="1"
                                class="form-radio text-green-600 w-5 h-5" />
                            <span class="text-green-700 font-semibold select-none">قابل قبول</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="spare_tire" value="0"
                                class="form-radio text-red-600 w-5 h-5" />
                            <span class="text-red-700 font-semibold select-none">غیر قابل قبول</span>
                        </label>
                    </div>
                </div>

                <!-- لاستیک‌های جلو -->
                <div class="flex items-center justify-between">
                    <span class="w-40 text-gray-700 font-medium select-none">لاستیک‌های جلو:</span>
                    <div class="flex gap-6 rtl:space-x-reverse">
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="front_tires" value="1"
                                class="form-radio text-green-600 w-5 h-5" />
                            <span class="text-green-700 font-semibold select-none">قابل قبول</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="front_tires" value="0"
                                class="form-radio text-red-600 w-5 h-5" />
                            <span class="text-red-700 font-semibold select-none">غیر قابل قبول</span>
                        </label>
                    </div>
                </div>

                <!-- لاستیک‌های عقب -->
                <div class="flex items-center justify-between">
                    <span class="w-40 text-gray-700 font-medium select-none">لاستیک‌های عقب:</span>
                    <div class="flex gap-6 rtl:space-x-reverse">
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="rear_tires" value="1"
                                class="form-radio text-green-600 w-5 h-5" />
                            <span class="text-green-700 font-semibold select-none">قابل قبول</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="rear_tires" value="0"
                                class="form-radio text-red-600 w-5 h-5" />
                            <span>غیر قابل قبول</span>
                        </label>
                    </div>
                </div>

                <!-- چراغ‌های جلو -->
                <div class="flex items-center justify-between">
                    <span class="w-40 text-gray-700 font-medium select-none">چراغ‌های جلو:</span>
                    <div class="flex gap-6 rtl:space-x-reverse">
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="front_lights" value="1"
                                class="form-radio text-green-600 w-5 h-5" />
                            <span class="text-green-700 font-semibold select-none">قابل قبول</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="front_lights" value="0"
                                class="form-radio text-red-600 w-5 h-5" />
                            <span class="text-red-700 font-semibold select-none">غیر قابل قبول</span>
                        </label>
                    </div>
                </div>

                <!-- چراغ‌های عقب -->
                <div class="flex items-center justify-between">
                    <span class="w-40 text-gray-700 font-medium select-none">چراغ‌های عقب:</span>
                    <div class="flex gap-6 rtl:space-x-reverse">
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="rear_lights" value="1"
                                class="form-radio text-green-600 w-5 h-5" />
                            <span class="text-green-700 font-semibold select-none">قابل قبول</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="rear_lights" value="0"
                                class="form-radio text-red-600 w-5 h-5" />
                            <span class="text-red-700 font-semibold select-none">غیر قابل قبول</span>
                        </label>
                    </div>
                </div>

                <!-- مه‌شکن جلو -->
                <div class="flex items-center justify-between">
                    <span class="w-40 text-gray-700 font-medium select-none">مه‌شکن جلو:</span>
                    <div class="flex gap-6 rtl:space-x-reverse">
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="front_fog_lights" value="1"
                                class="form-radio text-green-600 w-5 h-5" />
                            <span class="text-green-700 font-semibold select-none">قابل قبول</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="front_fog_lights" value="0"
                                class="form-radio text-red-600 w-5 h-5" />
                            <span class="text-red-700 font-semibold select-none">غیر قابل قبول</span>
                        </label>
                    </div>
                </div>

                <!-- مه‌شکن عقب -->
                <div class="flex items-center justify-between">
                    <span class="w-40 text-gray-700 font-medium select-none">مه‌شکن عقب:</span>
                    <div class="flex gap-6 rtl:space-x-reverse">
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="rear_fog_lights" value="1"
                                class="form-radio text-green-600 w-5 h-5" />
                            <span class="text-green-700 font-semibold select-none">قابل قبول</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="rear_fog_lights" value="0"
                                class="form-radio text-red-600 w-5 h-5" />
                            <span class="text-red-700 font-semibold select-none">غیر قابل قبول</span>
                        </label>
                    </div>
                </div>

                <!-- سیستم ترمز -->
                <div class="flex items-center justify-between">
                    <span class="w-40 text-gray-700 font-medium select-none">سیستم ترمز:</span>
                    <div class="flex gap-6 rtl:space-x-reverse">
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="brake_system" value="1"
                                class="form-radio text-green-600 w-5 h-5" />
                            <span class="text-green-700 font-semibold select-none">قابل قبول</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="brake_system" value="0"
                                class="form-radio text-red-600 w-5 h-5" />
                            <span class="text-red-700 font-semibold select-none">غیر قابل قبول</span>
                        </label>
                    </div>
                </div>

                <!-- فنی خودرو -->
                <div class="flex items-center justify-between">
                    <span class="w-40 text-gray-700 font-medium select-none">فنی خودرو:</span>
                    <div class="flex gap-6 rtl:space-x-reverse">
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="mechanical_condition" value="1"
                                class="form-radio text-green-600 w-5 h-5" />
                            <span class="text-green-700 font-semibold select-none">قابل قبول</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="mechanical_condition" value="0"
                                class="form-radio text-red-600 w-5 h-5" />
                            <span class="text-red-700 font-semibold select-none">غیر قابل قبول</span>
                        </label>
                    </div>
                </div>

                <!-- ظاهر کابین -->
                <div class="flex items-center justify-between">
                    <span class="w-40 text-gray-700 font-medium select-none">ظاهر کابین:</span>
                    <div class="flex gap-6 rtl:space-x-reverse">
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="cabin_appearance" value="1"
                                class="form-radio text-green-600 w-5 h-5" />
                            <span class="text-green-700 font-semibold select-none">قابل قبول</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="cabin_appearance" value="0"
                                class="form-radio text-red-600 w-5 h-5" />
                            <span class="text-red-700 font-semibold select-none">غیر قابل قبول</span>
                        </label>
                    </div>
                </div>

                <!-- ظاهر بدنه -->
                <div class="flex items-center justify-between">
                    <span class="w-40 text-gray-700 font-medium select-none">ظاهر بدنه:</span>
                    <div class="flex gap-6 rtl:space-x-reverse">
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="body_appearance" value="1"
                                class="form-radio text-green-600 w-5 h-5" />
                            <span class="text-green-700 font-semibold select-none">قابل قبول</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <input type="radio" name="body_appearance" value="0"
                                class="form-radio text-red-600 w-5 h-5" />
                            <span class="text-red-700 font-semibold select-none">غیر قابل قبول</span>
                        </label>
                    </div>
                </div>

            </div>
        </section>

        <!-- توضیحات اضافی -->
        <section class="mb-8">
            <label for="description" class="block mb-2 text-gray-700 font-semibold">توضیحات اضافی:</label>
            <textarea id="description" name="description" rows="4"
                class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-400
                   focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                placeholder="توضیحات خود را اینجا وارد کنید..."></textarea>
        </section>

        <!-- تاریخ انقضا و وضعیت -->
        <section class="flex flex-wrap gap-6 items-center">
            <div class="flex-1 min-w-[160px]">
                <label for="expiration_date" class="block mb-2 text-gray-700 font-semibold">تاریخ انقضا:</label>
                <input type="date" id="expiration_date" name="expiration_date"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900
                     focus:outline-none focus:ring-2 focus:ring-blue-500 transition" />
            </div>

            <div class="flex-1 min-w-[160px]">
                <label for="status" class="block mb-2 text-gray-700 font-semibold">وضعیت:</label>
                <select id="status" name="status"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900
                     focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="valid">معتبر</option>
                    <option value="invalid">نامعتبر</option>
                </select>
            </div>
        </section>
        <div class="flex justify-center mt-12">
            <button id="submitInspectionBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                ثبت وضعیت‌ها
            </button>
        </div>

    </div>



    <!-- Footer -->
    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        <p>© 2025 شرکت نفت و گاز غرب - واحد چشمه خوش</p>
    </footer>
    <script>
        document.getElementById('searchButton').addEventListener('click', function() {
            const part1 = document.getElementById('car_plate_part1').value;
            const letter = document.getElementById('car_plate_letter').value;
            const part2 = document.getElementById('car_plate_part2').value;
            const part3 = document.getElementById('car_plate_part3').value;

            const full_plate = `${part1}-${letter}-${part2}-${part3}`;

            fetch(`/cars/search?plate=${full_plate}`)
                .then(response => response.json())
                .then(data => {
                    const resultDiv = document.getElementById('searchResult');
                    if (data.success) {
                        resultDiv.innerText = `خودروی ${data.model} با مالکیت آقای ${data.owner}`;
                        resultDiv.classList.remove('hidden');
                        resultDiv.classList.remove('text-red-700');
                        resultDiv.classList.add('text-green-700');
                        document.getElementById('car_id').value = data.car_id;


                    } else {
                        resultDiv.innerText = 'خودرویی با این پلاک یافت نشد.';
                        resultDiv.classList.remove('hidden');
                        resultDiv.classList.remove('text-green-700');
                        resultDiv.classList.add('text-red-700');
                    }
                })
                .catch(error => {
                    alert("خطا در جستجو: " + error);
                });
        });
    </script>
    <script>
        document.getElementById('submitInspectionBtn').addEventListener('click', function() {
            const getRadioValue = (name) => {
                const checked = document.querySelector(`input[name="${name}"]:checked`);
                return checked ? checked.value === "1" : false;
            };

            const part1 = document.getElementById('car_plate_part1').value;
            const letter = document.getElementById('car_plate_letter').value;
            const part2 = document.getElementById('car_plate_part2').value;
            const part3 = document.getElementById('car_plate_part3').value;
            const full_plate = `${part1}${letter}${part2}${part3}`;


            const data = {
                car_plate: full_plate,
                expiration_date: document.getElementById('expiration_date').value,
                status: document.getElementById('status').value,
                description: document.getElementById('description').value,

                front_glass: getRadioValue("front_glass"),
                rear_glass: getRadioValue("rear_glass"),
                toolbox: getRadioValue("toolbox"),
                first_aid_kit: getRadioValue("first_aid_kit"),
                spare_tire: getRadioValue("spare_tire"),
                front_tires: getRadioValue("front_tires"),
                rear_tires: getRadioValue("rear_tires"),
                front_lights: getRadioValue("front_lights"),
                rear_lights: getRadioValue("rear_lights"),
                front_fog_lights: getRadioValue("front_fog_lights"),
                rear_fog_lights: getRadioValue("rear_fog_lights"),
                brake_system: getRadioValue("brake_system"),
                mechanical_condition: getRadioValue("mechanical_condition"),
                cabin_appearance: getRadioValue("cabin_appearance"),
                body_appearance: getRadioValue("body_appearance"),
            };

            fetch("{{ route('inspections.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(res => {
                    if (res.ok) {
                        alert("بازرسی با موفقیت ثبت شد");
                        window.location.reload();
                    } else {
                        return res.text().then(err => {
                            throw new Error(err);
                        });
                    }
                })
                .catch(err => {
                    alert("خطا در ثبت بازرسی:\n" + err.message);
                });
        });
    </script>


</body>

</html>
