<?php
/** @noinspection PhpUnused */
namespace App\Traits;


use App\Models\Invoice;

trait numberGenerateTrait
{
    public function numberGenerate()
    {
           $random = rand(1111111,9999999);
           $invoicesNumbers = Invoice::pluck('number')->toArray();
           while(in_array($random,$invoicesNumbers)){
               $random = rand(1111111,9999999);
           }
           return $random;
    }
}
