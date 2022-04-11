<?php


/** @noinspection PhpUnused */

namespace App\Traits;

use App\Models\Unit;

trait findTypeTrait
{
    public function findUnitType($id)
    {
        $unit= Unit::where('id', $id)->first();
        return $unit->title;
    }
}
