<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Product;
class CartController extends Controller
{
    public function cart(){
        return view('desk.cart')->with('carts',Cart::content());
    }
    public function add(){
        $product = Product::findorfail(request()->product_id);
        $cart = Cart::add($product->id,$product->name,request()->quantity,$product->selling_price);

    }
}
