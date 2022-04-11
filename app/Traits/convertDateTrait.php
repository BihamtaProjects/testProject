<?php
/** @noinspection PhpUnused */
namespace App\Traits;

use Hekmatinasser\Verta\Verta;

trait convertDateTrait {
    public function convertTOGeogorian($dateTime)
    {
        $time = explode(" ",$dateTime);
        $date =$time[0];
        $date = explode("-",$date);
        $date =  Verta::getGregorian( $date[0],$date[1],$date[2] );
        $date  = implode("-",$date);
        $dateTime =$date." ".$time[1];
        return $dateTime;
    }
}



