<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserCart;
use App\Models\UserOrders;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PlaceOrderRequest;

class UserCartController extends Controller
{

    public function index()
    {
       return Inertia::render('UserCarts', [
            'usercarts' => UserCart::where('user_id',Auth::id())
            ->where('is_booked',0)
            ->with(['products'=> function($que){
                $que->select('id','title','description','price');
            }])->get()
        ]);
    }

    public function store(Request $request)
    {
        $quantity = 0;
        $exists = UserCart::where('product_id',$request->get('id'))
        ->where('user_id',Auth::id())->where('is_booked',0)->first();

        if($exists){
            $quantity = (int)$exists->quantity + 1;
            UserCart::where('product_id',$request->get('id'))
            ->where('user_id',Auth::id())
            ->where('is_booked',0)
            ->update(['quantity'=>$quantity]);
        }else{
            $inputs['product_id'] = $request->get('id');
            $inputs['user_id'] = Auth::id();
            UserCart::create($inputs);
        }

        return redirect()->back()->with('message', 'Added to cart!');
    }

    public function delete(Request $request)
    {
        UserCart::find($request->input('id'))->delete();
        return redirect()->back()->with('message', 'successfully deleted!');
    }

    public function placeOrder(PlaceOrderRequest $request)
    {
        $inputs = $request->all();
        $inputs['user_id'] = Auth::id();
        $inputs['price'] = $this->cartAmountClculation($inputs);

        $isOrdered = UserOrders::create($inputs);
        if($isOrdered){
            UserCart::where('user_id',Auth::id())
            ->where('is_booked',0)
            ->update(['is_booked'=>1,'order_id'=>$isOrdered->id]);
        }
        return redirect()->back()->with('message', 'successfully created!');
    }

    public function cartAmountClculation($inputs){
        $amount = 0;
        $selectedProducts = UserCart::where('user_id',$inputs['user_id'])
        ->where('is_booked',0)
        ->with(['products'=> function($que){
            $que->select('id','price');
        }])
        ->get();

        foreach($selectedProducts as $product){
            $amount = $amount + ($product->products->price * $product->quantity);
        }

        return $amount;
    }

}
