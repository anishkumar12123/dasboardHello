<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoogsData extends Model
{
    protected $table = 'coogs_data';
    protected $fillable = [
        'invoice_id',
        'invoice_date',
        'agreement_id',
        'agreement_title',
        'funding_type',
        'original_balance',
    ];
}
