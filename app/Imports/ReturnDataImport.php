<?php

namespace App\Imports;

use App\Models\ReturnData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ReturnDataImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        // Log the raw row data for debugging
        Log::info('Processing return_data row: ' . json_encode($row, JSON_PRETTY_PRINT));

        // Normalize keys to lowercase and trim whitespace
        $row = array_change_key_case($row, CASE_LOWER);
        $row = array_map('trim', $row);

        // Skip if key field (invoice_number) is empty
        if (empty($row['invoice number']) && empty($row['invoice_number']) && empty($row['Invoice Number']) && empty($row['invoice no']) && empty($row['Invoice No'])) {
            Log::warning('Skipping return_data row: No valid invoice_number');
            return null;
        }

        // Check if the row contains expected fields; skip if it looks like a PoInvoice row
        if (isset($row['sale_order_number']) || isset($row['product_name']) || isset($row['product_sku_code'])) {
            Log::warning('Skipping return_data row: Row contains PoInvoice fields (sale_order_number, product_name, etc.)');
            return null;
        }

        Log::info('Inserting into returns: ' . json_encode($row, JSON_PRETTY_PRINT));

        return new ReturnData([
            'return_date'          => isset($row['return date']) || isset($row['return_date']) || isset($row['Return date']) || isset($row['date']) ?
                                     $this->transformDate($row['return date'] ?? $row['return_date'] ?? $row['Return date'] ?? $row['date']) : null,
            'shipment_request_id'  => $row['shipment request id'] ?? $row['shipment_request_id'] ?? $row['Shipment Request ID'] ?? $row['shipment request no'] ?? $row['Shipment Request No'] ?? null,
            'return_id'            => $row['return id'] ?? $row['return_id'] ?? $row['Return ID'] ?? $row['return no'] ?? $row['Return No'] ?? null,
            'marketplace'          => $row['marketplace'] ?? $row['Marketplace'] ?? null,
            'authorization_id'     => $row['authorization id'] ?? $row['authorization_id'] ?? $row['Authorization ID'] ?? $row['authorization no'] ?? $row['Authorization No'] ?? null,
            'vendor_code'          => $row['vendor code'] ?? $row['vendor_code'] ?? $row['Vendor code'] ?? $row['vendor no'] ?? $row['Vendor No'] ?? null,
            'invoice_number'       => $row['invoice number'] ?? $row['invoice_number'] ?? $row['Invoice Number'] ?? $row['invoice no'] ?? $row['Invoice No'] ?? null,
            'warehouse'            => $row['warehouse'] ?? $row['Warehouse'] ?? null,
            'total_cost'           => isset($row['total cost']) && is_numeric($row['total cost']) ? (float) $row['total cost'] :
                                     (isset($row['total_cost']) && is_numeric($row['total_cost']) ? (float) $row['total_cost'] :
                                     (isset($row['Total cost']) && is_numeric($row['Total cost']) ? (float) $row['Total cost'] :
                                     (isset($row['total']) && is_numeric($row['total']) ? (float) $row['total'] : 0.0))),
        ]);
    }

    private function transformDate($value)
    {
        if (empty($value) || $value === 'N/A' || $value === '-') {
            return null;
        }

        try {
            // Handle Excel numeric date (serial date)
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            }
            return Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
        } catch (\Exception $e) {
            Log::error('Date Transform Error: ' . $e->getMessage(), ['value' => $value]);
            return null;
        }
    }
}
