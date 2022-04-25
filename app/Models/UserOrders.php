<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserOrders extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'price',
        'phone',
        'delivery_address',
        'is_cancelled'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function userCart()
    {
        return $this->hasMany(UserCart::class,'order_id');
    }
}
