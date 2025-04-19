<?php

namespace App\Http\Controllers;
use App\Models\OrderItem;
use App\Models\Order;

use Illuminate\Http\Request;

class ShowOrederController extends Controller
{
    /**
     * عرض قائمة الطلبات في لوحة التحكم
     */
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * عرض تفاصيل طلب محدد
     */
    public function show($id)
    {
        $order = Order::with('items.medicine')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
    
    /**
     * تغيير حالة الطلب
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,canceled',
        ]);
        
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        
        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }
    
    /**
     * تصدير قائمة الطلبات إلى ملف Excel/CSV
     */
    public function export()
    {
        $orders = Order::with('items')->orderBy('created_at', 'desc')->get();
        
        // يمكن استكمال هذه الوظيفة لاحقًا لتصدير البيانات
        // باستخدام مكتبات مثل Laravel Excel
        
        return back()->with('info', 'سيتم تفعيل وظيفة التصدير قريبًا');
    }
    
    /**
     * البحث في الطلبات
     */
    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        
        $orders = Order::where('id', 'LIKE', "%$keyword%")
            ->orWhere('customer_name', 'LIKE', "%$keyword%")
            ->orWhere('customer_phone', 'LIKE', "%$keyword%")
            ->orWhere('customer_email', 'LIKE', "%$keyword%")
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.orders.index', compact('orders', 'keyword'));
    }
}
