<?php
/** @noinspection PhpUnused */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded =[];
    const GATEWAY_ZARINPAL  = 1;

    public function setGatewayAttribute($value)
    {
        if($value ==1){
            $this->attributes['gateway'] = 'zarinpal';
        }
    }
}
