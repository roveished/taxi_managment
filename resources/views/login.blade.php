<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>صفحه ورود</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen font-sans">

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
        
        <p class="text-lg mt-6 mb-6">به سامانه مدیریت خودرو های استیجاری واحد چشمه خوش خوش آمدید.</p>
    </div>
</header>

  <!-- Login Form -->
  <main class="flex-grow flex items-center justify-center">
    <form action="{{ url('login') }}" method="POST" class="gray-150 p-10 rounded-2xl shadow-lg w-full max-w-xl space-y-6">
        @csrf
        @if($errors->any())
        <div class="text-red-600 text-center mt-4">
          @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </div>
      @endif
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700">نام کاربری</label>
            <input type="text" id="username" name="username" placeholder="نام کاربری خود را وارد کنید:" class="mt-1 block w-full p-3 border border-gray-300 rounded-2xl" />
            @error('username')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">رمز عبور</label>
            <input type="password" id="password" name="password" placeholder="رمز عبور خود را وارد کنید:" class="mt-1 block w-full p-3 border border-gray-300 rounded-2xl" />
            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex justify-center pt-4">
            <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl hover:bg-indigo-700">
                ورود
            </button>
        </div>
    </form>

  </main>

  <!-- Footer -->
  <footer class="bg-indigo-600 text-center p-3 text-sm text-gray-600">
    © 2025 چشمه خوش. تمامی حقوق محفوظ است.
  </footer>
  /* <script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
    // e.preventDefault(); // جلوگیری از ارسال فرم
      const username = document.getElementById('username');
      const password = document.getElementById('password');
      const usernameError = document.getElementById('usernameError');
      const passwordError = document.getElementById('passwordError');

      let isValid = true;

      // بررسی نام کاربری
      if (username.value.trim() === '')
      {
        usernameError.classList.remove('hidden');
        isValid = false;
      }
      else
      {
        usernameError.classList.add('hidden');
      }

      // بررسی رمز عبور
      if (password.value.trim() === '')
       {
        passwordError.classList.remove('hidden');
        isValid = false;
      }
       else
    {
        passwordError.classList.add('hidden');
      }

      // اگر همه معتبر بود، می‌توان فرم را ارسال کرد یا به مرحله بعد رفت
      if (isValid) {
        //alert("ورود موفقیت‌آمیز!"); // یا ارسال به سرور
         this.submit(); ← فعال‌سازی این خط در صورت نیاز به ارسال فرم واقعی
      }
    });
  </script>
*/
</body>
</html>
