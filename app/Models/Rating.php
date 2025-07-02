<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{


    protected $fillable = [
        'doctor_id',
        'user_id',
        'rating',
        'comment',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
