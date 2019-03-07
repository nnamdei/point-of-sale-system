<?php

namespace App\Http\Controllers;

use DB;
use DateTime;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Inventory\FusionCharts;

class TransactionsController extends Controller
{
    public function __construct(){
        $this->middleware('manager');
    }
    public function index(Request $request){
        $from = Input::get('from');
        $to = Input::get('to');
        $all = Input::get('all');

        if($from !== null && $to !== null){
            $from_explained = new DateTime($from);
            $to_explained = new DateTime($to);
            $period = $from_explained->format('D dS M, Y')." - ".$to_explained->format('D dS M, Y');

            $mostSold = Transaction::select(DB::raw('sum(quantity) as total,product_id'))
                                    ->whereBetween('created_at',[$from, $to])
                                    ->where('operation',2)
                                    ->groupBy('product_id')
                                    ->orderBy('total','desc')
                                    ->first();
    
            $leastSold = Transaction::select(DB::raw('sum(quantity) as total,product_id'))
                                    ->whereBetween('created_at',[$from, $to])
                                    ->where('operation',2)
                                    ->groupBy('product_id')
                                    ->orderBy('total','asc')
                                    ->first();
    
            $sales = Transaction::where('operation',2)
                                ->whereBetween('created_at',[$from, $to])
                                ->OrderBy('created_at','desc')
                                ->get();
            $transactions = Transaction::where('operation','!=',2)
                                         ->whereBetween('created_at',[$from, $to])
                                         ->OrderBy('created_at','desc')
                                         ->get();
             $salesChartData =  Transaction::select(DB::raw('sum(quantity) as total,product_id'))
                                        ->whereBetween('created_at',[$from, $to])
                                         ->where('operation',2)
                                         ->groupBy('product_id')
                                         ->orderBy('total','desc')
                                         ->get();
         
            }
            elseif($all == 1){
                $mostSold = Transaction::select(DB::raw('sum(quantity) as total,product_id'))
                            ->where('operation',2)
                            ->groupBy('product_id')
                            ->orderBy('total','desc')
                            ->first();

                $leastSold = Transaction::select(DB::raw('sum(quantity) as total,product_id'))
                                ->where('operation',2)
                                ->groupBy('product_id')
                                ->orderBy('total','asc')
                                ->first();

                $sales = Transaction::where('operation',2)
                            ->OrderBy('created_at','desc')
                            ->get();
                $transactions = Transaction::where('operation','!=',2)
                                    ->OrderBy('created_at','desc')
                                    ->get();
                $salesChartData =  Transaction::select(DB::raw('sum(quantity) as total,product_id'))
                                    ->where('operation',2)
                                    ->groupBy('product_id')
                                    ->orderBy('total','desc')
                                    ->get();
                $p = new DateTime(Transaction::OrderBy('created_at','asc')->first()->created_at);
                $period = "All Sales from ". $p->format('D dS M, Y')." - Present";

                }
            else{

                if(Input::get('day') !== null){
                    $date  =  new DateTime(Input::get('day'));
                    $day = $date->format('Y-m-d');
                    $period = $date->format('D dS M, Y ');
                }else{
                    $date  =  new DateTime();
                    $day = $date->format('Y-m-d');
                    $period = "Today: ".date('D dS M, Y ',time());
                    }

                $mostSold = Transaction::select(DB::raw('sum(quantity) as total,product_id'))
                                    ->whereDate('created_at',$day)
                                    ->where('operation',2)
                                    ->groupBy('product_id')
                                    ->orderBy('total','desc')
                                    ->first();

                $leastSold = Transaction::select(DB::raw('sum(quantity) as total,product_id'))
                                    ->whereDate('created_at',$day)
                                    ->where('operation',2)
                                    ->groupBy('product_id')
                                    ->orderBy('total','asc')
                                    ->first();


                $sales = Transaction::where('operation',2)
                                    ->whereDate('created_at',$day)
                                    ->OrderBy('created_at','desc')
                                    ->get();

                $transactions = Transaction::where('operation','!=',2)
                                        ->whereDate('created_at',$day)
                                        ->OrderBy('created_at','desc')
                                        ->get();


                $salesChartData =  Transaction::select(DB::raw('sum(quantity) as total,product_id'))
                                    ->whereDate('created_at',$day)
                                    ->where('operation',2)
                                    ->groupBy('product_id')
                                    ->orderBy('total','desc')
                                    ->get();
            }
                               
            $arrChartConfig = array(
                "chart" => array(
                    "caption" => "Chart of Sales",
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


            return view('transactions.index')
                ->with('period', $period)
                ->with('transactions', $transactions)
                ->with('sales',$sales)
                ->with('mostSold',$mostSold)
                ->with('leastSold',$leastSold)
                ->with('chart', $chart);
    }
}
