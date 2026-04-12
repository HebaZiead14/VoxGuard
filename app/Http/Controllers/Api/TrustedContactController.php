<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrustedContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // مكتبة إرسال طلبات الـ API

class TrustedContactController extends Controller
{

    public function index()
    {
        // 1. جلب الـ ID الخاص بالمستخدم الحالي من التوكن
        $userId = auth('sanctum')->id();

        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // 2. جلب جهات الاتصال المرتبطة باليوزر ده
        $contacts = TrustedContact::where('user_id', $userId)->get()->map(function ($contact) use ($userId) {

            $user = auth('sanctum')->user();

            // تعديل السطر ده: حذفنا البحث عن 'phone' وسيبنا 'phone_number' فقط
            $registeredUser = \App\Models\User::where('phone_number', $contact->phone)->first();

            $contact->status = 'offline';
            $contact->is_nearby = false;

            if ($registeredUser) {
                $contact->name = $registeredUser->first_name . ' ' . $registeredUser->last_name;

                $isOnline = $registeredUser->last_seen && \Carbon\Carbon::parse($registeredUser->last_seen)->diffInMinutes(now()) < 5;
                if ($isOnline) {
                    $contact->status = 'online';
                }

                if ($user && $user->latitude && $user->longitude && $registeredUser->latitude && $registeredUser->longitude) {
                    $distance = $this->calculateDistance(
                        $user->latitude,
                        $user->longitude,
                        $registeredUser->latitude,
                        $registeredUser->longitude
                    );

                    if ($distance < 1) {
                        $contact->status = 'Nearby';
                        $contact->is_nearby = true;
                    }
                }
            }

            if ($contact->image) {
                $contact->image = asset('storage/' . $contact->image);
            }

            return $contact;
        });

        return response()->json([
            'status' => true,
            'contacts' => $contacts
        ], 200);
    }
    /**
     * دالة مساعدة لحساب المسافة الجغرافية
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // بالكيلومترات

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
    // دالة حساب المسافة (المعادلة الرياضية)

    /**
     * 2. إضافة جهة اتصال جديدة (Add Contact)
     * تشمل: حفظ البيانات + رفع الصورة + إرسال ترحيب واتساب
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'relation' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // التحقق من الصورة
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // --- معالجة رفع الصورة ---
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('contacts', 'public');
        }

        $contact = TrustedContact::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'relation' => $request->relation,
            'image' => $imagePath,
            'is_online' => false,
            'status' => 'offline',
        ]);

        // --- إرسال رسالة ترحيب للأهل عبر الواتساب (UltraMsg) ---
        try {
            $userName = Auth::user()->first_name ?? 'إحدى المستخدمات';
            $targetPhone = $contact->phone;

            // التأكد من إضافة الكود الدولي لمصر (+2) للرقم
            if (!str_starts_with($targetPhone, '+')) {
                $targetPhone = '+2' . $targetPhone;
            }

            Http::post("https://api.ultramsg.com/instance165616/messages/chat", [
                'token' => '4lymfep8kl3apijw',
                'to' => $targetPhone,
                'body' => "مرحباً، تم إضافتك كجهة اتصال طوارئ لـ ($userName) في تطبيق VoxGuard للحماية. ستصلك رسائلنا في حالة طلب الاستغاثة."
            ]);
        } catch (\Exception $e) {
            // في حالة فشل الإرسال (مثلاً لا يوجد إنترنت) يستمر الكود ولا يعطي خطأ
        }

        return response()->json([
            'status' => true,
            'message' => 'Trusted Contact Added Successfully and Notified!',
            'contact' => $contact
        ], 201);
    }

    /**
     * 3. إرسال الموقع المباشر (SOS Live Location)
     */
    public function sendLocation(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        // الرابط الصحيح الذي يفتح خرائط جوجل مباشرة عند الضغط عليه
        $mapUrl = "https://www.google.com/maps?q={$request->lat},{$request->lng}";

        return response()->json([
            'status' => true,
            'live_location' => $mapUrl,
            'message' => 'Live location link ready to be sent.'
        ]);
    }

    /**
     * 4. حذف جهة اتصال
     */
    public function destroy($id)
    {
        $contact = TrustedContact::where('user_id', Auth::id())->find($id);

        if (!$contact) {
            return response()->json(['status' => false, 'message' => 'Contact not found'], 404);
        }

        $contact->delete();
        return response()->json(['status' => true, 'message' => 'Deleted successfully'], 200);
    }

    /**
     * 5. رفع وسائط الـ SOS (فيديو أو أوديو)
     */
    /**
     * رفع تسجيل الـ SOS الصوتي (Evidence Audio)
     * يتم استخدامه لتسجيل ما يحدث حول البنت كدليل صوتي
     */
    public function uploadSosMedia(Request $request)
    {
        // التأكد من وجود فيديو أو أوديو
        $request->validate([
            'video' => 'nullable|file|mimes:mp4,mov,avi',
            'audio' => 'nullable|file|mimes:mp3,wav',
        ]);

        // كود حفظ الملفات
        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('sos_videos', 'public');
            return response()->json(['status' => true, 'message' => 'Video Uploaded!', 'path' => $path]);
        }

        if ($request->hasFile('audio')) {
            $path = $request->file('audio')->store('sos_audios', 'public');
            return response()->json(['status' => true, 'message' => 'Audio Uploaded!', 'path' => $path]);
        }

        return response()->json(['status' => false, 'message' => 'No media uploaded']);
    }

}