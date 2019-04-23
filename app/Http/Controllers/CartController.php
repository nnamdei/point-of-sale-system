<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDF;
use Cart;
use Hash;
use Auth;
use Session;
use Carbon\Carbon;
use App\CartDB;
use App\Product;
use App\Traits\CartTrait;
use App\Inventory\StockManager;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    use CartTrait;

    public function __construct(){
        $this->middleware('product-activated');
        $this->middleware('strictly-attendant');

    }

    public function cart(){
        return view('cart.show')->with('cart',Cart::content());
    }

    public function add(Request $request){
        $this->validate($request,[
            'product_id' => ['required'],
            'quantity' => ['required','min: 1']
        ]);

        $product = Product::findorfail($request->product_id);
        $cart_set_up = $this->arrangeCart($product,$request->quantity);
        //dd($cart_set_up);
        if(!empty($cart_set_up['infeasibility'])){
            return redirect()->back()->withErrors($cart_set_up['infeasibility']);
        }
        $cart = Cart::add($cart_set_up['id'],$cart_set_up['name'],$cart_set_up['qty'],$cart_set_up['price'],$cart_set_up['opts'])->associate('App\Product');
        return redirect()->back()->with('success',$cart_set_up['qty'].' of '.$cart_set_up['name'].' added to the cart');
    }

    public function update(Request $request){
        $item = Cart::search(function ($cartItem, $rowId) {
            return $rowId === request()->row_id;
        })->first();

        if($item == null){
            return redirect()->back()->with('error',"The item was not found in the cart");
        }

        $cart_update = $this->arrangeCart($item->model, $request->quantity);

        if(!empty($cart_update['infeasibility'])){
            return redirect()->back()->withErrors($cart_update['infeasibility']);
        }

        $update = Cart::update(request()->row_id, ['qty' => $cart_update['qty']]);
        $update->options = $cart_update['opts'];
        return redirect()->back()->with('success', $cart_update['name'].' updated in the cart');

    }

    public function remove(Request $request){
        $item = Cart::search(function ($cartItem, $rowId) {
            return $rowId === request()->id;
        })->first();
        if($item == null){
            return redirect()->back()->with('error',"The item was not found in the cart");
        }
        Cart::remove(request()->id);
        return redirect()->back()->with('success', $item->name.' removed from cart');
    }

    public function empty(){
        Cart::destroy();
        return redirect()->back()->with('success','cart emptied');
    }

    private function generateID(){
        $date_id = Carbon::now()->format('Ymd');
        $unique_id = substr(Hash::make(time()), 10,7);
        $sanitized_u_id = str_replace('/','_',$unique_id); //remove '/' and replace with '_' because it would cause issues in routing
        $final_id = $date_id.$sanitized_u_id;
        
        $check = DB::table(config('cart.database.table'))->select('identifier')->where('identifier',$final_id)->get();
        if($check->count() > 0){
            return $this->generateID();
        }
        return $final_id;
    }
    public function checkout(){
        $this->validate(request(),[
            'payment_method' => ['required']
        ]);

        if(Cart::count() > 0){
            $cartID = $this->generateID();//generate a unique refrence id for the cart

            Cart::store($cartID);//store the cart in the database for future refrence
            
            // add other details to the cart in the database
            $cart_db = CartDB::where('identifier',$cartID)->firstorfail();
            $cart_db->shop_id = Auth::user()->shop->id;
            $cart_db->user_id = Auth::id();
            $cart_db->payment = request()->payment_method;
            $cart_db->created_at = now();
            $cart_db->save();
    
            //update the product stocks
            foreach(Cart::content() as $item){
                $manager = new StockManager($item->id);
                if($item->model->isSimple()){ 
                    $sale = $manager->addSale($cart_db->id,$item);
                 }
                elseif($item->model->isVariable()){
                        $sale = $manager->updateVariableSales($cart_db->id,$item);
                }
            }
            if(empty($sale['error']))
            {//if there are no errors in recording the sales
                    $receipt = PDF::loadView('desk.templates.sale-receipt', ['cart' => $cart_db,'contents' => Cart::content(), 'tax' => Cart::tax(), 'total' => Cart::total(),'attendant' => Auth::user()->profile()->fullname()]);//Load the receipt
                    Cart::destroy();
                    session('scanner','off'); //turn off the scanner
                    return $receipt->stream('receipt.pdf');
                }
                else{
                    $cart_db->delete(); //delete the cart from the database
                    return redirect()->back()->with($manager->report($sale));
                } 
        }
        else{
            return redirect()->back()->with('error','The cart is empty');
        }
    }

}
