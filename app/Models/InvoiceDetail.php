<?php
/** @noinspection PhpUnused */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['pivot'];
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
