<?php
/** @noinspection PhpUnused */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcurriculum extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at'];
    protected $guarded =[];
    public function curriculums()
    {
        return $this->belongsTo(Curriculum::class);
    }
    public function getVideoPreviewAttribute($value)
    {
        return \Storage::disk('public')->url($value);
    }
}
