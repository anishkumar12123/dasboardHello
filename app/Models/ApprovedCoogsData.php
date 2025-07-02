<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovedCoogsData extends Model
{
    protected $table = 'approved_coogs_data';
    protected $fillable = [
        'asin',
        'gross_ship_gms',
        'net_ship_gms',
        'order_date',
        'net_ship_units',
        'duration',
        'net_net',
        'net_served',
        'coop',
        'final_coop',
    ];
}
