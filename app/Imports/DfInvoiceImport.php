<?php
namespace App\Imports;

use App\Models\DfInvoice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DfInvoiceImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        \Log::info('Processing df_invoice row: ' . json_encode($row, JSON_PRETTY_PRINT));

        // Skip if key fields are empty
        if (empty($row['invoice_number']) && empty($row['Invoice Number']) && empty($row['invoice number']) && empty($row['Invoice No']) && empty($row['invoice no']) &&
            empty($row['sale_order_number']) && empty($row['Sale Order Number']) && empty($row['sale order number']) && empty($row['Sale Order No']) && empty($row['sale order no'])) {
            \Log::warning('Skipping df_invoice row: No valid data');
            return null;
        }

        \Log::info('Inserting into df_invoices: ' . json_encode($row, JSON_PRETTY_PRINT));
        return new DfInvoice([
            'date'               => isset($row['date']) && is_numeric($row['date']) ? Date::excelToDateTimeObject($row['date']) : (isset($row['Date']) && is_numeric($row['Date']) ? Date::excelToDateTimeObject($row['Date']) : null),
            'sale_order_number'  => $row['sale_order_number'] ?? $row['Sale Order Number'] ?? $row['sale order number'] ?? $row['Sale Order No'] ?? $row['sale order no'] ?? null,
            'invoice_number'     => $row['invoice_number'] ?? $row['Invoice Number'] ?? $row['invoice number'] ?? $row['Invoice No'] ?? $row['invoice no'] ?? null,
            'channel_entry'      => isset($row['channel_entry']) && is_numeric($row['channel_entry']) ? (float) $row['channel_entry'] : (isset($row['Channel Entry']) && is_numeric($row['Channel Entry']) ? (float) $row['Channel Entry'] : 0.0),
            'product_name'       => $row['product_name'] ?? $row['Product Name'] ?? $row['product name'] ?? null,
            'product_sku_code'   => $row['product_sku_code'] ?? $row['Product SKU Code'] ?? $row['product sku code'] ?? $row['SKU Code'] ?? $row['sku code'] ?? null,
            'qty'                => isset($row['qty']) && is_numeric($row['qty']) ? (int) $row['qty'] : (isset($row['Qty']) && is_numeric($row['Qty']) ? (int) $row['Qty'] : 0),
            'unit_price'         => isset($row['unit_price']) && is_numeric($row['unit_price']) ? (float) $row['unit_price'] : (isset($row['Unit Price']) && is_numeric($row['Unit Price']) ? (float) $row['Unit Price'] : 0.0),
            'currency'           => $row['currency'] ?? $row['Currency'] ?? null,
            'total'              => isset($row['total']) && is_numeric($row['total']) ? (float) $row['total'] : (isset($row['Total']) && is_numeric($row['Total']) ? (float) $row['Total'] : 0.0),
        ]);
    }
}
