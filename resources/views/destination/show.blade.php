<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>لیست مسیرها</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    <!-- Main -->
    <main class="flex-grow flex justify-center items-center py-10 bg-gray-100">
        <div class="bg-white shadow-lg rounded-3xl p-8 w-full max-w-screen-lg border border-gray-300">
            <h2 class="text-3xl font-extrabold mb-8 text-center text-blue-800 tracking-wide">لیست مسیرهای ثبت‌شده</h2>

            @if ($routes->isEmpty())
                <p class="text-center text-gray-600">هیچ مسیری ثبت نشده است.</p>
            @else
                <div class="overflow-x-auto bg-white rounded-lg shadow">
                    <table class="min-w-full table-auto text-sm text-center">
                        <thead class="bg-blue-800 text-white">
                            <tr>
                                <th class="px-4 py-3">مبدأ</th>
                                <th class="px-4 py-3">مقصد</th>
                                <th class="px-4 py-3">فاصله (کیلومتر)</th>
                                <th class="px-4 py-3"> نمایش اطلاعات/ویرایش</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($routes as $route)
                                <tr
                                    class="{{ $loop->even ? 'bg-blue-50' : 'bg-white' }} border-b hover:bg-blue-100 transition">
                                    <td class="px-4 py-2 font-semibold text-gray-800">{{ $route->origin }}</td>
                                    <td class="px-4 py-2 text-gray-800">{{ $route->destination }}</td>
                                    <td class="px-4 py-2 text-gray-800">{{ $route->distonce }}</td>
                                    <td class="px-4 py-2 text-gray-800">
                                        <button
                                            onclick="document.getElementById('editModal-{{ $route->id }}').showModal()"
                                            class="bg-cyan-600 hover:bg-cyan-900  text-white px-4 py-2 rounded-xl transition-colors duration-200 font-semibold ">
                                            نمایش اطلاعات/ویرایش
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </main>
    @foreach ($routes as $route)
        <!-- Modal -->
        <dialog id="editModal-{{ $route->id }}"
            class="rounded-2xl w-full max-w-md p-6 shadow-xl backdrop:bg-black/30">
            <form method="POST" action="{{ route('destination.update', $route->id) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <h3 class="text-lg font-bold text-center mb-2">ویرایش مسیر</h3>

                <div>
                    <label class="block text-sm text-gray-700">مبدأ:</label>
                    <input type="text" name="origin" value="{{ $route->origin }}" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm text-gray-700">مقصد:</label>
                    <input type="text" name="destination" value="{{ $route->destination }}" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm text-gray-700">فاصله (کیلومتر):</label>
                    <input type="number" name="distonce" value="{{ $route->distonce }}" min="0" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex justify-between items-center mt-4">
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md">
                        ویرایش
                    </button>
                    <button type="button" onclick="document.getElementById('editModal-{{ $route->id }}').close()"
                        class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md">
                        بستن
                    </button>
                </div>
            </form>
        </dialog>
    @endforeach

    <!-- Footer -->
    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        <p>© 2025 شرکت نفت و گاز غرب - واحد چشمه خوش</p>
    </footer>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'عملیات موفق',
                text: '{{ session('success') }}',
                confirmButtonText: 'باشه'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'خطا',
                text: '{{ session('error') }}',
                confirmButtonText: 'باشه'
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            let errorMessages = @json($errors->all());
            Swal.fire({
                icon: 'warning',
                title: 'خطا در اعتبارسنجی',
                html: `<ul style="text-align:right;direction:rtl;">${errorMessages.map(e => `<li>${e}</li>`).join('')}</ul>`,
                confirmButtonText: 'باشه'
            });
        </script>
    @endif


</body>

</html>
