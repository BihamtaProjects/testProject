<?php
/** @noinspection PhpUnused */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Subject extends Model
{
    use sluggable;
    use HasFactory;
    protected $guarded =[];
    protected $hidden = ['created_at','updated_at','pivot'];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function scopeActive($query)
    {
        return $query->where('active',  1);
    }
    public function scopeParent($query)
    {
        return $query->where('parent_id',  0);
    }
    public function covents()
    {
        return $this->belongsToMany(Covent::class);
    }
    public function getIconAttribute($value)
    {
        return \Storage::disk('public')->url($value);
    }
    public function getImageAttribute($value)
    {
        return \Storage::disk('public')->url($value);
    }
}
