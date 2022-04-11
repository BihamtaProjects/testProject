<?php
/** @noinspection PhpUnused */
namespace App\Traits;
use App\Models\Coupon;
use App\Models\Covent;

trait discountComputingTrait
{
    public function discountComputing($cart)
    {
        $covent = Covent::where('id',$cart->covent_id)->first();
        $price =  $this->lastPrice($covent->id);
        $couponDiscount = 0;
        if($price!=null) {
            $coupon_id = $cart->coupon_id;

            if ($coupon_id != 0) {
                $coupon = Coupon::where('id', $cart->coupon_id)->first();
                if (isset($coupon)) {
                    if ($coupon->value != 0) {
                        $couponDiscount = $coupon->value;
                    } elseif ($coupon->percent != 0) {
                            $mainPrice = $cart->count*($price['price'] - $price['discount']);
                            $percent = $coupon->percent / 100;
                            $couponDiscount = $mainPrice * $percent;
                    }
                }
            }
        }
            return $couponDiscount;

    }
}
