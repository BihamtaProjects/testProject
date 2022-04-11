<?php
/** @noinspection PhpUnused */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    public $table = 'curriculums';
    use HasFactory;
    protected $guarded =[];
    protected $hidden = ['created_at','updated_at'];
    public function covent()
    {
        return $this->belongsTo(Covent::class);
    }
    public function subcurriculums()
    {
        return $this->hasMany(Subcurriculum::class);
    }
}
