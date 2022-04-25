<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserOrders;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    public function index()
    {

       return Inertia::render('UserOrders', [
            'orders' => UserOrders::where('user_id',Auth::id())
            ->with(['userCart'=> function($que){
                $que->select('id','user_id','product_id','order_id','quantity');
            },'userCart.products'=> function($que){
                $que->select('id','title','description','price');
            }])->orderBy('id','desc')->get()
        ]);
    }
}
