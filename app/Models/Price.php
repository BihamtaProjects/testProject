<?php
/** @noinspection PhpUnused */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $hidden = ['created_at','updated_at'];
    public function covent()
    {
        return $this->belongsTo(Covent::class);
    }
    public function scopeActive($query)
    {
        return $query->where('active',  1);
    }
}
