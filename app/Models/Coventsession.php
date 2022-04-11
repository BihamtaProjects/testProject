<?php
/** @noinspection PhpUnused */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coventsession extends Model
{

    use HasFactory;
    protected $guarded =[];
    protected $hidden = ['created_at','updated_at','pivot'];

    public function covent()
    {
        return $this->belongsTo(covent::class);

    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
