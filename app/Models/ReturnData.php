<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnData extends Model
{
    protected $table = 'returns';

    protected $fillable = [
        'return_date', 'shipment_request_id', 'return_id', 'marketplace',
        'authorization_id', 'vendor_code', 'invoice_number', 'warehouse', 'total_cost'
    ];

}
