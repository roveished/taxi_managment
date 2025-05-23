<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>لیست مسیرها</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <header class="bg-blue-900 text-white py-6 text-center text-2xl font-bold">
        لیست مسیرهای ثبت شده
    </header>

    <main class="p-6 flex-grow">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="py-2 px-4 border-b text-center">مبدا</th>
                        <th class="py-2 px-4 border-b text-center">مقصد</th>
                        <th class="py-2 px-4 border-b text-center">فاصله (کیلومتر)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($routes as $route)
                        <tr>
                            <td class="py-2 px-4 border-b text-center">{{ $route->origin }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $route->destination }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $route->distonce }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 text-center text-gray-500">هیچ مسیری ثبت نشده است.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
        © 2025 شرکت نفت و گاز غرب - واحد چشمه خوش
    </footer>
</body>
</html>
