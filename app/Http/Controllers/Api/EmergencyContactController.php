<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmergencyContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class EmergencyContactController extends Controller
{
    /**
     * عرض كل جهات الاتصال الخاصة بالمستخدم الحالي
     */
    public function index()
    {
        // جلب جهات الاتصال المرتبطة باليوزر المسجل فقط
        $contacts = EmergencyContact::where('user_id', Auth::id())->get();
        
        return response()->json([
            'status' => true,
            'contacts' => $contacts
        ], 200);
    }

    /**
     * إضافة جهة اتصال جديدة (Trusted Contact)
     */
    public function store(Request $request)
    {
        // 1. التحقق من البيانات بناءً على الـ UI الجديد
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'phone'      => 'required|string|max:20',
            'relation'   => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, 
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. منطق معالجة رقم الهاتف (تم التعديل ليتناسب مع UltraMsg بدون علامة +)
        $phone = $request->phone;
        
        // إزالة أي مسافات أو علامات زائد قد يدخلها المستخدم بالخطأ
        $phone = str_replace(['+', ' '], '', $phone);

        if (str_starts_with($phone, '0')) {
            // تحويل 01551471747 إلى 201551471747
            $phone = '2' . $phone; 
        } elseif (!str_starts_with($phone, '20')) {
            // لو الرقم بدأ بـ 155 علطول، بنحطله 20 في الأول
            $phone = '20' . $phone;
        }

        // 3. تخزين البيانات في الأعمدة الجديدة
        $contact = EmergencyContact::create([
            'user_id'    => Auth::id(), 
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'phone'      => $phone,
            'relation'   => $request->relation,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Contact Added Successfully!',
            'contact' => $contact
        ], 201);
    }

    /**
     * حذف جهة اتصال
     */
    public function destroy($id)
    {
        // التأكد أن جهة الاتصال تخص المستخدم الحالي قبل الحذف
        $contact = EmergencyContact::where('user_id', Auth::id())->find($id);

        if (!$contact) {
            return response()->json([
                'status' => false, 
                'message' => 'Contact not found'
            ], 404);
        }

        $contact->delete();

        return response()->json([
            'status' => true, 
            'message' => 'Contact deleted successfully'
        ], 200);
    }
}