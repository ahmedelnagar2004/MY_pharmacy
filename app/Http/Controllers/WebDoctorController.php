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
    public function index()
    {
        $doctors = doctor::paginate(6);
        return view('webdoctor.index', compact('doctors'));
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
}
