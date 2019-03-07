<?php
namespace App\Inventory;

class SingleProductInsight
{
    public $stock;
    public $sale;
    public $remaining;
    public $base_price;
    public $selling_price;


    public function __construct($data = ['stock' => 0, 'sale' => 0, 'base_price' => 0, 'selling_price' => 0])
    {
        $this->stock = $data['stock'];
        $this->sale = $data['sale'];
        $this->remaining = $data['stock'] - $data['sale'];
        $this->base_price = $data['base_price'];
        $this->selling_price = $data['selling_price'];

    }
    private function init()
    {
        return array(
            'figure' => 0,
            'explanation' => ''
        );
    }
    public function profitIndex(){

        $insight = $this->init();
        if($this->base_price > 0 && $this->selling_price > 0){
            $profit = $this->selling_price - $this->base_price;
            $insight['figure'] = round(($profit/$this->base_price)*100, 2);
        }
        $insight['explanation'] = "Percentage of profit on every sale<br><span class='text-info'><i class='fa fa-info-circle'></i> You make &#8358;$profit on every sale</span>";
        return $insight;
    }
    public function profitIndexLevel(){
        return $this->profitIndex() < 0 ? 'poor' : ($this->profitIndex() < 15 ? 'fair' : 'good');
    }
    //monetary value of all stock based on the base price
    public function stockBaseValue(){
        $insight = $this->init();

        $insight['figure'] = $this->base_price * $this->stock;
        $insight['explanation'] = "Value of all the $this->stock stock at the base price of &#8358;$this->base_price";
        return $insight;
    }

    //monetary value of all stock based on the selliing price
    public function stockExpectedValue(){
        $insight = $this->init();

        $insight['figure'] = $this->selling_price * $this->stock;
        $insight['explanation'] = "Value of all the $this->stock stock at the selling price rate of &#8358;$this->selling_price";
        return $insight;
    }

    //monetary value of all sale based on the base price
    public function saleBaseValue(){
        $insight = $this->init();

        $insight['figure'] = $this->base_price * $this->sale;
        $insight['explanation'] = "Value of all the $this->sale sales at the base price rate of &#8358;$this->base_price";
        return $insight;
    }

    //monetary value of all sale based on the selling price
    public function saleExpectedValue(){
        $insight = $this->init();

        $insight['figure'] = $this->selling_price * $this->sale;
        $insight['explanation'] = "Value of all the $this->sale sales at the selling price rate of &#8358;$this->selling_price, <br><span class='text-info'><i class='fa fa-info-circle'></i> This is how much you should have made by now after the record of $this->sale sales</span>";
        return $insight;
    }

    //monetary value of remaining product base on the base price
    public function outstandingBaseValue(){
        $insight = $this->init();

        $insight['figure'] = $this->base_price * $this->remaining;
        $insight['explanation'] = "Value of the the remaining $this->remaining stocks at the rate of the base price of &#8358;$this->base_price";
        return $insight;
    }
    //monetary value of remaining product base on the selling price
    public function outstandingExpectedValue(){
        $insight = $this->init();

        $insight['figure'] = $this->selling_price * $this->remaining;
        $insight['explanation'] = "Value of the the remaining $this->remaining when sold at the selling price rate of &#8358;$this->selling_price, <br><span class='text-info'><i class='fa fa-info-circle'></i>  This is how much you can still make with the remaining $this->remaining stocks</span>";
        return $insight;
    }

    //expected profit of total stock from the inception
    public function expectedTotalProfit()
    {
        $insight = $this->init();

        $profit = $this->stockExpectedValue()['figure'] - $this->stockBaseValue()['figure'];
        $insight['figure'] = $profit;
        $insight['explanation'] = "This is the total expected profit you are to make at the end of the sales of all the $this->stock stocks at the selling price rate of &#8358;$this->selling_price";
        return $insight;
    }

    //profit so far based on the selling price
    public function currentProfit(){
        $insight = $this->init();

        $profit = $this->saleExpectedValue()['figure'] - $this->saleBaseValue()['figure'];
        $insight['figure'] = $profit;
        $insight['explanation'] = "You have made this total profit so far by selling $this->sale out of the total stock of $this->stock at the selling price rate of &#8358;$this->selling_price";
        return $insight;
    }

    //expected profit of remaining stock
    public function expectedOutstandingProfit()
    {
        $insight = $this->init();

        $profit = $this->outstandingExpectedValue()['figure'] - $this->outstandingBaseValue()['figure'];
        $insight['figure'] = $profit;
        $insight['explanation'] = "You will make this profit more when you sell the $this->remaining remaining stock at the selling price rate of &#8358;$this->selling_price";
        return $insight;
    }
}


?>