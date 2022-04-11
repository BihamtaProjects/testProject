<?php
/** @noinspection PhpUnused */
namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\ActiveCovents;


class Covent extends Model
{
    use sluggable;
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at','pivot'];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function selectedgroups()
    {
        return $this->belongsToMany(SelectedGroup::class);
    }
    public function faqs()
    {
        return $this->belongsToMany(Faq::class)->withPivot('priority')
            ->orderBy('covent_faq.priority');

    }
    public function keywords()
    {
        return $this->belongsToMany(Keyword::class);
    }
    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
    public function instructors()
    {
        return $this->belongsToMany(Instructor::class);
    }
    public function usersFavorites()
    {
        return $this->belongsToMany(User::class);
    }

    public function curriculums()
    {
        return $this->hasMany(Curriculum::class);
    }
    public function prices()
    {
        return $this->hasMany(Price::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }
    protected static function booted()
    {
        static::addGlobalScope(new ActiveCovents());
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getMainPicAttribute($value)
    {
        return \Storage::disk('public')->url($value);
    }
    public function getMainVideoAttribute($value)
    {
        return \Storage::disk('public')->url($value);
    }
    public function getStartTimeAttribute($value)
    {
        $time = explode(" ",$value);
        $date =$time[0];
        $date = explode("-",$date);
        $date =  Verta::getJalali( $date[0],$date[1],$date[2] );
        $date  = implode("-",$date);
        $dateTime =$date." ".$time[1];
        return $dateTime;
    }
    public function sessions()
    {
        return $this->hasMany(Coventsession::class);
    }
}
