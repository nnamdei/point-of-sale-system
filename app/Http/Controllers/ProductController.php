<?php

namespace App\Http\Controllers;

use Auth;
use App\Shop;
use App\Product;
use App\Variant;
use App\Category;
use App\Inventory\StockManager;
use App\Inventory\SingleProductInsight;
use App\Inventory\ProductsCollectionInsight;
use App\Inventory\FusionCharts;
use App\Inventory\Transaction;
use App\Matto\FileUpload;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller
    {
        public function __construct(){
            $this->middleware('product-activated');
            $this->middleware('manager')->except(['find','show','index']);
        }  

        public function find(Request $request)
        {
            return Auth::user()->shop
                                ->products()
                                ->search($request->get('q'))
                                ->with('category')
                                ->with('variants')
                                ->get();
        }
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->isAttendant()){
            return view('desk.products')->with('products',Auth::user()->shop->products);
        }
        $products = collect([]); //initialize with a dummy collection

        $filter = Input::get('filter');
        $search = Input::get('search');
        $sort = Input::get('sort');
        if($search !== null){
            $query = Auth::user()->shop->products()->where('name','LIKE',"%$search%");
            $display = "Matches for \"$search\"";
            switch($sort){
                case 'stocks-0-9':
                    $products = $query->OrderBy('stock','asc');
                break;
                case 'stocks-9-0':
                     $products = $query->OrderBy('stock','desc');
                break;
                case 'sales-0-9':
                    $products = $query->OrderBy('sale','asc');
                break;
                case 'sales-9-0':
                    $products = $query->OrderBy('sale','desc');
                break;
                default:
                    $products = $query->OrderBy('created_at','desc');
                break;
            }
            $products = $query->get();
        }
        elseif($filter !== null){
            switch($filter){
                case 'category':
                    $display = Input::get('c','uncategorized');
                    $category = Category::where('name',$display)->first();
                    if($category !== null){
                        $products = Auth::user()->shop->products()->where('category_id',$category->id)->get();
                    }
                break;
                default:
                    $products = Auth::user()->shop->products()->orderBy('created_at','desc')->get();
                    $display = 'All Products';
                break;
            }
        }
        else{
            $products = Auth::user()->shop->products()->orderBy('created_at','desc')->get();
            $display = 'All Products';
        }


        $stocksChartConfig = array(
            "chart" => array(
                "caption" => "Product Stocks Chart",
                "subCaption" => '',
                "xAxisName" => "Product",
                "yAxisName" => "Quantity",
                "numberSuffix" => "items",
                "theme" => "candy"
            )
        );
        $salesChartConfig = array(
            "chart" => array(
                "caption" => "Product Sales Chart",
                "subCaption" => '',
                "xAxisName" => "Product",
                "yAxisName" => "Quantity",
                "numberSuffix" => "items",
                "theme" => "candy"
            )
        ); 

    $stocksRemainingChartConfig = array(
            "chart" => array(
                "caption" => "Outstanding Products Chart",
                "subCaption" => '',
                "xAxisName" => "Product",
                "yAxisName" => "Quantity",
                "numberSuffix" => "items",
                "theme" => "candy"
            )
        );



        $stocksChartConfig['data'] = array();
        $salesChartConfig['data'] = array();
        $stocksRemainingChartConfig['data'] = array();

        foreach($products as $p){
            array_push($stocksChartConfig['data'], array(
                                                        'label' => $p->name,
                                                        'value' => $p->stocks()
                                                        ));

            array_push($salesChartConfig['data'], array(
                                                            'label' => $p->name,
                                                            'value' => $p->sales()
                                                            ));
             array_push($stocksRemainingChartConfig['data'], array(
                                                                'label' => $p->name,
                                                                'value' => $p->remaining()
                                                                ));
                                                                
            }

        // chart object
        $stocksChart = new FusionCharts("column3d", "products-stocks-fchart" , "900", "500", "stocks-chart-container", "json", json_encode($stocksChartConfig));
        $salesChart = new FusionCharts("column3d", "products-sales-fchart" , "900", "500", "sales-chart-container", "json", json_encode($salesChartConfig));
        $remainingsChart = new FusionCharts("column3d", "products-remainings-fchart" , "900", "500", "remainings-chart-container", "json", json_encode($stocksRemainingChartConfig));

        $insight = new ProductsCollectionInsight($products,$display);
            
        return view('product.index')->with('products', $products)
                                    ->with('insight', $insight)
                                    ->with('stocksChart',$stocksChart)
                                    ->with('salesChart',$salesChart)
                                    ->with('remainingsChart',$remainingsChart);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $this->validate($request,[ 
            'shop' => 'required',
			'name' => 'required',
			'category' => 'required',
			'type' => 'required',
			// 'base_price' => 'required|numeric',
			// 'selling_price' => 'required|numeric',
        ]);

        $shop = Shop::findorfail($request->shop);

        if(Product::where([['shop_id',$shop->id],['name',$request->name]])->count() > 0){
            return redirect()->back()->with('error', 'There is already '.$request->name.' in '.$product->shop->name);
        }

        $product = new Product();
        $product->shop_id = $shop->id;
        $product->category_id = $request->category;
        $product->user_id = Auth::id();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->type = $request->type;
        $product->base_price = $request->base_price == null || $request->base_price < 0 ? 0 : $request->base_price ;
        $product->selling_price = $request->selling_price == null || $request->selling_price < 0 ? 0 : $request->selling_price;
        if($request->hasFile('preview')){
            $upload = new FileUpload(
                        $request,
                        $name = 'preview',$title =$request->name,
                        $path = 'public/images/products'
                    );
            $product->preview = isset($upload->slugs[0]) ? $upload->slugs[0] : null;
        }

        $product->save();

        $manager = new StockManager($product->id);
        if($product->isSimple()){
            $stock = isset($request->stock) && is_numeric($request->stock) ? $request->stock : 0;
            $manager->addStock($stock);
            return redirect()->route('products.show',['id'=>$product->id])->with('success','Product <strong>'.$product->name.'</strong> added to '.$shop->name);
        }
        elseif ($product->isVariable()) {
            $newVariables = $manager->storeVariables($request);
            return redirect()->route('products.show',['id'=>$product->id])->with($manager->report($newVariables));
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    $product =  Product::findorfail($id);

    if(!$product->inMyShop()){
            return redirect()->route('index')->with('info', 'You are not checked in to the shop the product is in');
    }

    if(Auth::user()->isAttendant()){
        return view('desk.product')->with('product',$product);
    }
    if($product->basePriceSet() && $product->sellingPriceSet()){
            $insight = new SingleProductInsight($data = [
            'stock' => $product->stocks(),
            'sale' => $product->sales(),
            'base_price' => $product->base_price,
            'selling_price' => $product->selling_price
                ]);
    }else{
        $insight = null;
    }
    $t = new Transaction();
    $transactions = $t->productTransactions($product->id);

    return view('product.show')->with('product',$product)
                                ->with('insight', $insight)
                                ->with('period', $transactions['period'])
                                ->with('sales',$transactions['sales'])
                                ->with('activities', $transactions['activities']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product =  Product::findorfail($id);
        if(!$product->inMyShop()){
                return redirect()->route('index')->with('info', 'You are not checked in to the shop the product is in');
        }
            return view('product.edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[ 
			'name' => 'required',
			'category' => 'required',
			'base_price' => 'required|numeric',
			'selling_price' => 'required|numeric',
        ]);

        $product =  Product::findorfail($id);

        if(!$product->inMyShop()){
                return redirect()->route('index')->with('info', 'You are not checked in to the shop the product is in');
        }

        if(Product::where([['shop_id',$product->shop->id],['name',$request->name],['id','!=',$product->id]])->count() > 0){
            return redirect()->back()->with('error', 'There is already '.$request->name.' in '.$product->shop->name);
        }

    
        $formalPrice = $product->selling_price;
        $product->category_id = $request->category;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->base_price = $request->base_price;
        $product->selling_price = $request->selling_price;
        if($request->hasFile('preview')){
            $upload = new FileUpload(
                        $request,
                        $name = 'preview',$title =$request->name,
                        $path = 'public/images/products'
                    );
            $product->preview = isset($upload->slugs[0]) ? $upload->slugs[0] : null;
        }
        $product->save();

        if($formalPrice != $request->selling_price){//check for change in price
            $manager = new StockManager($product->id);
            $manager->action(Auth::id(),$product->id,4,$formalPrice,0);
        }


        return redirect()->route('products.show',['id'=>$product->id])->with('success','Product <strong>'.$product->name.'</strong> updated');
    }


    public function addVariables(Request $request, $id){
        $product = Product::findorfail($id);

        if(!$product->inMyShop()){
                return redirect()->route('index')->with('info', 'You are not checked in to the shop the product is in');
        }
            $manager = new StockManager($product->id);
        $newVariables = $manager->storeVariables($request);

        return redirect()->route('products.show',['id'=>$product->id])->with($manager->report($newVariables));
    }

    public function stock(Request $request, $id){
        $product = Product::findorfail($id);

        if(!$product->inMyShop()){
                return redirect()->route('index')->with('info', 'You are not checked in to the shop the product is in');
        }
    
            $manager = new StockManager($id);
            if($product->isSimple()){ //carryout basic validation for simple product
                $this->validate($request,['quantity' => 'required|numeric']);
                $stock = $manager->addStock($request->quantity);
                return redirect()->back()->with($manager->report($stock));
             }
         elseif($product->isVariable()){
            $this->validate($request,['v_id' => 'required|numeric']);
            $stock = $manager->updateVariableStocks($request);
            return redirect()->back()->with($manager->report($stock));
         }
    }

    /**
     * reset stocks,sales and variants of a product
     */
    public function reset($id){
        $product =  Product::findorfail($id);
        if(!$product->inMyShop()){
                return redirect()->route('index')->with('info', 'You are not checked in to the shop the product is in');
        }
            
        $product->stock = 0;
        $product->sale = 0;
        if($product->isVariable()){
            $this->deleteVariants($product);
        }
        $manager = new StockManager($product->id);
        $manager->action(Auth::id(),$product->id,5,0,0);

        // // Remove all the sales record
        // if($product->sales->count() > 0){
        //     foreach($product->sales as $sale){
        //         $sale->delete();
        //     }
        // }
        
        // // Remove all action records
        // if($product->actions->count() > 0){
        //     foreach($product->actions as $action){
        //         $action->delete();
        //     }
        // }

        return redirect()->back()->with('success', $product->name." reset");

    }

    /**
     * convert product to simple
     */
    public function convertToSimple($id){
        $product =  Product::findorfail($id);

        if(!$product->inMyShop()){
                return redirect()->route('index')->with('info', 'You are not checked in to the shop the product is in');
        }

            if($product->isSimple()){
            return redirect()->back()->with('info', $product->name." is already a simple product");
        }
        $product->type = 'simple';
        $product->save();
        $this->deleteVariants($product);
        return redirect()->back()->with('success',$product->name.' converted to simple product');
    }

    public function convertToVariable($id){

        $product =  Product::findorfail($id);

        if(!$product->inMyShop()){
                return redirect()->route('index')->with('info', 'You are not checked in to the shop the product is in');
        }

        if($product->isVariable()){
            return redirect()->back()->with('info', $product->name." is already a variable product");
        }
        $product->type = 'variable';
        // reset the stock and sales
        $product->stock = 0;
        $product->sale = 0;

        $product->save();

        return redirect()->back()->with('success',$product->name.' converted to variable product, you can now add variant');
    }

    public function changeShop($id){
        $product =  Product::findorfail($id);

        if(!$product->inMyShop()){
                return redirect()->route('index')->with('info', 'You are not checked in to the shop the product is in');
        }
            
        $newShop = Shop::findorfail(request()->new_shop);
        $product->shop_id = $newShop->id;
        
        return redirect()->back()->with('success', $product->name.' moved to '.$newShop->name);

    }

/**
 * remove all the variants attached to $product
 */

    private function deleteVariants($product){
        if($product->variants->count() > 0){
            foreach($product->variants as $variant){
                $variant->delete();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product =  Product::findorfail($id);

        if(!$product->inMyShop()){
                return redirect()->route('index')->with('info', 'You are not checked in to the shop the product is in');
        }
        $product->delete();
        return redirect()->route('products.index')->with('success',"$product->name deleted!");
    }

} 