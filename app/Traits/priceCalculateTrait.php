<?php
/** @noinspection PhpUnused */
namespace App\Traits;


use Illuminate\Support\Facades\Auth;

trait priceCalculateTrait
{
    use discountComputingTrait;
    public function priceCalculate($carts)
    {
        $cartsPrice =0;
       foreach ($carts as $cart){
           $coventID = $cart->covent_id;
           $mainprice =  $this->lastPrice($coventID);
           if($mainprice!=null) {
               $price = $cart->count *($mainprice['price'] - $mainprice['discount']);
               $couponDsicount = $this->discountComputing($cart);
               $price = $price - $couponDsicount;
               $cartsPrice = $cartsPrice + $price;
           }
       }
       return $cartsPrice;
    }

    public function discountCalculate($carts)
    {
        $cartsDiscount =0;
        foreach ($carts as $cart){
            $coventID = $cart->covent_id;
            $mainprice =  $this->lastPrice($coventID);
            if($mainprice!=null) {
                $couponDsicount = $this->discountComputing($cart);
                $cartDiscount = $cart->count*($mainprice->discount) + $couponDsicount;
              $cartsDiscount = $cartsDiscount + $cartDiscount;
            }
        }
        return $cartsDiscount;
    }
}
