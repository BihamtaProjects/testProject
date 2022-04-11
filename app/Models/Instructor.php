<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $hidden = ['created_at','updated_at','pivot'];

    public function covents()
    {
        return $this->belongsToMany(Covent::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
