<?php
/** @noinspection PhpUnused */
namespace App\Models;

use App\Scopes\ActiveComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $hidden = ['updated_at'];
    public function covent()
    {
        return $this->belongsTo(Covent::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected static function booted()
    {
        static::addGlobalScope(new ActiveComments());
    }
}
