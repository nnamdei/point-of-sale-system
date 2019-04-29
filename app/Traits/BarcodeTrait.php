<?php 
namespace App\Traits;

use DNS1D;
use DNS2D;
use App\Barcode;
/**
 * 
 */
trait BarcodeTrait
{

    protected function generateUniqueSerial($product){
        $serial = substr($product->shop->name,0,1).'-'.$product->id.'-'.rand(100,999).'-'.rand(1000,9999).'-'.rand(100,999).'-'.rand(10,99);
        if(Barcode::where('serial',$serial)->count() > 0){ //confirm that the serial is not existing already
            return $this->generateUniqueSerial($product);
        }
        return $serial;
    }

    protected function generateVariantSerial($variant){
        $product = $variant->product;
        $serials = array();
        if($product->barcodes->count() > 0){ //if there are other barcodes for the product before, else...
            $product_serial = $product->barcodes->first()->serial; //just get the serial of the first one found
        }
        else{//...else generate a new serial
            $product_serial = $this->generateUniqueSerial($product);
        }
        foreach($variant->values() as $value){
            $content = $product->id.'$'.$value;
            $serials[] = [
                        'content' => $content,
                        'serial' => $product_serial,
                        'attribute' => '['.$variant->variable.':'.$value.']',
                    ];
        }
        return $serials;
    }

    protected function getBarcode($content){
       return DNS1D::getBarcodePNG($content, "C39+",1.5,30);
    }

    protected function attachProductBarcode($product){
        $barcodes = array();
        if($product->isSimple()){
            $content = $product->id;
            $serial = $this->generateUniqueSerial($product);
            $barcode = $this->getBarcode($content);
            $barcodes[] = Barcode::create([
                'product_id' => $product->id,
                'serial' => $serial,
                'barcode' => $barcode,
                'barcode_content' => $content,
            ]);
           
        }
        elseif($product->isVariable()){
            if($product->variants->count() > 0){
                foreach($product->variants as $variant){
                    $barcodes[] = $this->attachVariantBarcode($variant);
                }
            }
        }
        return collect($barcodes);
    }

    protected function attachBarcodeFromProduct($product, $barcode_content){
        $serial = $this->generateUniqueSerial($product); //still generate a unique serial
        $barcode = $this->getBarcode($barcode_content);
         return Barcode::create([
            'product_id' => $product->id,
            'serial' => $serial,
            'barcode' => $barcode,
            'barcode_content' => $barcode_content,
            'src' => 'attached'
        ]);
    }

    protected function attachVariantBarcode($variant){
        $barcodes = array();
        $product = $variant->product;
        $serials = $this->generateVariantSerial($variant);
        foreach ($serials as $serial) {
            $barcode = $this->getBarcode($serial['content']);
            
            if(Barcode::where('barcode_content',$serial['content'])->count() == 0){
                $barcodes[] = Barcode::create([
                'product_id' => $product->id,
                'serial' => $serial['serial'],
                'attribute' => $serial['attribute'],
                'barcode' => $barcode,
                'barcode_content' => $serial['content'],
                ]);
            }
        }
        return $barcodes;
    }



    protected function deleteVariantValueBarcode($variant, $value){
        $barcode = Barcode::where('barcode_content', $variant->product->id.'$'.$value)->get();
        if($barcode->count() > 0){
            foreach($barcode as $code){
                $code->delete();
            }
        }
    }

    protected function deleteVariantBarcodes($variant){
        if(count($variant->values()) > 0){
            foreach($variant->values() as $value){
                $this->deleteVariantValueBarcode($variant, $value);
            }
        }
    }

    // delete all barcodes associated with a product
    protected function deleteProductBarcodes($product){
        if($product->barcodes->count() > 0){
            foreach($product->barcodes as $barcode){
                $barcode->delete();
            }
        }
    }
}
