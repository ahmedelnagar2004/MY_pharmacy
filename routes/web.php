<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ConsultController;
use App\Http\Controllers\WebDoctorController;
use App\Http\Controllers\MedicienController;
use App\Http\Controllers\WebMedicienController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ShowOrederController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// الصفحات العامة
Route::get('/doctors', [WebDoctorController::class, 'index'])->name('webdoctor.index');
Route::get('/doctors/{id}', [WebDoctorController::class, 'show'])->name('webdoctor.show');
Route::get('/medicines', [WebMedicienController::class, 'index'])->name('webmedicien.index');
Route::get('/medicines/search', [WebMedicienController::class, 'search'])->name('webmedicien.search');
Route::get('/medicines/{id}', [WebMedicienController::class, 'show'])->name('webmedicien.show');
Route::post('/orders', [WebMedicienController::class, 'storeOrder'])->name('orders.store');
Route::get('/orders/status', [WebMedicienController::class, 'orderStatus'])->name('orders.status');
Route::post('/orders/check', [WebMedicienController::class, 'checkOrder'])->name('orders.check');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // مسارات الأطباء
    Route::resource('doctor', DoctorController::class);
    
    // مسارات الأدوية
    Route::resource('medicien', MedicienController::class);
    
    // مسارات الاستشاريين
    Route::get('/consult/doctor', [ConsultController::class, 'doctor'])->name('consult.doctor');
});

// مسارات الحجوزات العامة
Route::get('/appointments', [AppointmentController::class, 'create'])->name('appointments.index');
Route::get('/appointments/create/{doctor_id?}', [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/appointments/success/{id}', [AppointmentController::class, 'success'])->name('appointments.success');

// مسارات لوحة التحكم الإدارية - متاحة فقط للإدارة
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // مسارات إدارة الحجوزات
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('admin.appointments.index');
    Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->name('admin.appointments.show');
    Route::patch('/appointments/{id}/status', [AppointmentController::class, 'updateStatus'])->name('admin.appointments.update-status');
});

// مسارات إدارة المستخدمين
Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'user'])->name('users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

// مسارات لوحة تحكم الأدمن
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // مسارات إدارة الطلبات
    Route::get('/orders', [ShowOrederController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{id}', [ShowOrederController::class, 'show'])->name('admin.orders.show');
    Route::put('/orders/{id}/status', [ShowOrederController::class, 'updateStatus'])->name('admin.orders.update-status');
    Route::get('/orders-search', [ShowOrederController::class, 'search'])->name('admin.orders.search');
    Route::get('/orders-export', [ShowOrederController::class, 'export'])->name('admin.orders.export');
});

// تضمين ملف مسارات المصادقة
require __DIR__.'/auth.php';
