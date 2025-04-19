<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;

class DoctorController extends BaseController
{
    public function index()
    {
        $doctors = doctor::all();
        return view('doctor.index', compact('doctors'));
    }

    public function create()
    {
        return view('doctor.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specialty' => 'required|string|max:225',
            'price' => 'required',
            'number' => 'required'
        ]);
        
        $doctor = new doctor($validatedData);
        
        // معالجة الصورة الرئيسية
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('doctors', 'public');
            $doctor->image = $imagePath;
        }
        
        // معالجة الصور الإضافية
        for ($i = 1; $i <= 5; $i++) {
            $imageField = "image-$i";
            if ($request->hasFile($imageField)) {
                $imagePath = $request->file($imageField)->store('doctors', 'public');
                $doctor->{$imageField} = $imagePath;
            }
        }
        
        $doctor->save();
        return redirect()->route('doctor.index')->with('success', 'تم إضافة الطبيب بنجاح');
    }
    
    public function edit(string $id)
    {
        $doctor = doctor::findOrFail($id);
        return view('doctor.edit', compact('doctor'));
    }
    
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specialty' => 'required|string|max:255',
            'price' => 'required',
            'number' => 'required'
        ]);
        
        $doctor = doctor::findOrFail($id);
        $doctor->name = $validatedData['name'];
        $doctor->specialty = $validatedData['specialty'];
        $doctor->price = $validatedData['price'];
        $doctor->number = $validatedData['number'];
        
        // معالجة الصورة الرئيسية
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا وجدت
            if ($doctor->image) {
                Storage::disk('public')->delete($doctor->image);
            }
            
            $imagePath = $request->file('image')->store('doctors', 'public');
            $doctor->image = $imagePath;
        }
        
        // معالجة الصور الإضافية
        for ($i = 1; $i <= 5; $i++) {
            $imageField = "image-$i";
            if ($request->hasFile($imageField)) {
                // حذف الصورة القديمة إذا وجدت
                if ($doctor->{$imageField}) {
                    Storage::disk('public')->delete($doctor->{$imageField});
                }
                
                $imagePath = $request->file($imageField)->store('doctors', 'public');
                $doctor->{$imageField} = $imagePath;
            }
        }
        
        $doctor->save();
        return redirect()->route('doctor.index')->with('success', 'تم تحديث بيانات الطبيب بنجاح');
    }

    public function destroy(string $id)
    {
        $doctor = doctor::findOrFail($id);
        
        // حذف الصور
        if ($doctor->image) {
            Storage::disk('public')->delete($doctor->image);
        }
        
        for ($i = 1; $i <= 5; $i++) {
            $imageField = "image-$i";
            if ($doctor->{$imageField}) {
                Storage::disk('public')->delete($doctor->{$imageField});
            }
        }
        
        $doctor->delete();
        return redirect()->route('doctor.index')->with('success', 'تم حذف الطبيب بنجاح');
    }
    
    public function show(string $id)
    {
        $doctor = doctor::findOrFail($id);
        return view('doctor.show', compact('doctor'));
    }
}
