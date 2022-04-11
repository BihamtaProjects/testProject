<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use \App\Traits\lastPriceTrait;
class groupCollection extends ResourceCollection
{
    use lastPriceTrait;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $collection= array();
        foreach ($this->collection as $group)
        {
            $covents = $group->covents;
            foreach ($covents as $covent){
                $price =  $this->lastPrice($covent->id);
                $price =['price'=>$price->price, 'discount'=>$price->discount];
                $covent['price'] =$price;
            }
            $array = [
                'id' => $group->id,
                'title' => $group->title,
                'type' => $group->type,
                'priority' => $group->priority,
                'is_event' => $group->is_event,
                'covents' => $covents,
            ];
            array_push($collection, $array);
        }
        return $collection;
    }

}
