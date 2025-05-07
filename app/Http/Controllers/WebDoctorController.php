<?php

namespace App\Http\Controllers;

use App\Models\doctor;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;

class WebDoctorController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, DispatchesJobs;
    
    /**
     * عرض قائمة الأطباء للزوار
     */
    public function index(Request $request)
    {
        $query = doctor::query();
        
        // البحث حسب الاسم
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            
            // تنظيف مصطلح البحث وإزالة الأحرف الخاصة
            $searchTerm = trim($searchTerm);
            
            $query->where(function($q) use ($searchTerm) {
                // البحث في الاسم والتخصص بشكل أكثر مرونة
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('specialty', 'like', '%' . $searchTerm . '%');
                  
                // البحث في أجزاء الاسم (للأسماء المركبة)
                $nameParts = explode(' ', $searchTerm);
                foreach ($nameParts as $part) {
                    if (strlen($part) > 2) { // تجاهل الكلمات القصيرة جدًا
                        $q->orWhere('name', 'like', '%' . $part . '%');
                    }
                }
            });
        }
        
        // التصفية حسب التخصص
        if ($request->has('specialty') && !empty($request->specialty) && $request->specialty != 'كل التخصصات') {
            $query->where('specialty', $request->specialty);
        }
        
        // ترتيب النتائج
        $query->orderBy('name', 'asc');
        
        $doctors = $query->paginate(6);
        
        // الحصول على قائمة التخصصات المتاحة
        $specialties = doctor::distinct('specialty')->pluck('specialty')->toArray();
        
        return view('webdoctor.index', compact('doctors', 'specialties'));
    }
    
    /**
     * عرض تفاصيل طبيب معين
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $doctor = doctor::findOrFail($id);
        return view('webdoctor.show', compact('doctor'));
    }
    
    /**
     * البحث عن الأطباء
     */
    public function search(Request $request)
    {
        return $this->index($request);
    }
    
    /**
     * تشخيص البحث (للمطورين فقط)
     */
    public function debug(Request $request)
    {
        // التحقق من وجود مستخدم مسجل الدخول
        if (!auth()->check()) {
            abort(403);
        }
        
        $searchTerm = $request->search;
        $results = [];
        
        if ($searchTerm) {
            // البحث المباشر
            $directMatch = doctor::where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('specialty', 'like', '%' . $searchTerm . '%')
                ->get();
                
            // البحث في أجزاء الاسم
            $nameParts = explode(' ', $searchTerm);
            $partialMatches = collect();
            
            foreach ($nameParts as $part) {
                if (strlen($part) > 2) {
                    $matches = doctor::where('name', 'like', '%' . $part . '%')->get();
                    $partialMatches = $partialMatches->merge($matches);
                }
            }
            
            $partialMatches = $partialMatches->unique('id');
            
            $results = [
                'search_term' => $searchTerm,
                'direct_matches' => $directMatch->map(function($doc) {
                    return ['id' => $doc->id, 'name' => $doc->name, 'specialty' => $doc->specialty];
                }),
                'partial_matches' => $partialMatches->map(function($doc) {
                    return ['id' => $doc->id, 'name' => $doc->name, 'specialty' => $doc->specialty];
                })
            ];
        }
        
        // جميع الأطباء
        $allDoctors = doctor::all()->map(function($doc) {
            return ['id' => $doc->id, 'name' => $doc->name, 'specialty' => $doc->specialty];
        });
        
        return response()->json([
            'results' => $results,
            'all_doctors' => $allDoctors,
            'total_doctors' => count($allDoctors)
        ]);
    }
}

