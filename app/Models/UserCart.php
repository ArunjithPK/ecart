<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCart extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'is_booked',
        'quantity'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function products()
    {
        return $this->belongsTo(Products::class,'product_id')->withTrashed();
    }

    public function userOrders()
    {
        return $this->belongsTo(UserOrders::class,'order_id');
    }

}
