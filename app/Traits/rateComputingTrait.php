<?php

/** @noinspection PhpUnused */

namespace App\Traits;


use App\Models\Comment;

trait rateComputingTrait
{
    public function rateComputing($id)
    {
        $commentsRates= Comment::where('covent_id', $id)->pluck('rate')->toArray();
        $countRates= Comment::where('covent_id', $id)->count();
        $sum = array_sum($commentsRates);
        if($countRates !=0){
        $rate = $sum/$countRates;}
        else{
            $rate = 0;
        }

      return $rate;
    }
}
