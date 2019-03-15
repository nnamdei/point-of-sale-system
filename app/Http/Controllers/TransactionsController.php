<?php

namespace App\Http\Controllers;

use DB;
use DateTime;
use App\Sale;
use App\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Inventory\FusionCharts;
use App\Inventory\Transaction;

class TransactionsController extends Controller
{
    public function __construct(){
        $this->middleware('manager');
    }
    public function index(Request $request){
    
        $t = new Transaction();
        $transactions = $t->allTransactions();
            return view('transactions.index')
                    ->with('period', $transactions['period'])
                    ->with('sales',$transactions['sales'])
                    ->with('mostSold',$transactions['most_sold'])
                    ->with('leastSold',$transactions['least_sold'])
                    ->with('activities', $transactions['activities'])
                    ->with('chart', $transactions['chart']);
    }
}
