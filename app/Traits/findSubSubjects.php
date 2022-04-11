<?php
/** @noinspection PhpUnused */
namespace App\Traits;

use App\Models\Subject;

trait findSubSubjects
{
    public function getSubSubjects($id)
    {
        $subSubjects = Subject::where('parent_id',$id)->get();
        return $subSubjects;
    }
}
