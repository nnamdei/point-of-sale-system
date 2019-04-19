<?php

namespace App\Http\Controllers;
use App\Traits\BarcodeTrait;

use Illuminate\Http\Request;

class TestController extends Controller
{
    use BarcodeTrait;

    public function barcode($content){
        $barcode = $this->getBarcode($content);
        return  "<img src='data:image/png;base64,$barcode' alt='barcode' >";

    }
}
