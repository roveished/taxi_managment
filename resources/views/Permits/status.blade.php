<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>وضعیت پرمیت رانندگان</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

    <!-- Main Content -->
    <main class="flex-grow flex justify-center items-center py-10 bg-gray-100 min-h-screen">
        <div class="bg-white shadow-lg rounded-3xl p-8 w-full max-w-screen-xl border border-gray-300">

            <h2 class="text-3xl font-extrabold mb-8 text-center text-blue-800 tracking-wide">
                وضعیت پرمیت رانندگان
            </h2>

            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full table-auto text-sm text-center">
                    <thead class="bg-blue-800 text-white">
                        <tr>
                            <th class="px-4 py-3">ردیف</th>
                            <th class="px-4 py-3">نام</th>
                            <th class="px-4 py-3">نام خانوادگی</th>
                            <th class="px-4 py-3">کد ملی</th>
                            <th class="px-4 py-3">تاریخ صدور</th>
                            <th class="px-4 py-3">تاریخ انقضا</th>
                            <th class="px-4 py-3">وضغیت / ویرایش</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permits as $index => $permit)
                            <tr
                                class="{{ $loop->even ? 'bg-blue-50' : 'bg-white' }} border-b hover:bg-blue-100 transition">
                                <td class="px-4 py-2 font-bold text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 text-gray-800">{{ $permit->driver->name }}</td>
                                <td class="px-4 py-2 text-gray-800">{{ $permit->driver->last_name }}</td>
                                <td class="px-4 py-2 text-gray-800">{{ $permit->driver->national_id }}</td>
                                <td class="px-4 py-2 text-gray-800">
                                    {{ \Carbon\Carbon::parse($permit->issue_date)->format('Y-m-d') }}</td>
                                <td class="px-4 py-2 text-gray-800">
                                    {{ \Carbon\Carbon::parse($permit->expiration_date)->format('Y-m-d') }}</td>
                                <td class="px-4 py-2">
                                    <button
                                        class="px-6 py-2 rounded-full text-white text-xs font-semibold
                                                   {{ $permit->status === 'valid' ? 'bg-green-600' : 'bg-red-600' }}
                                                   hover:opacity-90 transition-all"
                                        data-permit='@json($permit)'
                                        data-driver='@json($permit->driver)' onclick="openPermitModal(this)">
                                        {{ $permit->status === 'valid' ? 'معتبر' : 'نامعتبر' }}
                                    </button>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </main>
    <!-- Permit Modal -->

    <div id="permitModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 relative">

            <h3 class="text-xl font-bold mb-4 text-blue-800 text-center">ویرایش پرمیت راننده</h3>

            <div class="space-y-2">
                <p><strong>نام:</strong> <span id="driverName"></span></p>
                <p><strong>نام خانوادگی:</strong> <span id="driverLastName"></span></p>
                <p><strong>کد ملی:</strong> <span id="driverNationalId"></span></p>
                <p><strong>شماره تماس:</strong> <span id="driverPhoneNumber"></span></p>
            </div>

            <form id="permitForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mt-4">
                    <label class="block text-sm font-medium mb-1">تاریخ صدور</label>
                    <input type="date" name="issue_date" id="issueDate" class="w-full border rounded-lg px-3 py-2">
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium mb-1">تاریخ انقضا</label>
                    <input type="date" name="expiration_date" id="expirationDate"
                        class="w-full border rounded-lg px-3 py-2">
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium mb-1">وضعیت</label>
                    <select name="status" id="status" class="w-full border rounded-lg px-3 py-2">
                        <option value="valid">معتبر</option>
                        <option value="invalid">نامعتبر</option>
                    </select>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-4">
                    <button type="submit" class="bg-blue-700 text-white py-2 rounded-lg hover:bg-blue-800 transition">
                        ثبت تغییرات
                    </button>

                    <button type="button" onclick="closePermitModal()"
                        class="bg-gray-300 text-gray-800 py-2 rounded-lg hover:bg-gray-400 transition">
                        بستن
                    </button>
                </div>

            </form>
        </div>
    </div>


    <!-- Footer -->
    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        <p>© 2025 شرکت نفت و گاز غرب - واحد چشمه خوش</p>
    </footer>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'موفقیت',
                text: '{{ session('success') }}',
                confirmButtonText: 'باشه'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'خطا',
                text: '{{ session('error') }}',
                confirmButtonText: 'باشه'
            });
        @endif

        @if ($errors->any())
            let errorMessages = @json($errors->all());
            Swal.fire({
                icon: 'error',
                title: 'خطا در فرم',
                html: `<ul style="text-align: right; direction: rtl;">${errorMessages.map(e => `<li>${e}</li>`).join('')}</ul>`,
                confirmButtonText: 'متوجه شدم'
            });
        @endif
    </script>
    <script>
        function openPermitModal(button) {
            const permit = JSON.parse(button.getAttribute('data-permit'));
            const driver = JSON.parse(button.getAttribute('data-driver'));

            // Set values in modal
            document.getElementById('driverName').textContent = driver.name;
            document.getElementById('driverLastName').textContent = driver.last_name;
            document.getElementById('driverNationalId').textContent = driver.national_id;
            document.getElementById('driverPhoneNumber').textContent = driver.phone_number;

            document.getElementById('issueDate').value = permit.issue_date;
            document.getElementById('expirationDate').value = permit.expiration_date;
            document.getElementById('status').value = permit.status;

            // Set form action dynamically
            const form = document.getElementById('permitForm');
            form.action = `/permits/${permit.id}`;

            // Show modal
            document.getElementById('permitModal').classList.remove('hidden');
        }

        function closePermitModal() {
            document.getElementById('permitModal').classList.add('hidden');
        }
    </script>
    <script>
        document.getElementById('permitForm').addEventListener('submit', function(e) {
            e.preventDefault(); // جلوگیری از سابمیت معمولی

            const form = e.target;
            const formData = new FormData(form);
            const action = form.action;

            fetch(action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error('خطا در ارسال اطلاعات');
                    return response.json();
                })
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'موفقیت',
                        text: 'پرمیت با موفقیت بروزرسانی شد',
                        confirmButtonText: 'باشه'
                    });

                    closePermitModal();
                    // اختیاری: رفرش جدول یا صفحه (در صورت نیاز)
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        text: error.message,
                        confirmButtonText: 'باشه'
                    });
                });
        });
    </script>



</body>

</html>
