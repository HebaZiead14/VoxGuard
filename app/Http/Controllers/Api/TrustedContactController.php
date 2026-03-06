<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrustedContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TrustedContactController extends Controller
{
    /**
     * 1. عرض قائمة جهات الاتصال (Trusted Contacts List)
     * مطابقة تماماً لشاشة "Trusted" في الصورة
     */
    public function index()
    {
        // جلب جهات الاتصال الخاصة بالمستخدم الحالي
        $contacts = TrustedContact::where('user_id', Auth::id())->get();
        
        return response()->json([
            'status' => true,
            'contacts' => $contacts
        ], 200);
    }

    /**
     * 2. إضافة جهة اتصال جديدة (Add Contact)
     * مطابقة لشاشة الإضافة: الاسم الأول، الأخير، العلاقة، والرقم
     */
    public function store(Request $request)
    {
        // ملاحظة: التصميم يفصل الاسم الأول والأخير، لكننا سنخزنهم معاً كما في الـ Postman
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:100', // الاسم بالكامل
            'phone'    => 'required|string|max:20',  // رقم الموبايل
            'relation' => 'required|string|max:50',  // صلة القرابة (Relationship)
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, 
                'errors' => $validator->errors()
            ], 422);
        }

        $contact = TrustedContact::create([
            'user_id'   => Auth::id(), 
            'name'      => $request->name,
            'phone'     => $request->phone,
            'relation'  => $request->relation,
            'is_online' => false, // القيمة الافتراضية
            'status'    => 'offline', // الحالة التي تظهر في التصميم
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Trusted Contact Added Successfully!',
            'contact' => $contact
        ], 201);
    }

    /**
     * 3. إرسال الموقع المباشر (SOS Live Location)
     * ترسل رابط الخريطة كـ Live Location وقت الخطر
     */
    public function sendLocation(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        // توليد رابط جوجل ماب ليكون "Live Location"
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
     * يتم استخدامه لتسجيل الدليل وقت وقوع حادثة
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