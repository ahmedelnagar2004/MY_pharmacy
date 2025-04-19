<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'order_id',
        'medicine_id',
        'quantity',
        'price',
        'total',
    ];
    
    /**
     * علاقة عنصر الطلب بالطلب
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    /**
     * علاقة عنصر الطلب بالدواء
     */
    public function medicine()
    {
        return $this->belongsTo(Medicien::class, 'medicine_id');
    }
}
