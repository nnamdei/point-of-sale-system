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
use App\Inventory\StockManager;
use Illuminate\Support\Facades\Input;

class CartController extends Controller
{
    public function cart(){
        return view('cart.index')->with('cart',Cart::content());
    }

    //restore and view a stored cart
    public function show(){
        $ref = Input::get('ref');
        if($ref == null){
            return view('cart.show');
        }

        $cart = CartDB::where('identifier',$ref)->first();
        if($cart == null){
            return view('cart.show')->with('ref',$ref);
        }

        $contents = unserialize($cart->content);
        $summary['products'] = $contents->count();
        $summary['items'] = 0;
        $summary['subtotal'] = 0;
        $summary['tax'] = 0;
        foreach($contents as $item){
            $summary['items'] += $item->qty;
            $summary['subtotal'] += $item->total;
            $summary['tax'] += $item->taxRate * $item->price;
        }
        $summary['total'] = $summary['subtotal'] + $summary['tax'];
 
        return view('cart.show')->with('ref', $ref)
                                ->with('cart', $cart)
                                ->with('summary',$summary)
                                ->with('contents', $contents);
    }

    public function add(Request $request){
        $this->validate($request,[
            'quantity' => ['required','min: 1']
        ]);

        $product = Product::findorfail($request->product_id);
        $feasibility = $product->saleFeasible($request->quantity);//check if the quantity is feasible to be sold
        
        if($feasibility !== true){
            return redirect()->back()->with('info', 'Cannot add '.$request->quantity.' to cart, only '.$feasibility.' remaining');
        }

        $options = [];
        if($product->isVariable()){
            foreach($product->variants as $v){
                $variant = $v->variable;
                if($request->has($variant)){
                    $options[$variant] = $request->$variant;
                }
            }
        }
        $cart = Cart::add($product->id,$product->name,$request->quantity,$product->selling_price,$options)->associate('App\Product');
        // dd($cart);
        return redirect()->back()->with('success',$request->quantity.' of '.$product->name.' added to the cart');
    }

    public function update(Request $request){
        $item = Cart::search(function ($cartItem, $rowId) {
            return $rowId === request()->id;
        })->first();

        if($item == null){
            return redirect()->back()->with('error',"The item was not found in the cart");
        }
        $this->validate($request,[
            'quantity' => ['required']
        ]);
        
        $product = Product::findorfail($item->id);

        $feasibility = $product->saleFeasible($request->quantity);//check if the quantity is feasible to be sold
        if($feasibility !== true){
            return redirect()->back()->with('info', 'Cannot add '.$request->quantity.' to cart, only '.$feasibility.' remaining');
        }

        $options = [];
        if($product->isVariable()){
            foreach($product->variants as $v){
                $variant = $v->variable;
                if($request->has($variant)){
                    $options[$variant] = $request->$variant;
                }
            }
        }

        $update = Cart::update($request->id, ['qty' => $request->quantity]);
        $update->options = $options;
        return redirect()->back()->with('success', $item->name.' updated in the cart');
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

    public function generateID(){
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
                    $receipt = PDF::loadView('desk.templates.receipt', ['cart' => $cart_db,'contents' => Cart::content()]);//Load the receipt
                    Cart::destroy();
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

    public function recordSale($cart_id,$cart){

    }
}
