<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Receipt</title>
    <!-- Styles -->
    <style>
    body{
        font-size: .7rem;
        padding:-20px;
    }
    #items-table{
        min-height: 420px;
    }
    .text-center{
        text-align: center;
    }
    .text-right{
        text-align: right;
    }
    hr{
        margin: 5px 0;    
    }
    small,.small{
        font-size: .6rem;
    }

    table{
        width: 100%;
    }
        
    table,tr,td{
        border-collapse: collapse;
    }
    /* @media print 
    {
        height: 200mm;
        width: 58mm;
    }
     */
    @page { size: 58mm 200mm  }
        
    </style>
</head>

<body>
    <div class="text-center">
        <div><strong style="font-size: 1.1rem">{{Auth::user()->shop->name}}</strong></div>
        <div>{{Auth::user()->shop->address}}</div>
        <div> {{Auth::user()->shop->email}}</div>
        <div>{{Auth::user()->shop->phone}}</div>
    </div>
    <br>
    <div class="text-right">
        ref: {{$cart->identifier}}
    </div>
    <br>

    <div id="items-table">
        @yield('items')
    </div>

<div style="margin-top: 20px">
    <div>
        Attendant: {{$attendant}}
    </div>
    <div>
        Payment: {{$cart->payment}}
    </div>
    <div>
        Issued: {{$cart->created_at->toDayDateTimeString()}}
    </div>
</div>
<div style="margin-top: 15px">
    <div>
        <h5 class="text-center">Thank you for your patronage</h5>
        <small><i>***Any alteration renders this receipt invalid</i></small>
    </div>
    <div class="container text-right">
        <small>printed: {{ \Carbon\Carbon::now()->toDayDateTimeString() }}</small>
    </div>
</div>

</body>

</html>
