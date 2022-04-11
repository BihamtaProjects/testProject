<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Traits\lastPriceTrait;
use App\Traits\rateComputingTrait;
use App\Traits\findTypeTrait;
class CoventsCollection extends ResourceCollection
{
    use lastPriceTrait;
    use rateComputingTrait;
    use findTypeTrait;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $collection= array();
        foreach ($this->collection as $covent)
        {
            if(isset($covent)) {
                $array = [
                    'id' => $covent->id,
                    'title' => $covent->title,
                    'summary' => $covent->summary,
                    'description' => $covent->description,
                    'prerequirement' => $covent->prerequirement,
                    'unit_id' => $this->findUnitType($covent->unit_id),
                    'duration' => $covent->duration,
                    'video_length' => $covent->video_length,
                    'start_time' => $covent->start_time,
                    'main_pic' => $covent->main_pic,
                    'main_video' => $covent->main_video,
                    'priority' => $covent->priority,
                    'active' => $covent->active,
                    'rate' => $this->rateComputing($covent->id),
                    'comments' => $covent->comments,
                    'faqs' => $covent->faqs,
                    'price' => $this->lastPrice($covent->id),
                    'instructors' => $covent->instructors,
                    'keywords' => $covent->keywords,
                    'curriculums' => $covent->curriculums,


                ];

                array_push($collection, $array);
            }

        }
        return $collection;
    }
}
