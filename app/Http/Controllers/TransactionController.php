<?php

namespace App\Http\Controllers;

use DB;
use PDF;
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
use App\Inventory\StockManager;

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
 
        if(request()->get('print') != null && request()->get('print') == 'true'){ //reprint the receipt
            $receipt = PDF::loadView('desk.templates.sale-receipt',
                 [
                    'cart' => $cart,
                    'contents' => $contents,
                    'tax' => $summary['tax'],
                    'total' => $summary['total'],
                    'attendant' => $cart->user() == null ? 'Nil' : $cart->user()->profile()->fullname()
                ]);//Load the receipt
                return $receipt->stream('receipt.pdf');
        }

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

    public function revokeSale(Request $request,$id){
        $sale = Sale::find($id);
        if($sale == null){
            return redirect()->back()->with('error', 'Sale record not found');
        }
        $product = $sale->product();
        $m = new StockManager($product->id);
        if($request->deduct_sales != null){
            if($product->isSimple()){
                $m->removeSale($sale->quantity);
            }
            elseif($product->isVariable()){
                $cart = $sale->cart;
                foreach(unserialize($cart->content) as $item){//go through the cart
                    if($item->id == $product->id){
                        $m->updateVariableSales($sale->cart->id,$item,$remove = true);
                    }
                }
            }
        }
        $sale->delete();
        return redirect()->back()->with('success',$sale->product()->name.' sale revoked');
    }

}
