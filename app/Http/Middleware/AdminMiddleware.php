<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // التحقق من تسجيل الدخول
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        // التحقق من صلاحية المستخدم
        if (Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }
        
        return $next($request);
    }
} 