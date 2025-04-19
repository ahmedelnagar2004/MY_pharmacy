<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_email',
        'address',
        'delivery_method',
        'notes',
        'status',
        'total_price',
    ];

    /**
     * علاقة الطلب بعناصره
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
