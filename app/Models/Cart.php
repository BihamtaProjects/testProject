<?php
/** @noinspection PhpUnused */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['pivot'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeInCart($query)
    {
        return $query->where('invoice_id',  0);
    }

}
