<?php
namespace App\Inventory;

class ProductsCollectionInsight
{
    public $products;
    public $count;
    public $displaying;
    public $totalStocks = 0;
    public $totalSales = 0;
    public $totalRemaining = 0;

    public function __construct($products,$displaying)
    {
        $this->products = $products;
        $this->count = $products === null ? 0 : $products->count();
        $this->displaying = $displaying;
        if($products !== null){
                foreach($products as $product){
                    $this->totalStocks += $product->stocks();
                    $this->totalSales += $product->sales();
                    $this->totalRemaining += $product->remaining();
                }    
        }

    }
    private function init()
    {
        return array(
            'figure' => 0,
            'explanation' => ''
        );
    }
    public function f(){
        $insight = $this->init();

        $insight['figure'] = 0;
        $insight['explanation'] = '';
        return $insight;
    }

     public function averageStocks(){
        $insight = $this->init();

        $insight['figure'] = $this->count > 0 ? round($this->totalStocks / $this->count,2) : 0;
        $insight['explanation'] = "Average stocks of <strong>($this->displaying <sup class='badge badge-primary'>$this->totalStocks items</sup>)</strong>";
        return $insight;
    }

    //average sales
    public function averageSales(){
        $insight = $this->init();

        $insight['figure'] = $this->count > 0 ? round($this->totalSales / $this->count,2) : 0;
        $insight['explanation'] = "Average sales of <strong>($this->displaying <sup class='badge badge-success'>$this->totalSales items</sup>)</strong>";
        return $insight;
    }


    //monetary value of all stocks based on the base price
    public function stocksBaseValue(){
            $insight = $this->init();
            $value = 0;
            foreach($this->products as $product){
                $value += $product->base_price * $product->stocks();
            }
            $insight['figure'] = $value;
            $insight['explanation'] = "Base value of <strong>($this->displaying <sup class='badge badge-primary'>$this->totalStocks items</sup>)</strong> ";
            return $insight;
    }

    //monetary value of all stocks based on the selling price
    public function stocksExpectedValue(){
            $insight = $this->init();
            $value = 0;
            foreach($this->products as $product){
                $value += $product->selling_price * $product->stocks();
            }
            $insight['figure'] = $value;
            $insight['explanation'] = "Expected value of <strong>($this->displaying <sup class='badge badge-primary'>$this->totalStocks items</sup>)</strong> when sold at their respective selling prices";
            return $insight;
    }

    //monetary value of all sales based on the base price
    public function salesBaseValue(){
            $insight = $this->init();
            $value = 0;
            foreach($this->products as $product){
                $value += $product->base_price * $product->sales();
            }
            $insight['figure'] = $value;
            $insight['explanation'] = "Base value of all sold <strong>($this->displaying <sup class='badge badge-primary'>$this->totalStocks items</sup>)</strong> at their respective base prices";
            return $insight;
    }

    //monetary value of all sales based on the base price
    public function salesExpectedValue(){
            $insight = $this->init();
            $value = 0;
            foreach($this->products as $product){
                $value += $product->selling_price * $product->sales();
            }
            $insight['figure'] = $value;
            $insight['explanation'] = "Expected income after the record of sales of <strong>($this->displaying <sup class='badge badge-success'>$this->totalSales items</sup>)</strong> at their respective selling prices";
            return $insight;
    }

    //monetary value of all remainings based on the base price
    public function outstandingBaseValue(){
            $insight = $this->init();
            $value = 0;
            foreach($this->products as $product){
                $value += $product->base_price * $product->remaining();
            }
            $insight['figure'] = $value;
            $insight['explanation'] = "Base value of all remaining of <strong>($this->displaying <sup class='badge badge-secondary'>$this->totalRemaining items</sup>)</strong>";
            return $insight;
    }

    //monetary value of all remainings based on the base price
    public function outstandingExpectedValue(){
            $insight = $this->init();
            $value = 0;
            foreach($this->products as $product){
                $value += $product->selling_price * $product->remaining();
            }
            $insight['figure'] = $value;
            $insight['explanation'] = "Value of the remaining of <strong>($this->displaying <sup class='badge badge-secondary'>$this->totalRemaining items</sup>)</strong> when sold at their respective selling prices";
            return $insight;
    }

    //expected profit of total stock from the inception
    public function expectedTotalProfit()
    {
        $insight = $this->init();

        $profit = $this->stocksExpectedValue()['figure'] - $this->stocksBaseValue()['figure'];
        $insight['figure'] = $profit;
        $insight['explanation'] = "This is the total expected profit you are to make at the end of the sales of  <strong>($this->displaying <sup class='badge badge-primary'>$this->totalStocks items</sup>)</strong>  at their respective selling prices";
        return $insight;
    }

    //profit so far based on the selling price
    public function currentProfit(){
        $insight = $this->init();

        $profit = $this->salesExpectedValue()['figure'] - $this->salesBaseValue()['figure'];
        $insight['figure'] = $profit;
        $insight['explanation'] = "How much profit you have made by the sale of <strong>($this->displaying <sup class='badge badge-success'>$this->totalSales items</sup>)</strong> at their respective selling prices";
        return $insight;
    }

    //expected profit of remaining stock
    public function expectedOutstandingProfit()
    {
        $insight = $this->init();

        $profit = $this->outstandingExpectedValue()['figure'] - $this->outstandingBaseValue()['figure'];
        $insight['figure'] = $profit;
        $insight['explanation'] = "You will make this profit more when you sell remaining of <strong>($this->displaying <sup class='badge badge-secondary'>$this->totalRemaining items</sup>)</strong> at their respective selling prices";
        return $insight;
    }
}

?>