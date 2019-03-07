<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Product;
use App\Category;
use App\Transaction;
use App\Inventory\StockManager;
use App\Inventory\FusionCharts;

class DeskController extends Controller
{
    public function __construct(){
        $this->middleware('attendant')->except(['find']);
    }

    public function index(){

        $today = date('Y-m-d',time());
        $period = "Today: ".date('D dS M, Y ',time());
        
        $sales = Auth::user()->transactions()
                                ->whereDate('created_at',$today)
                                ->OrderBy('created_at','desc')
                                ->get();

        $mostSold = Transaction::select(DB::raw('sum(quantity) as total,product_id'))
                                ->whereDate('created_at',$today)
                                ->where([['user_id',Auth::id()],['operation',2]])
                                ->groupBy('product_id')
                                ->orderBy('total','desc')
                                ->first();

        $leastSold = Transaction::select(DB::raw('sum(quantity) as total,product_id'))
                                ->whereDate('created_at',$today)
                                ->where([['user_id',Auth::id()],['operation',2]])
                                ->groupBy('product_id')
                                ->orderBy('total','asc')
                                ->first();

    $salesChartData =  Transaction::select(DB::raw('sum(quantity) as total,product_id'))
                                ->whereDate('created_at',$today)
                                ->where([['user_id',Auth::id()],['operation',2]])
                                ->groupBy('product_id')
                                ->orderBy('total','desc')
                                ->get();


        $arrChartConfig = array(
            "chart" => array(
                "caption" => "My Sales",
                "subCaption" => $period,
                "xAxisName" => "Product",
                "yAxisName" => "Quantity",
                "numberSuffix" => "stocks",
                "theme" => "candy"
            )
        );

        $arrChartConfig['data'] = array();

        foreach($salesChartData as $s){
            array_push($arrChartConfig['data'],
            array(
                'label' => $s->product->name,
                'value' => $s->total
                    ));
        }
        // JSON Encode the data to retrieve the string containing the JSON representation of the data in the array.
        $jsonEncodedData = json_encode($arrChartConfig);
        // chart object
        $chart = new FusionCharts("column3d", "sales-fchart" , "900", "400", "chart-container", "json", $jsonEncodedData);
                    
        return view('desk.index')->with('period',$period)
                                ->with('mostSold',$mostSold)
                                ->with('leastSold',$leastSold)
                                ->with('sales',$sales)
                                ->with('chart',$chart);
    }
    public function find(Request $request)
    {
        return Product::search($request->get('q')) ->with('category')
                                                    ->with('variants')
                                                    ->get();
    }
    public function products(){
        return view('desk.products')->with('products',Product::all());
    }
    public function product($id){
        return view('desk.product')->with('product',Product::find($id));
    }
    public function categories(){
        return view('desk.categories')->with('categories',Category::all());
    }

    public function category($id){
        return view('desk.category')->with('category',Category::find($id));
    }

    public function recordSale(Request $request, $id){
        $product = Product::find($id);
        if($product == null){
            return redirect()->back()->with('error','The product was not found');
        }

            $manager = new StockManager($id);
            if($product->isSimple()){ //carryout basic validation for simple product
                $this->validate($request, ['quantity' => 'required|numeric']);
                $sale = $manager->addSale($request->quantity);
                return redirect()->route('desk')->with($manager->report($sale));
             }
         elseif($product->isVariable()){
            $this->validate($request, [
                'variable' => 'required',
                'quantity' => 'required|numeric'
                ]);
                $sale = $manager->updateVariableSales($request);
            return redirect()->route('desk')->with($manager->report($sale));
         }
    }
}
