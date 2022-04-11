<?php
/** @noinspection PhpUnused */
namespace App\Traits;

use App\Models\Price;

trait lastPriceTrait
{
    public function lastPrice($id)
    {
       $price = Price::where('covent_id',$id)->active()->orderby('id','desc')->first();
        return $price;
    }
}
