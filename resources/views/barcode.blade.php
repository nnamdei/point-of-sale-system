<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Barcode - {{$serial}}</title>
        <style>
            /* @page { size: 25mm 25mm  } */
        </style>
    </head>
    <body>
        <div style="text-align: center">
            <img src="data:image/png;base64,{{$barcode}}" alt="barcode" class="barcode"/>
            <div>
                {{$serial}}
            </div>
        </div> 
    </body>
</html>

