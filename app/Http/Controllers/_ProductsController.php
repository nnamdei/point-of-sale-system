<?php

namespace App\Http\Controllers;

use Auth;
use App\Product;
use App\Variant;
use App\Category;
use App\Inventory\SingleProductInsight;
use App\Inventory\ProductsCollectionInsight;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ProductsController extends Controller
{

    private function getVariables($request){//This privte function is to extract data from variable product and to check for their consistency7
        $response = array(
                'success' => array(),
                'warning' => array(),
                'info' => array(),
                'error' => array(),
                'variables' => array()
        );
        $variables = $this->checkVariables($request);
        if(!empty( $variables['warning'])){
            
           $response['warning'] = array_merge($response['warning'],$variables['warning']);
        }
        if(!empty($variables['error'])){
            $response['error'] = array_merge($response['error'],$variables['error']);
        }
        foreach($variables['variables'] as $variable)
        {

            if(count($variable['values']) !== count($variable['stocks'])){//check for data consistency
                $response['error'][] = count($variable['values'])." values provided for the variable ".$variable['variable']." and ".count($variable['stocks'])." stocks given";
            }
            else{
                $response['variables'][] = $variable;
            }
        }
        return $response;
    }

//Rearrage the varibles' values and stock and return them as arrays
    private function checkVariables($request){
        $response = array(
            'warning' => array(),
            'error' => array(),
            'info' => array(),
            'variables' => array()
        );
        for($i = 0; $i<count($request->variables); ++$i){
            if($request->variables[$i] !== null && $request->values[$i] !== null && $request->v_stocks !== null){//if any of the field is null
                $initSales = array();
                $values =  explode('|',$request->values[$i]);
                $stocks = explode('|',$request->v_stocks[$i]);
                if(count($values) === count($stocks)){
                    for($j = 0; $j < count($values);  $j++){//initialize the sales to 0
                        array_push($initSales,0);
                    }
                    $response['variables'][] = array(
                        'variable' => $request->variables[$i],
                        'values' => $values,
                        //stocks' =>  count(explode('|',$request->v_stocks[$i])) == 1 && explode('|',$request->v_stocks[$i])[0] == '' ? array(0) : explode('|',$request->v_stocks[$i])//This is to regulate the array returned by explode, exploding an empty string returns an array of size one, this to set the dafault for empty string to 0 
                        'stocks' => $stocks,
                        'sales' => $initSales
                    );
                }
                else{
                    $response['error'][] = "Variable ".$request->variables[$i]." could not be added: ".count($values)." values provided, but ".count($stocks)." stocks given"; 
                }
            }
            else{
                if($request->variables[$i] === null){
                    continue;
                }else{
                     $response['warning'][] = "Some fields are missing for variant <strong>".$request->variables[$i]."</strong>";
                }
               
            }

        }
       
        return $response;
    }

    //Store new variant
    public function storeVariables($request,$product){
        $response = array(
            'error' => array(),
            'success' => array(),
            'warning' => array(),
            'info' => array(),

                );
        $totalStock = 0;
        $product = Product::find($product);

        $_v = $this->getVariables($request);
       
       
        $response['error'] = array_merge($_v['error'], $response['error']);
        $response['warning'] = array_merge($_v['warning'], $response['warning']);

        if(!empty($_v['variables'])){
            foreach($_v['variables'] as $v){
                $variant = new Variant();
                $variant->product_id = $product->id;

                $normalizedValues = array_map(function($value){ 
                    return str_replace('-','_',str_slug($value));
                },$v['values']);
                
                $normalizedStocks = array();
                for($i = 0; $i<count($v['stocks']); $i++){//if sting was provided, change it to zero
                    if(is_numeric($v['stocks'][$i])){
                        array_push($normalizedStocks, $v['stocks'][$i]);
                        $response['success'][] = "<strong>".$v['stocks'][$i]." ".$v['variable']." ".$v['values'][$i]."</strong> of  <strong>$product->name</strong> added";

                    }else{
                        array_push($normalizedStocks, 0);
                        $response['warning'][] = "stock input for <strong>".$v['values'][$i]."</strong> is invalid, <strong>0</strong> used instead";
                     }
                }
                $variant->variable = str_replace('-','_',str_slug($v['variable']));
                $variant->values = join('|',$normalizedValues);
                $variant->stocks = join('|',$normalizedStocks);
                $variant->sales = join('|',$v['sales']);
                $variant->save();
            } 
            $response['success'][] = array_sum($v['stocks'])." total stocks added to ".$product->name;    
        }
        else{
            $response['info'][] = "No variable was added to <strong>$product->name</strong>";
        }
        return $response;
    }

    private function updateVariableStocks($request,$operation){
        $response = array(
                        'error' => array(),
                        'success' => array(),
                        'warning' => array(),
                        'info' => array()
                    );

        foreach($request->v_id as $v){

            $variant = Variant::find($v);
            $product = $variant->product;
            $formIndex = $variant->variable.'_stocks';//decrypt the $_POST index as structured in the form;
            
            $values = $variant->values();
            $prevStocksArray = $variant->stocks();
            $prevSalesArray = $variant->sales();
            $remainingsArray = $variant->remainings();

            $newStocksArray = array();
            $newSalesArray = array();

            $stocksToUpdate = $request->$formIndex;


            if(count($prevStocksArray) !== count($stocksToUpdate)){ //The lentgth of the previous stocks must be consistent with the ones to be updated with
                $response['error'][] = "There is inconsistency in the data for <strong>$product->name</strong>";
            }
            else{
                    for($i = 0; $i<count($prevStocksArray); $i++){
                        if( $stocksToUpdate[$i] !== null){ //if there is new value to be added or removed

                            switch($operation){
                                case '+':
                                    $newStocksArray[$i] = $prevStocksArray[$i] + $stocksToUpdate[$i];
                                    $newSalesArray[$i] = $prevSalesArray[$i];
                                    array_push($response['success'], "<strong>$stocksToUpdate[$i]</strong> added to <strong>$variant->variable $values[$i] </strong> of $product->name");
                                break;
                                case '-':
                                    $remainingStock = $remainingsArray[$i] - $stocksToUpdate[$i];
                                    if($remainingStock < 0){//check if that sales is not feasible
                                        $newSalesArray[$i] = $prevSalesArray[$i]; //retain the previous value
                                        array_push($response['warning'],"Trying to record <strong>$stocksToUpdate[$i]</strong> sales of <strong>$values[$i]</strong>  for variable $variant->variable of <strong>$product->name</strong>, remaining quantity not up to <strong>$stocksToUpdate[$i]</strong>, but <strong>$remainingsArray[$i]</strong> ");
                                    }else{
                                        $newSalesArray[$i] = $prevSalesArray[$i] + $stocksToUpdate[$i];
                                        array_push($response['success'], "<strong>$stocksToUpdate[$i] $variant->variable $values[$i] </strong> of $product->name sold!");
                                    }
                                    $newStocksArray[$i] = $prevStocksArray[$i];
                                break;
                            }
                        }
                        else{//use the previuos stocks and sales
                            $newStocksArray[$i] = $prevStocksArray[$i];
                            $newSalesArray[$i] = $prevSalesArray[$i];
                        }
                    }
                    
                    //format and save the variable stocks
                    if(!empty($newStocksArray) && !empty($newSalesArray) && count($newStocksArray) ===  count($newSalesArray)){
                            $variant->stocks = join('|',$newStocksArray);
                            $variant->sales = join('|',$newSalesArray);
                            $variant->save();
                    }
                }
                            
        }
      
        return $response;
    }
    

    private function report($feedback){
        $report = array();
        if(count($feedback['success']) > 0){
            $report['success'] = "<ul class='list-group'>";
            foreach($feedback['success'] as $s){
                $report['success'] .= "<li class='list-group-item text-success'>$s</li>";
            }
            $report['success'] .= "</ul>";
       }

       if(count($feedback['info']) > 0){
        $report['info'] = "<ul class='list-group'>";
        foreach($feedback['info'] as $i){
            $report['info'] .= "<li class='list-group-item text-success'>$i</li>";
        }
        $report['info'] .= "</ul>";
   }

       if(count($feedback['warning']) > 0){
            $report['warning'] = "<ul class='list-group'>";
            foreach($feedback['warning'] as $w){
                $report['warning'] .= "<li class='list-group-item text-warning'>$w</li>";
            }
            $report['warning'] .= "</ul>";
        }

        if(count($feedback['error']) > 0){
            $report['error'] = "<ul class='list-group'>";
            foreach($feedback['error'] as $e){
                $report['error'] .= "<li class='list-group-item text-danger'>$e</li>";
            }
            $report['error'] .= "</ul>";
        }
        return $report;
    }
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('id',-1)->get(); //initialize with a dummy collection

        $filter = Input::get('filter');
        $search = Input::get('search');
        $sort = Input::get('sort');
        if($search !== null){
            $query = Product::where('name','LIKE',"%$search%");
            $display = "Matches for \"$search\"";
            switch($sort){
                case 'stocks-1-9':
         
                break;
                case 'stocks-1-9':

                break;
                case 'sales-1-9':

                break;
                case 'sales-1-9':

                break;
                default:

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
                        $products = Product::where('category_id',$category->id)->get();
                    }
                break;
                default:
                    $products = Product::OrderBy('created_at','desc')->get();
                    $display = 'All Products';
                break;
            }
        }
        else{
            $products = Product::OrderBy('created_at','desc')->get();
            $display = 'All Products';
        }
        
        $insight = new ProductsCollectionInsight($products,$display);

        return view('products.index')->with('products', $products)
                                    ->with('insight', $insight);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
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
			'name' => 'required|unique:products',
			'category' => 'required',
			'type' => 'required',
			'base_price' => 'required|numeric',
			'selling_price' => 'required|numeric',
        ]);


        $product = new Product();
        $product->category_id = $request->category;
        $product->user_id = Auth::id();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->type = $request->type;
        $product->base_price = $request->base_price;
        $product->selling_price = $request->selling_price;
        $product->stock = isset($request->stock) ? $request->stock : 0;
        $product->save();

        if($request->type == 'variable'){
            $newVariables = $this->storeVariables($request,$product->id);
            return redirect()->route('products.show',['id'=>$product->id])->with($this->report($newVariables));
        }
        return redirect()->route('products.show',['id'=>$product->id])->with('success','Product <strong>'.$product->name.'</strong> added');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    $product =  Product::find($id);
    if($product == null){
        return redirect()->route('products.index')->with('info','Product not found');
    }
        $insight = new SingleProductInsight($data = [
                                            'stock' => $product->stocks(),
                                            'sale' => $product->sales(),
                                            'base_price' => $product->base_price,
                                            'selling_price' => $product->selling_price
                                              ]);
        return view('products.show')->with('product',$product)
                                    ->with('insight', $insight);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product =  Product::find($id);
        if($product == null){
            return redirect()->route('products.index')->with('info','Product not found');
        }
        return view('products.edit')->with('product', $product);
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

        $product = Product::find($id);
        if($product == null){
            return redirect()->route('products.index')->with('info','Product not found');
        }
        $product->category_id = $request->category;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->base_price = $request->base_price;
        $product->selling_price = $request->selling_price;
        $product->save();

        return redirect()->route('products.show',['id'=>$product->id])->with('success','Product <strong>'.$product->name.'</strong> updated');
    }


    public function addVariables(Request $request, $id){
        $product = Product::find($id);
        if($product == null){
            return redirect()->route('products.index')->with('error','The product was not found');
        } 
        $newVariables = $this->storeVariables($request,$product->id);

        return redirect()->route('products.show',['id'=>$product->id])->with($this->report($newVariables));
    }


    public function stock(Request $request, $id){
        $product = Product::find($id);
        if($product == null){
            return redirect()->back()->with('error','The product was not found');
        }
        $rules = ['operation' => 'required'];

        if($product->isSimple()){ //carryout basic validation for simple product
           $rules['quantity'] = 'required|numeric';
        }

        $this->validate($request,$rules);
        $feedback = array();

        switch($request->operation){
            case '+':
                if($product->isSimple()){
                    $product->stock =  $product->stock + $request->quantity;
                    $product->save();
                    return redirect()->back()->with('success', "<strong>$request->quantity</strong> of <strong>$product->name</strong> added") ;
                }
                elseif($product->isVariable()){
                   $variableUpdate = $this->updateVariableStocks($request,'+');
                }
            break;

            case '-':
                if($product->isSimple()){
                    $remainingStock =  $product->remaining() - $request->quantity;
                    if($remainingStock < 0){
                        return redirect()->back()->with('warning',"Sale of <strong>$request->quantity</strong> not feasible, Current stock of <strong>$product->name</strong> is not up to <strong>$request->quantity</strong>");
                    }
                    $product->sale =  $product->sale + $request->quantity;
                    $product->save();
                    return redirect()->back()->with('success',"<strong>$request->quantity</strong> of <strong>$product->name</strong> sold!");
                }
                elseif($product->isVariable()){
                    $variableUpdate = $this->updateVariableStocks($request,'-');
                   }
                
            break;

            default:
                return redirect()->back()->with('warning','Invalid operation');
            break;
        }

        if(isset($variableUpdate)){           
            return redirect()->back()->with($this->report($variableUpdate));
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
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('products.index')->with('success',"$product->name deleted!");

    }

} 