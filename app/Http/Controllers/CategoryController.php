<?php

namespace App\Http\Controllers;
use Auth;
use App\Shop;
use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(){
        $this->middleware('manager')->except(['show','index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('category.index')->with('categories',Auth::user()->shop->categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'shop' => 'required',
        ]);

        $shop = Shop::findorfail($request->shop);

        if(Category::where([['shop_id',$shop->id],['name',$request->name]])->count() > 0){
            return redirect()->back()->with('error', 'category '.$request->name.' already exist in '.$shop->name);
        }

        $category = new Category;
        $category->user_id= Auth::id();
        $category->shop_id = $shop->id;
        $category->name= $request->name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('categories.show',['id'=>$category->id])->with('success','New product category <strong>'.$request->name.'</strong> created in <strong>'.$shop->name.'</strong>');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {    
        $category =  Category::findorfail($id);

        if(!$category->inMyShop()){
                return redirect()->route('index')->with('info', 'You are not checked in to the shop the category is in');
        }
        if(Auth::user()->isAttendant()){
            return view('desk.category')->with('category',$category);
        }

        return view('category.show')->with('category',$category);
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category =  Category::findorfail($id);

        if(!$category->inMyShop()){
                return redirect()->route('index')->with('info', 'You are not checked in to the shop the category is in');
        }
        return view('category.edit')->with('category',$category);
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
        $category =  Category::findorfail($id);

        if(!$category->inMyShop()){
                return redirect()->route('index')->with('info', 'You are not checked in to the shop the category is in');
        }

        $this->validate($request,[
            'name' => 'required'
        ]);

        if(Category::where([['shop_id',$category->shop->id],['name',$request->name],['id','!=',$category->id]])->count() > 0){
            return redirect()->back()->with('error', 'There is already category '.$request->name.' in '.$category->shop->name);
        }

        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('categories.show',['id'=>$category->id])->with('success','Category <strong>'.$category->name.'</strong> updated'); 
       }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category =  Category::findorfail($id);

        if(!$category->inMyShop()){
                return redirect()->route('index')->with('info', 'You are not checked in to the shop the category is in');
        }
            
        if($category->products->count() > 0){
            foreach($category->products as $product){
                $product->delete();
            }
        }
        $category->delete();

        return redirect()->route('products.index')->with('success','Category <strong>'.$category->name.'</strong> deleted'); 

    }
}
