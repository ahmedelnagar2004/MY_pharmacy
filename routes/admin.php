<?php

// use App\Http\Controllers\Admin\AdminController;
// use App\Http\Controllers\AppointmentController;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Auth\AuthenticatedAdminSessionController;
// use App\Http\Controllers\ShowOrederController;

// Route::middleware('guest')->prefix('admin')->name('admin.')->group(function () {
//  //   Route::get('register', [RegisteredUserController::class, 'create'])
// //        ->name('register');

//  //   Route::post('register', [RegisteredUserController::class, 'store']);

//     Route::get('login', [AuthenticatedAdminSessionController::class, 'create'])
//         ->name('login');

//     Route::post('login', [AuthenticatedAdminSessionController::class, 'store']);

//   //  Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
//     //    ->name('password.request');

//     //Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
//       //  ->name('password.email');

//     //Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
//       //  ->name('password.reset');

//    // Route::post('reset-password', [NewPasswordController::class, 'store'])
//      //   ->name('password.store')});

// //Route::middleware('auth')->group(function () {
//   //  Route::get('verify-email', EmailVerificationPromptController::class)
//     //    ->name('verification.notice');

//     //Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
//       //  ->middleware(['signed', 'throttle:6,1'])
//         //->name('verification.verify');

//     //Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//         //->middleware('throttle:6,1')
//         //->name('verification.send');

//     //Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
//       //  ->name('password.confirm');

//     //Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

//   //  Route::put('password', [PasswordController::class, 'update'])->name('password.update');

//   //  Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
//     //    ->name('logout');
// });
// Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
//     Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
//     // مسارات إدارة الحجوزات
//     Route::get('/appointments', [AppointmentController::class, 'index'])->name('admin.appointments.index');
//     Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->name('admin.appointments.show');
//     Route::patch('/appointments/{id}/status', [AppointmentController::class, 'updateStatus'])->name('admin.appointments.update-status');
//     Route::get('/orders', [ShowOrederController::class, 'index'])->name('admin.orders.index');
//     Route::get('/orders/{id}', [ShowOrederController::class, 'show'])->name('admin.orders.show');
//     Route::put('/orders/{id}/status', [ShowOrederController::class, 'updateStatus'])->name('admin.orders.update-status');
//     Route::get('/orders-search', [ShowOrederController::class, 'search'])->name('admin.orders.search');
//     Route::get('/orders-export', [ShowOrederController::class, 'export'])->name('admin.orders.export');
// });



