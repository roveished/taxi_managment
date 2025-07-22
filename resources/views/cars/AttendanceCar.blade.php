<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>لیست خودروها</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleInput(selectElement, id) {
            const input = document.getElementById('hours-input-' + id);
            if (selectElement.value === 'عدم کارکرد' || selectElement.value === 'غیبت') {
                input.classList.remove('hidden');
            } else {
                input.classList.add('hidden');
            }
        }
    </script>

    <script>
        function confirmSubmit(event) {
            event.preventDefault();  
        
           
            let result = confirm("آیا مطمئن هستید که می‌خواهید وضعیت حضور را ثبت کنید؟");
        
            if (result) {
                event.target.submit();
            }
           
            return false; 
        }
        </script>
        
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <header class="bg-blue-900 text-white py-6 text-center text-2xl font-bold">
        لیست خودروهای ثبت شده
    </header>

    <main class="p-6 flex-grow">
        @if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form action="{{ route('car_working.store') }}" method="POST" onsubmit="return confirmSubmit(event)">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="py-2 px-4 border-b text-center">پلاک</th>
                            <th class="py-2 px-4 border-b text-center">نام خودرو</th>
                            <th class="py-2 px-4 border-b text-center">نام راننده</th>
                            <th class="py-2 px-4 border-b text-center">وضعیت حضور</th>
                            <th class="py-2 px-4 border-b text-center">توضیحات</th>
                            <th class="py-2 px-4 border-b text-center">تاریخ</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($routes as $route)
                            <tr>
                                <td class="py-2 px-4 border-b text-center">{{ $route->car_plate }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $route->car_model }}</td>
                                <td class="py-2 px-4 border-b text-center">
                                    {{ $route->driver ? $route->driver->name . ' ' . $route->driver->last_name : 'نامشخص' }}
                                </td>
                                <td class="py-2 px-4 border-b text-center">
                                    <div class="flex items-center justify-center gap-10">
                                        <select name="statuses[{{ $route->id }}]" class="border rounded-2xl p-1">
                                            <option value="present">حضور</option>
                                            <option value="not_working">عدم کارکرد</option>
                                            <option value="absent">غیبت</option>
                                            <option value="leave">مرخصی</option>
                                        </select>
                                        <input type="number" name="hours[{{ $route->id }}]"
                                               value="24" min="1"
                                               class="border rounded-2xl p-1 w-20" />
                                    </div>
                                    <td class="py-2 px-4 border-b text-center">
                                        <input type="text" name="descriptions[{{ $route->id }}]" placeholder="توضیحات"
                                               class="border rounded-2xl p-1 w-full text-center" />
                                    </td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <input type="date" name="dates[{{ $route->id }}]"
                                               value="{{ \Carbon\Carbon::now()->toDateString() }}"
                                               class="border rounded-2xl p-1 w-full" />
                                    </td>
                                    
                                </td>
                                
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-500">هیچ خودرویی ثبت نشده است.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-6">
                <button type="submit"
                        class="bg-blue-700 text-white py-2 px-6 rounded hover:bg-blue-800 transition">
                    ذخیره وضعیت حضور
                </button>
            </div>
        </form>
    </main>

    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        © 2025 شرکت نفت و گاز غرب - واحد چشمه خوش
    </footer>
</body>
</html>
