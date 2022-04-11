<?php
/** @noinspection PhpUnused */
namespace App\Models;

use App\Scopes\ActiveFaqs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Faq extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $hidden = ['created_at','updated_at','pivot'];

    public function covents()
    {
        return $this->belongsToMany(Covent::class)->orderBy('priority');
    }
    protected static function booted()
    {
        static::addGlobalScope(new ActiveFaqs());
    }
}
