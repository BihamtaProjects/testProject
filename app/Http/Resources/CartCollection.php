<?php

namespace App\Http\Resources;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Covent;
use App\Traits\discountComputingTrait;
use App\Traits\findTypeTrait;
use App\Traits\lastPriceTrait;
use App\Traits\rateComputingTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    use lastPriceTrait;
    use rateComputingTrait;
    use discountComputingTrait;
    public function toArray($request)
    {

        $collection= array();
        foreach ($this->collection as $cart)
        {
            $covent = Covent::where('id',$cart->covent_id)->first();
            $price =  $this->lastPrice($covent->id);
            $couponDiscount = $this->discountComputing($cart);
            if($price !=null) {
                $mainprice = $price['price'];
                $maindiscount = $price['discount'];
                         }else{
                $mainprice =0;
                $maindiscount = 0;
            }

                $array = [
                    'cart_id'=>$cart->id,
                    'id' => $covent->id,
                    'title' => $covent->title,
                    'count'=>$cart->count,
                    'isEvent' => $covent->is_event,
                    'duration' => $covent->duration,
                    'start_time' => $covent->start_time,
                    'main_pic' => $covent->main_pic,
                    'rate' => $this->rateComputing($covent->id),
                    'price' => $mainprice,
                    'covent-discount' => $maindiscount,
                    'coupon-discount'=>$couponDiscount,


                ];
                array_push($collection, $array);


        }
        return $collection;
    }


}
