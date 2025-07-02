<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoInvoice extends Model
{
    protected $table = 'po_invoices';
    protected $fillable = [
        'date',
        'sale_order_number',
        'invoice_number',
        'channel_entry',
        'product_name',
        'product_sku_code',
        'qty',
        'unit_price',
        'currency',
        'total',
    ];
}
