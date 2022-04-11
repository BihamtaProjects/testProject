<?php
/** @noinspection PhpUnused */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePlan extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];

    public function prices()
    {
        return $this->hasMany(ServicePrice::class);
    }
    public function group()
    {
        return $this->belongsTo(ServiceGroup::class);
    }
}
