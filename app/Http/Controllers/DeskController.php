<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Product;
use App\Category;
use App\Sale;
use App\User;
use App\Inventory\StockManager;
use App\Inventory\Transaction;

class DeskController extends Controller
{
    public function __construct(){
        $this->middleware('attendant');
        $this->middleware('strictly-attendant')->except(['close','open']);
    }

    public function close($id){
        $user = User::findorfail($id);
        $user->desk_closed_at = now();
        $user->save();
    
        return redirect()->back()->with('success',$user->fullname().' desk closed!');
      }
    
      public function open($id){
        $user = User::findorfail($id);
        $user->desk_closed_at = null;
        $user->save();
    
        return redirect()->back()->with('success',$user->fullname().' desk opened!');
      }


    public function index(){
      
        $t = new Transaction();
        $transactions = $t->attendantTransactions(Auth::id());
       
        return view('desk.index')->with('period', $transactions['period'])
                        ->with('sales',$transactions['sales'])
                        ->with('activities', $transactions['activities'])
                        ->with('sales_chart',$transactions['sales_chart'])
                        ->with('service_records',$transactions['service_records'])
                        ->with('services_chart',$transactions['services_chart']);
    }
    
    public function products(){
        return view('desk.products')->with('products',Auth::user()->shop->products);
    }
    
    public function product($id){
        $product = Product::findorfail($id);
        return view('desk.product')->with('product',$product);
    }
    public function categories(){
        return view('desk.categories')->with('categories',Category::all());
    }

    public function category($id){
        return view('desk.category')->with('category',Category::find($id));
    }


    // public function recordSale(Request $request, $id){
    //     $product = Product::find($id);
    //     if($product == null){
    //         return redirect()->back()->with('error','The product was not found');
    //     }

    //         $manager = new StockManager($id);
    //         if($product->isSimple()){ //carryout basic validation for simple product
    //             $this->validate($request, ['quantity' => 'required|numeric']);
    //             $sale = $manager->addSale($request->quantity);
    //             return redirect()->route('desk')->with($manager->report($sale));
    //          }
    //      elseif($product->isVariable()){
    //         $this->validate($request, [
    //             'variable' => 'required',
    //             'quantity' => 'required|numeric'
    //             ]);
    //             $sale = $manager->updateVariableSales($request);
    //         return redirect()->route('desk')->with($manager->report($sale));
    //      }
    // }
}
