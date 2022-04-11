<?php
/** @noinspection PhpUnused */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
    public function convents()
    {
        return $this->hasMany(Covent::class);
    }
    public function coventsessionss()
    {
        return $this->hasMany(Coventsession::class);
    }
}
