<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SafetyTimer;
use App\Http\Controllers\Api\AlertController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSafetyTimers extends Command
{
    /**
     * اسم الأمر اللي هنشغله به في الـ Terminal
     */
    protected $signature = 'app:check-safety-timers';

    /**
     * وصف الأمر
     */
    protected $description = 'التحقق من التايمر وإرسال استغاثة لو انتهى الوقت واليوزر مأكدش سلامته';

    /**
     * تنفيذ المنطق البرمجي
     */
    public function handle()
    {
        // 1. البحث عن التايمرز النشطة والمنتهية في اللحظة دي
        $expiredTimers = SafetyTimer::where('status', 'active')
            ->where('expires_at', '<=', now())
            ->get();

        if ($expiredTimers->isEmpty()) {
            $this->info('لا توجد تايمرز منتهية حالياً.');
            return;
        }

        foreach ($expiredTimers as $timer) {
            // 2. تحديث الحالة لـ triggered عشان ميبعتش رسائل مكررة
            $timer->update(['status' => 'triggered']);

            // 3. محاكاة عملية الاستغاثة أوتوماتيكياً
            // بنجهز Controller الاستغاثة وبنمرر له بيانات افتراضية للوكيشن
            $alertController = new AlertController();
            
            $request = new Request([
                'lat' => '31.0415', 
                'long' => '31.3547'
            ]);

            // ربط اليوزر صاحب التايمر بالـ Auth عشان الكود يعرف هيبعت لمنقذين مين
            Auth::setUser($timer->user);
            
            // تنفيذ دالة الإرسال اللي عملناها قبل كدة
            $alertController->sendAlert($request);

            $this->info("تم إرسال استغاثة تلقائية لليوزر: " . $timer->user->name);
        }
    }
}