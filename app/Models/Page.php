<?php
/** @noinspection PhpUnused */
namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    use sluggable;
    protected $guarded =[];
    protected $hidden = ['created_at','updated_at','pivot'];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function getImageAttribute($value)
    {
        return \Storage::disk('public')->url($value);
    }
    public function getlinkAttribute($value)
    {
        return  url($value);
    }
}
