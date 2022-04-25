<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\UserCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProductRequest;
use Inertia\Inertia;

class ProductController extends Controller
{

    public function trigerFactory()
    {
        $products = Products::factory()->count(10)->make();
        Products::insert($products->toArray());
        return redirect()->back()->with('message', 'successfully created!');
    }

    public function index()
    {
       return Inertia::render('Product', [
            'products' => Products::all()
        ]);
    }
    //Dashboard products listing
    public function dashboard(){
        return Inertia::render('Dashboard', [
            'products' => Products::all()
        ]);
    }

    public function store(ProductRequest $request)
    {
        Products::create($request->all());
        return redirect()->back()->with('message', 'successfully created!');
    }

    public function update(ProductRequest $request)
    {
        if ($request->has('id')) {
            Products::find($request->input('id'))->update($request->all());
            return redirect()->back()->with('message', 'successfully updated!');
        }
    }

    public function delete(Request $request)
    {
        Products::find($request->input('id'))->delete();
        //Remove product from cart
        UserCart::where('product_id',$request->input('id'))->where('is_booked',0)->delete();
        return redirect()->back()->with('message', 'successfully deleted!');
    }


}
