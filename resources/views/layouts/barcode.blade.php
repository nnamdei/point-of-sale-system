<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{$barcode->product->name}} {{$barcode->attribute}}</title>
        <style>
            /* @page { size: 25mm 25mm  } */
        </style>
    </head>
    <body>
        <div style="text-align: center">
            @yield('barcode')
        </div> 
    </body>
</html>

