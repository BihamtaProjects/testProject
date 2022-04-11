<?php
/** @noinspection PhpUnused */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['pivot'];
    public function invoice_details()
    {
        return $this->hasMany(InvoiceDetail::class);
    }

}
