<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ایجاد ماموریت جدید</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Flatpickr -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-blue-900 text-white relative">
    <div class="flex justify-between items-center py-10 px-4">
      <img src="{{ asset('main-logo.png') }}" alt="Logo" class="w-auto h-auto">
    </div>
    <div class="absolute inset-0 flex flex-col justify-center items-center text-center">
      <h2 class="text-2xl font-bold">{{ Auth::user()->name }} {{ Auth::user()->last_name }}</h2>
      <p class="text-lg mt-6 mb-6">به سامانه مدیریت خودرو های استیجاری واحد چشمه خوش خوش آمدید.</p>
    </div>
  </header>

  <!-- Main -->
  <main class="p-6 flex-grow flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-md w-full max-w-3xl p-8">
      <h2 class="text-2xl font-bold mb-6 text-center">فرم ایجاد ماموریت جدید</h2>
      <form action="{{ route('missions.store') }}" method="POST" class="space-y-6">

        @csrf

        <!-- تاریخ و ساعت -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-gray-700 mb-1">تاریخ حرکت:</label>
            <input type="date" name="departure_date" value="{{ now()->format('Y-m-d') }}"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500">
          </div>
          <div>
            <label class="block text-gray-700 mb-1" for="departure_time">ساعت حرکت:</label>
            <div class="relative">
              <input type="text" id="departure_time" name="departure_time"
                     placeholder="انتخاب ساعت..."
                     readonly
                     class="w-full border border-gray-300 rounded px-3 py-2 pr-10 focus:outline-none focus:ring focus:border-blue-500 cursor-pointer hover:shadow">
              <!-- آیکون ساعت -->
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/>
                </svg>
              </div>
            </div>
          </div>
        </div>

        <!-- مبدا و مقصد -->
        <div class="flex flex-col md:flex-row gap-6">
          <div class="flex-1">
            <label class="block text-gray-700 mb-1">انتخاب مبدا:</label>
            <select id="origin" name="origin" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring">
              <option value="">انتخاب کنید...</option>
              @foreach($origins as $origin)
                <option value="{{ $origin }}">{{ $origin }}</option>
              @endforeach
            </select>
          </div>

          <div class="flex-1">
            <label class="block text-gray-700 mb-1">مقصد:</label>
            <div class="flex gap-2">
              <select id="destination_select"
                class="flex-grow border border-gray-300 rounded px-3 py-2 focus:ring">
                <option value="">انتخاب مقصد...</option>
              </select>
              <button type="button" id="openDestinationModalBtn"
                class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded">افزودن</button>
              <button type="button" id="add_destination_btn"
                class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded">ثبت</button>
            </div>
          </div>
        </div>

        <!-- لیست مقصدها -->
        <ul id="selected_destinations" class="space-y-2 mt-4"></ul>
        <!--لیست خودرو ها-->
        <div class="flex flex-col md:flex-row gap-6">
          <!-- کاربری خودرو -->
          <div class="flex-1">
            <label class="block text-gray-700 mb-1">کاربری خودرو:</label>
            <select id="car_type" name="car_type" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring">
              <option value="">انتخاب کنید...</option>
              <option value="vip">تشریفاتی</option>
              <option value="truck">وانت</option>
              <option value="passenger">سواری</option>
              <option value="vp">سواری/تشریفاتی</option>
            </select>
          </div>
        
          <!-- لیست خودروها -->
          <div class="flex-1">
            <label class="block text-gray-700 mb-1">انتخاب خودرو:</label>
            <select id="car_select" name="car_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring">
              <option value="">ابتدا نوع کاربری را انتخاب کنید</option>
            </select>
          </div>
        </div>
        <!-- نمایش اطلاعات خودرو بعد از انتخاب -->
        <div id="car_info" class="mt-2 text-blue-800 font-semibold hidden"></div>
        <!-- کاربری خودرو -->
        <div class="flex-1">
          <label class="block text-gray-700 mb-1">وضعیت ماموریت</label>
          <select id="status" name="status_type" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring">
            <option value="">انتخاب کنید...</option>
            <option value="ٌwait">در انتظار</option>
            <option value="inprogress">در جریان</option>
            <option value="finish">خاتمه یافته</option>
          </select>
        </div>
      
        <input type="text" name="description" id="description"
       class="w-full border border-gray-300 rounded px-3 py-2 focus:ring"
       placeholder="توضیحات مأموریت را وارد کنید...">
        
       <div class="text-center pt-4">
        <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded shadow">
          ثبت ماموریت
        </button>
      </div>
      @if(session('success'))
  <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
    {{ session('success') }}
  </div>
@endif


      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-blue-900 text-white text-center py-4 mt-auto">
    <p>© 2025 شرکت نفت و گاز غرب - واحد چشمه خوش</p>
  </footer>

  <!-- Modal -->
  <div id="destinationModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="bg-white rounded-lg w-full max-w-md p-6 relative">
      <h3 class="text-xl font-bold mb-4">➕ افزودن مسیر جدید</h3>
      <div class="space-y-4">
        <div>
          <label class="block text-gray-700 mb-1">مبدا:</label>
          <input type="text" id="modal_origin"
            class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
        <div>
          <label class="block text-gray-700 mb-1">مقصد:</label>
          <input type="text" id="modal_destination"
            class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
        <div>
          <label class="block text-gray-700 mb-1">فاصله (کیلومتر):</label>
          <input type="number" id="modal_distance"
            class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
      </div>
      <div class="flex justify-end mt-6 gap-3">
        <button id="closeDestinationModalBtn"
          class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">بستن</button>
        <button id="saveDestinationBtn"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">ثبت مسیر</button>
      </div>
    </div>
  </div>

  
  <!-- Modal chrng driver -->
  <div id="changeDriverModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
      <h2 class="text-xl font-semibold mb-4">تغییر راننده خودرو</h2>
  
      <div id="modalCarInfo" class="text-sm text-gray-700 mb-4">
        <!-- اطلاعات خودرو اینجا لود می‌شود -->
      </div>
  
      <label for="driverSelect" class="block mb-1">انتخاب راننده جدید:</label>
      <select id="driverSelect" class="w-full p-2 border rounded mb-4">
        <!-- گزینه‌ها با JS پر می‌شود -->
      </select>
  
      <div class="flex justify-end gap-2">
        <button id="cancelChange" class="px-4 py-2 bg-gray-300 rounded">انصراف</button>
        <button id="submitChange" class="px-4 py-2 bg-green-600 text-white rounded">ثبت تغییر</button>
      </div>
    </div>
  </div>
  

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
 /* <script>
    // Flatpickr init
    flatpickr("#departure_time", { enableTime: true, noCalendar: true, dateFormat: "H:i", time_24hr: true });

    const originSelect = document.getElementById('origin');
    const destinationSelect = document.getElementById('destination_select');
    const addBtn = document.getElementById('add_destination_btn');
    const selectedList = document.getElementById('selected_destinations');
    const modal = document.getElementById('destinationModal');

    // بارگذاری مقصدها براساس مبدا
    originSelect.addEventListener('change', () => {
      const selectedOrigin = originSelect.value;
      fetch(`/api/destinations/by-origin/${selectedOrigin}`)
        .then(res => res.json())
        .then(data => {
          destinationSelect.innerHTML = '<option value="">انتخاب مقصد...</option>';
          data.forEach(item => {
            const option = document.createElement('option');
            option.value = item.destination;
            option.text = item.destination;
            destinationSelect.appendChild(option);
          });
        })
        .catch(err => console.error('خطا در دریافت مقصدها:', err));
    });

   
    addBtn.addEventListener('click', () => {
      const selectedId = destinationSelect.value;
      const selectedText = destinationSelect.options[destinationSelect.selectedIndex].text;

      if (!selectedId) return alert('لطفاً یک مقصد انتخاب کنید.');

      const exists = Array.from(selectedList.querySelectorAll('input[name="destinations[]"]'))
        .some(input => input.value === selectedId);
      if (exists) return alert('این مقصد قبلا اضافه شده است.');

      const li = document.createElement('li');
      li.className = "flex justify-between items-center bg-gray-100 px-4 py-2 rounded";
      li.innerHTML = `
        <span>${selectedText}</span>
        <input type="hidden" name="destinations[]" value="${selectedId}">
        <button type="button" class="text-red-600 hover:text-red-800 remove-btn">حذف</button>
      `;
      li.querySelector('.remove-btn').addEventListener('click', () => li.remove());
      selectedList.appendChild(li);

      destinationSelect.value = "";
    });

    // Modal open/close
    document.getElementById('openDestinationModalBtn').addEventListener('click', () => modal.classList.remove('hidden'));
    document.getElementById('closeDestinationModalBtn').addEventListener('click', () => modal.classList.add('hidden'));

    // ثبت مسیر جدید
    document.getElementById('saveDestinationBtn').addEventListener('click', async () => 
     {
      const origin = document.getElementById('modal_origin').value;
      const destination = document.getElementById('modal_destination').value;
      const distonce = document.getElementById('modal_distance').value;
      if (!origin || !destination || !distonce) {
        return alert('لطفاً تمام فیلدهای مسیر را پر کنید.');
      }

      try {
        const response = await fetch("{{ route('destination.store') }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify({ origin, destination, distonce })
        });
    

        const result = await response.json();
        console.log(result);
        if (response.ok && result.success) {
          alert(result.message);
          modal.classList.add('hidden');
          document.getElementById('modal_origin').value = '';
          document.getElementById('modal_destination').value = '';
          document.getElementById('modal_distance').value = '';
          // در صورت نیاز لیست مبدا و مقصد دوباره بارگذاری شود
        } else {
          alert(result.message || 'خطا در ثبت مسیر');
        }
      } catch (error) {
        alert('خطا در ارتباط با سرور');
        console.error(error);
      }
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const carTypeSelect = document.getElementById('car_type');
      const carSelect = document.getElementById('car_select');
  
      carTypeSelect.addEventListener('change', function () {
        const selectedType = this.value;
           // خالی کردن لیست قبلی خودروها
        carSelect.innerHTML = '<option value="">در حال دریافت خودروها...</option>';
        const firstDestinationInput = document.querySelector('input[name="destinations[]"]');
        const firstDestination = firstDestinationInput ? firstDestinationInput.value : '';
      
        if (selectedType !== '' && firstDestination !== '') {
          
          fetch(`/get-cars-by-type/${selectedType}?destination=${firstDestination}`)
            .then(response => response.json())
            .then(cars => {
              carSelect.innerHTML = '<option value="">یک خودرو را انتخاب کنید</option>';
              cars.forEach(car => {
                const option = document.createElement('option');
                option.value = car.id;
                option.textContent = car.car_plate;
                carSelect.appendChild(option);
              });
            })
            .catch(error => {
              console.error('خطا در دریافت خودروها:', error);
              carSelect.innerHTML = '<option value="">خطا در دریافت خودروها</option>';
            });
        } else {
          carSelect.innerHTML = '<option value="">ابتدا نوع کاربری را انتخاب کنید</option>';
        }
      });
    });
</script>*/
<script>
    document.addEventListener('DOMContentLoaded', function () {
      const carTypeSelect = document.getElementById('car_type');
      const carSelect = document.getElementById('car_select');
      const carInfoBox = document.getElementById('car_info');
    
      carTypeSelect.addEventListener('change', function () {
        const selectedType = this.value;
        carSelect.innerHTML = '<option value="">در حال دریافت خودروها...</option>';
     const firstDestinationInput = document.querySelector('input[name="destinations[]"]');
        const firstDestination = firstDestinationInput ? firstDestinationInput.value : '';
      
          if (selectedType !== '' && firstDestination !== '') {
          
          fetch(`/get-cars-by-type/${selectedType}?destination=${firstDestination}`)
                .then(response => response.json())
            .then(cars => {
              carSelect.innerHTML = '<option value="">یک خودرو را انتخاب کنید</option>';
              cars.forEach(car => {
                const option = document.createElement('option');
                option.value = car.id;
                option.textContent = car.car_plate;
                carSelect.appendChild(option);
              });
            })
            .catch(error => {
              console.error('خطا در دریافت خودروها:', error);
              carSelect.innerHTML = '<option value="">خطا در دریافت خودروها</option>';
            });
        } else {
          carSelect.innerHTML = '<option value="">ابتدا نوع کاربری را انتخاب کنید</option>';
        }
      });
    
     
      carSelect.addEventListener('change', function () {
        const carId = this.value;
    
        if (!carId) {
          carInfoBox.classList.add('hidden');
          carInfoBox.innerHTML = '';
          return;
        }
    
        fetch(`/get-car-info/${carId}`)
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              const car = data.car;
              carInfoBox.classList.remove('hidden');
              carInfoBox.innerHTML = `
                خودروی <strong>${car.car_model}</strong> با رانندگی آقای <strong>${car.driver_name}</strong> انتخاب شد.
                <a href="#" id="changeDriverBtn" class="text-blue-700 underline ml-2">تغییر راننده</a>
              `;
            } else {
              carInfoBox.classList.add('hidden');
              carInfoBox.innerHTML = '';
            }
          })
          .catch(error => {
            console.error('خطا در دریافت اطلاعات خودرو:', error);
            carInfoBox.classList.add('hidden');
            carInfoBox.innerHTML = '';
          });
      });
    });
    
    document.addEventListener('click', function (e) {
      if (e.target && e.target.id === 'changeDriverBtn') {
        e.preventDefault();
    
        const carId = document.getElementById('car_select').value;
    
        fetch(`/get-car-info/${carId}`)
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              const car = data.car;
    
              // پر کردن اطلاعات خودرو
              document.getElementById('modalCarInfo').innerHTML = `
                <p><strong>مدل:</strong> ${car.car_model}</p>
                <p><strong>پلاک:</strong> ${car.car_plate}</p>
                <p><strong>مالک:</strong> ${car.owner_name} ${car.owner_lsetname}</p>
                <p><strong>شماره ملی:</strong> ${car.owner_nationl_id}</p>
                <p><strong>شماره تماس:</strong> ${car.owner_phonenumber}</p>
              `;
    
              // پر کردن راننده‌ها
              const driverSelect = document.getElementById('driverSelect');
              driverSelect.innerHTML = ''; // پاک کردن قبلی
    
              fetch('/get-all-drivers')
                .then(response => response.json())
                .then(drivers => {
                  drivers.forEach(driver => {
                    const option = document.createElement('option');
                    option.value = driver.id;
                    option.textContent = `${driver.name} ${driver.last_name}`;
                    if (driver.id === car.driver_id) option.selected = true;
                    driverSelect.appendChild(option);
                  });
                  // نمایش مودال
                  document.getElementById('changeDriverModal').classList.remove('hidden');
                });
            }
          })
          .catch(err => {
            console.error('خطا در دریافت اطلاعات خودرو:', err);
          });
      }
    });
    
    

  </script>
  <script>
    document.getElementById('submitChange').addEventListener('click', function() {
      // گرفتن شناسه خودرو و شناسه راننده جدید
      const carId = document.getElementById('car_select').value;
      const newDriverId = document.getElementById('driverSelect').value;
    
      if (!carId || !newDriverId) {
        alert('لطفا خودرو و راننده را انتخاب کنید.');
        return;
      }
    
      // فرستادن درخواست به سرور
      fetch(`/update-car-driver/${carId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ driver_id: newDriverId })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alert('راننده با موفقیت تغییر کرد!');
          // بستن مودال
          document.getElementById('changeDriverModal').classList.add('hidden');
        
          // گرفتن اطلاعات جدید خودرو و آپدیت نمایش
          fetch(`/get-car-info/${carId}`)
            .then(res => res.json())
            .then(data => {
              if (data.success) {
                const car = data.car;
                const carInfoBox = document.getElementById('car_info');
                carInfoBox.classList.remove('hidden');
                carInfoBox.innerHTML = `
                  خودروی <strong>${car.car_model}</strong> با رانندگی آقای <strong>${car.driver_name}</strong> انتخاب شد.
                  <a href="#" id="changeDriverBtn" class="text-blue-700 underline ml-2">تغییر راننده</a>
                `;
              }
            });
        }
         else {
          alert('خطا در تغییر راننده');
        }
      })
      .catch(() => alert('خطا در ارتباط با سرور'));
    });
    
    document.addEventListener('DOMContentLoaded', function () {
      const closeBtn = document.getElementById('cancelChange');
      const modal = document.getElementById('changeDriverModal');
  
      if (closeBtn && modal) {
          closeBtn.addEventListener('click', function () {
              modal.classList.add('hidden');
          });
      }
  });
      
</script>
  
</body>
</html>