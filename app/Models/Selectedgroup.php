<?php
/** @noinspection PhpUnused */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selectedgroup extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
    public function covents()
    {
        return $this->belongsToMany(Covent::class)->orderBy('priority');
    }
    public function scopeActive($query)
    {
        return $query->where('active',  1);
    }
}
