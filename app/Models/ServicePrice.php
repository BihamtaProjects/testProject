<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePrice extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];

    public function plan()
    {
        return $this->belongsTo(ServicePlan::class);
    }
}
