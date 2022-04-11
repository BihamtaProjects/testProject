<?php

namespace App\Http\Resources;

use App\Models\Price;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\lastPriceTrait;
use App\Traits\rateComputingTrait;
use App\Traits\findTypeTrait;

class eventResource extends JsonResource
{
    use LastPriceTrait;
    use rateComputingTrait;
    use findTypeTrait;

    /**
     * @var mixed
     */

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'slug'=>$this->slug,
            'isEvent'=>$this->is_event,
            'summary'=>$this->summary,
            'description'=>$this->description,
            'prerequirement'=>$this->prerequirement,
            'unit'=>$this->findUnitType($this->unit_id),
            'duration'=>$this->duration,
            'video_length'=>$this->video_length,
            'start_time'=>$this->start_time,
            'main_pic'=>$this->main_pic,
            'main_video'=>$this->main_video,
            'priority'=>$this->priority,
            'active'=>$this->active,
            'rate'=> $this->rateComputing($this->id),
            'comments'=>$this->comments,
            'faqs'=>$this->faqs,
            'price'=> $this->lastPrice($this->id),
            'instructors'=>$this->instructors,
            'type'=>$this->type,
            'organize'=>$this->organizer,
            'keywords'=>$this->keywords,
            'curriculums'=>$this->curriculums,
            ];
    }
}
