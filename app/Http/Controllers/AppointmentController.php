<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * عرض نموذج الحجز
     */
    public function create($doctor_id = null)
    {
        $doctors = Doctor::all();
        $selectedDoctor = null;
        
        if ($doctor_id) {
            $selectedDoctor = Doctor::findOrFail($doctor_id);
        }
        
        return view('appointments.create', [
            'doctors' => $doctors,
            'selectedDoctor' => $selectedDoctor
        ]);
    }

    /**
     * حفظ الحجز الجديد
     */
    public function store(Request $request)
    {
        // التحقق من البيانات المدخلة
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'notes' => 'nullable|string',
        ]);
        
        // إنشاء الحجز الجديد
        $appointment = Appointment::create([
            'patient_name' => $request->patient_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);
        
        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('appointments.success', $appointment->id)
                         ->with('success', 'تم حجز موعدك بنجاح، سيتم التواصل معك لتأكيد الحجز.');
    }

    /**
     * عرض صفحة نجاح الحجز
     */
    public function success($id)
    {
        $appointment = Appointment::with('doctor')->findOrFail($id);
        return view('appointments.success', compact('appointment'));
    }
    
    /**
     * عرض قائمة الحجوزات (للإدارة فقط)
     */
    public function index()
    {
        $appointments = Appointment::with('doctor')->latest()->paginate(10);
        return view('admin.appointments.index', compact('appointments'));
    }
    
    /**
     * عرض تفاصيل الحجز (للإدارة فقط)
     */
    public function show($id)
    {
        $appointment = Appointment::with('doctor')->findOrFail($id);
        return view('admin.appointments.show', compact('appointment'));
    }
    
    /**
     * تحديث حالة الحجز (للإدارة فقط)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);
        
        $appointment = Appointment::findOrFail($id);
        $appointment->status = $request->status;
        $appointment->save();
        
        return redirect()->route('admin.appointments.index')
                         ->with('success', 'تم تحديث حالة الحجز بنجاح.');
    }
} 