<?php

namespace App\Http\Resources;

use App\Models\Subject;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Traits\findSubSubjects;

class subjectCollection extends ResourceCollection
{
    use findSubSubjects;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $collection= array();
        foreach ($this->collection as $subject)
        {

            $subSubjects = $this->getSubSubjects($subject->id);
            if(isset($subSubjects)) {
                $array = [
                    'id' => $subject->id,
                    'name' => $subject->name,
                    'slug' => $subject->slug,
                    'parent_id' => $subject->parent_id,
                    'priority' => $subject->priority,
                    'active' => $subject->active,
                    'subSubject' => $subSubjects,
                ];
                array_push($collection, $array);
            }
        }
        return $collection;
    }
}
