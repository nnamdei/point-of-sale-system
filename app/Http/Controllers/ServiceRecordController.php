<?php

namespace App\Http\Controllers;

use PDF;
use DB;
use Auth;
use Hash;
use Carbon\Carbon;
use App\Service;
use App\ServiceRecord;
use Illuminate\Http\Request;

class ServiceRecordController extends Controller
{
    public function __construct(){
        $this->middleware('service-activated');
        $this->middleware('attendant');
    }

    private function generateID(){
        $date_id = Carbon::now()->format('Ymd');
        $unique_id = substr(Hash::make(time()), 10,7);
        $sanitized_u_id = str_replace('/','_',$unique_id); //remove '/' and replace with '_' because it would cause issues in routing
        $final_id = $date_id.$sanitized_u_id;
        
        $check = DB::table('service_records')->select('identifier')->where('identifier',$final_id)->get();
        if($check->count() > 0){
            return $this->generateID();
        }
        return $final_id;
    }

    public function record(Request $request, $id){
        $this->validate($request,[
            'staff' => ['required'],
            'ammount_paid' => ['required','numeric'], 
            'payment_method' => ['required'] 
        ]);

        $service = Service::findorfail($id);
        $record = ServiceRecord::create([
            'identifier' => $this->generateID(),
            'shop_id' => Auth::user()->shop->id,
            'user_id' => Auth::id(),
            'staff_id' => $request->staff,
            'service_id' => $service->id,
            'paid' => $request->ammount_paid,
            'payment' => $request->payment_method,
            'note' => $request->note,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone
        ]);

        $receipt = PDF::loadView('desk.templates.service-receipt', ['service_record' => $record]);//Load the receipt
        return $receipt->stream('receipt.pdf');
    }

}
