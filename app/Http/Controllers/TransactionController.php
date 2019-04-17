<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DateTime;
use App\Sale;
use App\Action;
use App\CartDB;
use App\ServiceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Inventory\FusionCharts;
use App\Inventory\Transaction;

class TransactionController extends Controller
{
    public function __construct(){
        $this->middleware('manager')->except(['verifyReceipt']);
        $this->middleware('attendant');
    }

    public function index(Request $request){
    
        $t = new Transaction();
        $transactions = $t->allTransactions(Auth::user()->shop->id);
            return view('transactions.index')
                    ->with('period', $transactions['period'])
                    ->with('sales',$transactions['sales'])
                    ->with('mostSold',$transactions['most_sold'])
                    ->with('leastSold',$transactions['least_sold'])
                    ->with('activities', $transactions['activities'])
                    ->with('sales_chart', $transactions['sales_chart'])
                    ->with('service_records', $transactions['service_records'])
                    ->with('services_chart', $transactions['services_chart']);
    }

    public function verifyReceipt(){
        $ref = Input::get('ref');
        $receipt = Input::get('receipt');
        if($ref == null){
            return redirect()->back()->with('info', 'provide the ref on the receipt for verification');
        }
        switch($receipt){
            case 'sale':
                return $this->saleReceipt($ref);
            break;
            case 'service':
                return $this->serviceReceipt($ref);
            break;
            default:
                return redirect()->back()->with('info','check if the receipt is for sale or service');
            break;
        }

    }
    public function saleReceipt($ref){

        $cart = CartDB::where('identifier',$ref)->first();
        if($cart == null){
            return view('transactions.receipts.sale')->with('ref',$ref);
        }

        $contents = unserialize($cart->content);
        $summary['products'] = $contents->count();
        $contents = unserialize($cart->content);
        $summary['items'] = 0;
        $summary['subtotal'] = 0;
        $summary['tax'] = 0;
        foreach($contents as $item){
            $summary['items'] += $item->qty;
            $summary['subtotal'] += $item->total;
            $summary['tax'] += $item->taxRate * $item->price;
        }
        $summary['total'] = $summary['subtotal'] + $summary['tax'];
 
        return view('transactions.receipts.sale')->with('ref', $ref)
                                ->with('cart', $cart)
                                ->with('summary',$summary)
                                ->with('contents', $contents);
    }

    public function serviceReceipt($ref){

        $record = ServiceRecord::where('identifier',$ref)->first();
        if($record == null){
            return view('transactions.receipts.service')->with('ref',$ref);
        }
        return view('transactions.receipts.service')->with('ref',$ref)
                                                    ->with('service_record', $record);
    }

}
