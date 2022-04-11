<?php
/** @noinspection PhpUnused */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
    public function convents()
    {
        return $this->hasMany(Covent::class);
    }
    public function scopeActive($query)
    {
        return $query->where('active',  1);
    }
}
