<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remittance extends Model
{
    protected $table = 'remittances';
    protected $fillable = [
        'payment_number',
        'invoice_number',
        'invoice_date',
        'transaction_type',
        'transaction_description',
        'invoice_amount',
        'amount_paid',
    ];
}
