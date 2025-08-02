<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        // اگر ستون status قبلاً وجود دارد، باید آن را ابتدا حذف یا تغییر دهید
        // به دلیل محدودیت در تغییر enum در بسیاری از دیتابیس‌ها (مثلاً MySQL)، بهتر است ابتدا حذف کنیم:
        Schema::table('missions', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('missions', function (Blueprint $table) {
            $table->enum('status', ['wait', 'inprogress', 'finish'])->after('driver_id');
        });
    }

    public function down(): void
    {
        // برگرداندن به حالت قبل اگر نیاز است
        Schema::table('missions', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('missions', function (Blueprint $table) {
            $table->enum('status', ['wait', 'inprogress'])->after('driver_id'); // فرضاً حالت قبل فقط این دو بود
        });
    }
};
