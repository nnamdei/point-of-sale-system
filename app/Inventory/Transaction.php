<?php
    namespace App\Inventory;

    use DB;
    use DateTime;
    use App\Sale;
    use App\Shop;
    use App\Action;
    use App\ServiceRecord;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Input;

    class Transaction{
        
        public $from = null;
        public $to = null;
        public $day = null;
        public $all = 0;

        public function __construct(){
            $this->from = Input::get('from');
            $this->to = Input::get('to');
            $this->day = Input::get('day');
            $this->all = Input::get('all');
        }

        // prepare the fusion chart sales raw data
        private function prepareSalesChart($period,$data){
            
            $arrChartConfig = array(
                "chart" => array(
                    "caption" => "Chart of sales",
                    "subCaption" => $period,
                    "xAxisName" => "Product",
                    "yAxisName" => "Quantity",
                    "numberSuffix" => "stocks",
                    "theme" => "candy"
                )
            );

            $arrChartConfig['data'] = array();
            foreach($data as $datum){
                array_push($arrChartConfig['data'],
                array(
                    'label' => $datum->product()->name,
                    'value' => $datum->total
                        ));
            }
            // JSON Encode the data to retrieve the string containing the JSON representation of the data in the array.
            $jsonEncodedData = json_encode($arrChartConfig);
            // chart object
            $chart = new FusionCharts("column3d", "sales-fchart" , "900", "400", "sales-chart-container", "json", $jsonEncodedData);
            
            return $chart;
        }

                // prepare the fusion chart srvice records raw data
        private function prepareServicesChart($period,$data){
            
                    $arrChartConfig = array(
                        "chart" => array(
                            "caption" => "Chart of services",
                            "subCaption" => $period,
                            "xAxisName" => "Service",
                            "yAxisName" => "Ammount",
                            "numberSuffix" => "",
                            "theme" => "candy"
                        )
                    );
        
                    $arrChartConfig['data'] = array();
                    foreach($data as $datum){
                        array_push($arrChartConfig['data'],
                        array(
                            'label' => $datum->service()->name,
                            'value' => $datum->total
                                ));
                    }
                    // JSON Encode the data to retrieve the string containing the JSON representation of the data in the array.
                    $jsonEncodedData = json_encode($arrChartConfig);
                    // chart object
                    $chart = new FusionCharts("column3d", "services-fchart" , "900", "400", "services-chart-container", "json", $jsonEncodedData);
                    
                    return $chart;
                }
                
        // Fetch all transactions for a particular product
        public function productTransactions($product_id){
            if($this->from != null && $this->to != null){
                $from_explained = new DateTime($this->from);
                $to_explained = new DateTime($this->to);
                $period = $from_explained->format('D dS M, Y')." - ".$to_explained->format('D dS M, Y');

                $period = $from_explained->format('D dS M, Y')." - ".$to_explained->format('D dS M, Y');
            
                $sales = Sale::where('product_id',$product_id)
                            ->whereBetween('created_at',[$this->from, $this->to])
                            ->OrderBy('created_at','desc')
                            ->get();

                $activities = Action::where('product_id',$product_id)
                                    ->whereBetween('created_at',[$this->from, $this->to])
                                    ->OrderBy('created_at','desc')
                                    ->get();
            }
            elseif($this->day != null){
                $date  =  new DateTime($this->day);
                $day = $date->format('Y-m-d');
                $period = $date->format('D dS M, Y ');

                $sales = Sale::where('product_id',$product_id)
                            ->whereDate('created_at',$date)
                            ->OrderBy('created_at','desc')
                            ->get();

                $activities = Action::where('product_id',$product_id)
                                    ->whereDate('created_at',$date)
                                    ->OrderBy('created_at','desc')
                                    ->get();
            }
        elseif($this->all == 1){
            $period = 'All';

            $sales = Sale::where('product_id',$product_id)
                        ->OrderBy('created_at','desc')
                        ->get();

            $activities = Action::where('product_id',$product_id)
                                ->OrderBy('created_at','desc')
                                ->get();
            }
            else{
                    $today_date  =  new DateTime();
                    $today = $today_date->format('Y-m-d');
                    $period = "Today: ".date('D dS M, Y ',time());

                    $sales = Sale::where('product_id',$product_id)
                                ->whereDate('created_at',$today)
                                ->OrderBy('created_at','desc')
                                ->get();

                    $activities = Action::where('product_id',$product_id)
                                ->whereDate('created_at',$today)
                                ->OrderBy('created_at','desc')
                                ->get();
            }

            return [
                'period' => $period,
                'sales' => $sales,
                'activities' => $activities
            ];

        }

        // Fetch all transactions including sales and service records recorded by a particular attendant
        public function attendantTransactions($user_id){

            if($this->from != null && $this->to != null){
                $from_explained = new DateTime($this->from);
                $to_explained = new DateTime($this->to);
                $period = $from_explained->format('D dS M, Y')." - ".$to_explained->format('D dS M, Y');

                $period = $from_explained->format('D dS M, Y')." - ".$to_explained->format('D dS M, Y');
            
                $sales = Sale::where('user_id',$user_id)
                            ->whereBetween('created_at',[$this->from, $this->to])
                            ->OrderBy('created_at','desc')
                            ->get();

                $mostSold = Sale::select(DB::raw('sum(quantity) as total,product_id'))
                            ->where('user_id',$user_id)
                            ->whereBetween('created_at',[$this->from, $this->to])
                            ->groupBy('product_id')
                            ->orderBy('total','desc')
                            ->first();

                $leastSold = Sale::select(DB::raw('sum(quantity) as total,product_id'))
                            ->where('user_id',$user_id)
                            ->whereBetween('created_at',[$this->from, $this->to])
                            ->groupBy('product_id')
                            ->orderBy('total','asc')
                            ->first();

                $activities = Action::where('user_id',$user_id)
                                    ->whereBetween('created_at',[$this->from, $this->to])
                                    ->OrderBy('created_at','desc')
                                    ->get();

                $salesChartData =  Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                    ->where('user_id',$user_id)
                                    ->whereBetween('created_at',[$this->from, $this->to])
                                    ->groupBy('product_id')
                                    ->orderBy('total','desc')
                                    ->get();

                $service_records = ServiceRecord::where('user_id',$user_id)
                                    ->whereBetween('created_at',[$this->from, $this->to])
                                    ->OrderBy('created_at','desc')
                                    ->get();

                $servicesChartData = ServiceRecord::select(DB::raw('sum(paid) as total,service_id'))
                                        ->where('user_id',$user_id)
                                        ->whereBetween('created_at',[$this->from, $this->to])
                                        ->groupBy('service_id')
                                        ->orderBy('total','desc')
                                        ->get();
                
            }
            elseif($this->day != null){
                $date  =  new DateTime($this->day);
                $day = $date->format('Y-m-d');
                $period = $date->format('D dS M, Y ');

                $sales = Sale::where('user_id',$user_id)
                            ->whereDate('created_at',$date)
                            ->OrderBy('created_at','desc')
                            ->get();

                $mostSold = Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                ->where('user_id',$user_id)
                                ->whereDate('created_at',$day)
                                ->groupBy('product_id')
                                ->orderBy('total','desc')
                                ->first();

                $leastSold = Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                ->where('user_id',$user_id)
                                ->whereDate('created_at',$day)
                                ->groupBy('product_id')
                                ->orderBy('total','asc')
                                ->first();

                $activities = Action::where('user_id',$user_id)
                                    ->whereDate('created_at',$date)
                                    ->OrderBy('created_at','desc')
                                    ->get();

                $salesChartData =  Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                    ->where('user_id',$user_id)
                                    ->whereDate('created_at',$date)
                                    ->groupBy('product_id')
                                    ->orderBy('total','desc')
                                    ->get();

                $service_records = ServiceRecord::where('user_id',$user_id)
                                    ->whereDate('created_at',$date)
                                    ->OrderBy('created_at','desc')
                                    ->get();

                $servicesChartData = ServiceRecord::select(DB::raw('sum(paid) as total,service_id'))
                                    ->where('user_id',$user_id)
                                    ->whereDate('created_at',$date)
                                    ->groupBy('service_id')
                                    ->orderBy('total','desc')
                                    ->get();

                }
        elseif($this->all == 1){
            $period = 'All';

            $sales = Sale::where('user_id',$user_id)
                        ->OrderBy('created_at','desc')
                        ->get();
            
            $mostSold = Sale::select(DB::raw('sum(quantity) as total,product_id'))
                        ->where('user_id',$user_id)
                        ->groupBy('product_id')
                        ->orderBy('total','desc')
                        ->first();

            $leastSold = Sale::select(DB::raw('sum(quantity) as total,product_id'))
                            ->where('user_id',$user_id)
                            ->groupBy('product_id')
                            ->orderBy('total','asc')
                            ->first();

            $activities = Action::where('user_id',$user_id)
                                ->OrderBy('created_at','desc')
                                ->get();

            $salesChartData =  Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                ->where('user_id',$user_id)
                                ->groupBy('product_id')
                                ->orderBy('total','desc')
                                ->get();
            
            $service_records = ServiceRecord::where('user_id',$user_id)
                                ->OrderBy('created_at','desc')
                                ->get();

            $servicesChartData = ServiceRecord::select(DB::raw('sum(paid) as total,service_id'))
                                ->where('user_id',$user_id)
                                ->groupBy('service_id')
                                ->orderBy('total','desc')
                                ->get();
            }
            else{
                    $today_date  =  new DateTime();
                    $today = $today_date->format('Y-m-d');
                    $period = "Today: ".date('D dS M, Y ',time());

                    $sales = Sale::where('user_id',$user_id)
                                ->whereDate('created_at',$today)
                                ->OrderBy('created_at','desc')
                                ->get();

                    $mostSold = Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                ->where('user_id',$user_id)
                                ->whereDate('created_at',$today)
                                ->groupBy('product_id')
                                ->orderBy('total','desc')
                                ->first();

                    $leastSold = Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                ->where('user_id',$user_id)
                                ->whereDate('created_at',$today)
                                ->groupBy('product_id')
                                ->orderBy('total','asc')
                                ->first();


                    $activities = Action::where('user_id',$user_id)
                                ->whereDate('created_at',$today)
                                ->OrderBy('created_at','desc')
                                ->get();
                    
                    $salesChartData =  Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                ->where('user_id',$user_id)
                                ->whereDate('created_at',$today)
                                ->groupBy('product_id')
                                ->orderBy('total','desc')
                                ->get();

                    $service_records = ServiceRecord::where('user_id',$user_id)
                                ->whereDate('created_at',$today)
                                ->OrderBy('created_at','desc')
                                ->get();
                    $servicesChartData = ServiceRecord::select(DB::raw('sum(paid) as total,service_id'))
                                ->where('user_id',$user_id)
                                ->whereDate('created_at',$today)
                                ->groupBy('service_id')
                                ->orderBy('total','desc')
                                ->get();
            }

            return [
                'period' => $period,
                'sales' => $sales,
                'most_sold' => $mostSold,
                'least_sold' => $leastSold,
                'activities' => $activities,
                'service_records' => $service_records,
                'sales_chart' => $this->prepareSalesChart($period, $salesChartData),
                'services_chart' => $this->prepareServicesChart($period, $servicesChartData),
            ];
        }


    //Fetch all transactions for a particular service 
    public function serviceTransactions($service_id){
        if($this->from != null && $this->to != null){
            $from_explained = new DateTime($this->from);
            $to_explained = new DateTime($this->to);
            $period = $from_explained->format('D dS M, Y')." - ".$to_explained->format('D dS M, Y');

            $period = $from_explained->format('D dS M, Y')." - ".$to_explained->format('D dS M, Y');
        
            $service_records = ServiceRecord::where('service_id',$service_id)
                        ->whereBetween('created_at',[$this->from, $this->to])
                        ->OrderBy('created_at','desc')
                        ->get();
        }
        elseif($this->day != null){
            $date  =  new DateTime($this->day);
            $day = $date->format('Y-m-d');
            $period = $date->format('D dS M, Y ');

            $service_records = ServiceRecord::where('service_id',$service_id)
                        ->whereDate('created_at',$date)
                        ->OrderBy('created_at','desc')
                        ->get();
        }
        elseif($this->all == 1){
            $period = 'All';

            $service_records = ServiceRecord::where('service_id',$service_id)
                        ->OrderBy('created_at','desc')
                        ->get();
        }
        else{
                $today_date  =  new DateTime();
                $today = $today_date->format('Y-m-d');
                $period = "Today: ".date('D dS M, Y ',time());

                $service_records = ServiceRecord::where('service_id',$service_id)
                            ->whereDate('created_at',$today)
                            ->OrderBy('created_at','desc')
                            ->get();
        }

        return [
            'period' => $period,
            'service_records' => $service_records
        ];
    }

    // Fetch all services rendered by a particular staff
    public function staffServices($staff_id){

        if($this->from != null && $this->to != null){
            $from_explained = new DateTime($this->from);
            $to_explained = new DateTime($this->to);
            $period = $from_explained->format('D dS M, Y')." - ".$to_explained->format('D dS M, Y');

            $period = $from_explained->format('D dS M, Y')." - ".$to_explained->format('D dS M, Y');
        
            $service_records = ServiceRecord::where('staff_id',$staff_id)
                                ->whereBetween('created_at',[$this->from, $this->to])
                                ->OrderBy('created_at','desc')
                                ->get();

            $servicesChartData = ServiceRecord::select(DB::raw('sum(paid) as total,service_id'))
                                    ->where('staff_id',$staff_id)
                                    ->whereBetween('created_at',[$this->from, $this->to])
                                    ->groupBy('service_id')
                                    ->orderBy('total','desc')
                                    ->get();
            
        }
        elseif($this->day != null){
            $date  =  new DateTime($this->day);
            $day = $date->format('Y-m-d');

            $period = $date->format('D dS M, Y ');

            $service_records = ServiceRecord::where('staff_id',$staff_id)
                                ->whereDate('created_at',$date)
                                ->OrderBy('created_at','desc')
                                ->get();

            $servicesChartData = ServiceRecord::select(DB::raw('sum(paid) as total,service_id'))
                                ->where('staff_id',$staff_id)
                                ->whereDate('created_at',$date)
                                ->groupBy('service_id')
                                ->orderBy('total','desc')
                                ->get();

            }
        elseif($this->all == 1){
            $period = 'All';
            
            $service_records = ServiceRecord::where('staff_id',$staff_id)
                                ->OrderBy('created_at','desc')
                                ->get();

            $servicesChartData = ServiceRecord::select(DB::raw('sum(paid) as total,service_id'))
                                ->where('staff_id',$staff_id)
                                ->groupBy('service_id')
                                ->orderBy('total','desc')
                                ->get();
        }
        else{
                $today_date  =  new DateTime();
                $today = $today_date->format('Y-m-d');
                $period = "Today: ".date('D dS M, Y ',time());

                $service_records = ServiceRecord::where('staff_id',$staff_id)
                            ->whereDate('created_at',$today)
                            ->OrderBy('created_at','desc')
                            ->get();

                $servicesChartData = ServiceRecord::select(DB::raw('sum(paid) as total,service_id'))
                            ->where('staff_id',$staff_id)
                            ->whereDate('created_at',$today)
                            ->groupBy('service_id')
                            ->orderBy('total','desc')
                            ->get();
        }

        return [
            'period' => $period,
            'service_records' => $service_records,
            'services_chart' => $this->prepareServicesChart($period, $servicesChartData),
        ];
    }

        // Fetch all transactions including sales and service records in a particular shop
        public function allTransactions($shop_id){
    
            if($this->from != null && $this->to != null){
                $from_explained = new DateTime($this->from);
                $to_explained = new DateTime($this->to);
                $period = $from_explained->format('D dS M, Y')." - ".$to_explained->format('D dS M, Y');
              
                $mostSold = Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                        ->where('shop_id',$shop_id)
                                        ->whereBetween('created_at',[$this->from, $this->to])
                                        ->groupBy('product_id')
                                        ->orderBy('total','desc')
                                        ->first();
        
                $leastSold = Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                        ->where('shop_id',$shop_id)
                                        ->whereBetween('created_at',[$this->from, $this->to])
                                        ->groupBy('product_id')
                                        ->orderBy('total','asc')
                                        ->first();
        
                $sales = Sale::where('shop_id',$shop_id)
                                    ->whereBetween('created_at',[$this->from, $this->to])
                                    ->OrderBy('created_at','desc')
                                    ->get();
    
                $activities = Action::where('shop_id',$shop_id)
                                            ->whereBetween('created_at',[$this->from, $this->to])
                                             ->OrderBy('created_at','desc')
                                             ->get();
                                                      
                $salesChartData =  Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                            ->where('shop_id',$shop_id)
                                            ->whereBetween('created_at',[$this->from, $this->to])
                                             ->groupBy('product_id')
                                             ->orderBy('total','desc')
                                             ->get();

                $service_records = ServiceRecord::where('shop_id',$shop_id)
                                            ->whereBetween('created_at',[$this->from, $this->to])
                                             ->OrderBy('created_at','desc')
                                             ->get();

                $servicesChartData = ServiceRecord::select(DB::raw('sum(paid) as total,service_id'))
                                            ->where('shop_id',$shop_id)                            
                                            ->whereBetween('created_at',[$this->from, $this->to])
                                            ->groupBy('service_id')
                                             ->orderBy('total','desc')
                                             ->get();
             
            }
            elseif($this->day != null){
                $date  =  new DateTime($this->day);
                $day = $date->format('Y-m-d');
                $period = $date->format('D dS M, Y ');

                $mostSold = Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                    ->whereDate('created_at',$day)
                                    ->groupBy('product_id')
                                    ->orderBy('total','desc')
                                    ->first();

                $leastSold = Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                    ->where('shop_id',$shop_id)
                                    ->whereDate('created_at',$day)
                                    ->groupBy('product_id')
                                    ->orderBy('total','asc')
                                    ->first();


                $sales = Sale::where('shop_id',$shop_id)
                                ->whereDate('created_at',$day)
                                ->OrderBy('created_at','desc')
                                ->get();
                                

                $activities = Action::where('shop_id',$shop_id)
                                        ->whereDate('created_at',$day)
                                        ->OrderBy('created_at','desc')
                                        ->get();
                                             

                $salesChartData =  Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                    ->where('shop_id',$shop_id)                    
                                    ->whereDate('created_at',$day)
                                    ->groupBy('product_id')
                                    ->orderBy('total','desc')
                                    ->get();

                $service_records = ServiceRecord::where('shop_id',$shop_id)
                                    ->whereDate('created_at',$day)
                                    ->OrderBy('created_at','desc')
                                    ->get();

                $servicesChartData = ServiceRecord::select(DB::raw('sum(paid) as total,service_id'))
                                    ->where('shop_id',$shop_id)                    
                                    ->whereDate('created_at',$day)
                                    ->groupBy('service_id')
                                     ->orderBy('total','desc')
                                     ->get();
            }
            elseif($this->all == 1){
                $mostSold = Sale::select(DB::raw('sum(quantity) as total,product_id'))
                            ->where('shop_id',$shop_id)            
                            ->groupBy('product_id')
                            ->orderBy('total','desc')
                            ->first();

                $leastSold = Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                ->where('shop_id',$shop_id)                
                                ->groupBy('product_id')
                                ->orderBy('total','asc')
                                ->first();

                $sales = Sale::where('shop_id',$shop_id)
                                ->orderBy('created_at','desc')
                                ->get();

                $activities = Action::where('shop_id',$shop_id)
                                    ->OrderBy('created_at','desc')
                                    ->get();


                $salesChartData =  Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                        ->where('shop_id',$shop_id)                        
                                        ->groupBy('product_id')
                                        ->orderBy('total','desc')
                                        ->get();

                $service_records = ServiceRecord::where('shop_id',$shop_id)
                                        ->OrderBy('created_at','desc')
                                        ->get();

                $servicesChartData = ServiceRecord::select(DB::raw('sum(paid) as total,service_id'))
                                        ->where('shop_id',$shop_id)                        
                                        ->groupBy('service_id')
                                         ->orderBy('total','desc')
                                         ->get();
    
                $p = new DateTime(Action::OrderBy('created_at','asc')->first()->created_at);
                $period = "Transactions from ". $p->format('D dS M, Y')." - Present";

            }
            else{
                $today_date  =  new DateTime();
                $today = $today_date->format('Y-m-d');
                $period = "Today: ".date('D dS M, Y ',time());

                $mostSold = Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                    ->where('shop_id',$shop_id)                    
                                    ->whereDate('created_at',$today)
                                    ->groupBy('product_id')
                                    ->orderBy('total','desc')
                                    ->first();

                $leastSold = Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                    ->where('shop_id',$shop_id)                    
                                    ->whereDate('created_at',$today)
                                    ->groupBy('product_id')
                                    ->orderBy('total','asc')
                                    ->first();


                $sales = Sale::where('shop_id',$shop_id)
                                    ->whereDate('created_at',$today)
                                    ->OrderBy('created_at','desc')
                                    ->get();

                $activities = Action::where('shop_id',$shop_id)
                                        ->whereDate('created_at',$today)
                                        ->OrderBy('created_at','desc')
                                        ->get();
                

                $salesChartData =  Sale::select(DB::raw('sum(quantity) as total,product_id'))
                                    ->where('shop_id',$shop_id)                    
                                    ->whereDate('created_at',$today)
                                    ->groupBy('product_id')
                                    ->orderBy('total','desc')
                                    ->get();

                $service_records = ServiceRecord::where('shop_id',$shop_id)
                                    ->whereDate('created_at',$today)
                                    ->OrderBy('created_at','desc')
                                    ->get();


                $servicesChartData = ServiceRecord::select(DB::raw('sum(paid) as total,service_id'))
                                    ->where('shop_id',$shop_id)
                                    ->whereDate('created_at',$today)
                                     ->groupBy('service_id')
                                     ->orderBy('total','desc')
                                     ->get();
            }
                                
            return [
                'period' => $period,
                'sales' => $sales,
                'most_sold' => $mostSold,
                'least_sold' => $leastSold,
                'activities' => $activities,
                'service_records' => $service_records,
                'sales_chart' => $this->prepareSalesChart($period, $salesChartData),
                'services_chart' => $this->prepareServicesChart($period, $servicesChartData)
            ];
        }
    }
?>