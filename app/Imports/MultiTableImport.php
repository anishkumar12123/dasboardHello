<?php
namespace App\Imports;

use App\Models\CoogsData;
use App\Models\DfInvoice;
use App\Models\ApprovedCoogsData;
use App\Models\PoInvoice;
use App\Models\Remittance;
use App\Models\ReturnData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MultiTableImport implements ToModel, WithHeadingRow, SkipsOnFailure, SkipsOnError, WithMultipleSheets
{
    use SkipsFailures, SkipsErrors;

    public function sheets(): array
    {
        return [
            0 => $this, // Handle all sheets with the same logic
        ];
    }

    public function model(array $row)
    {
        \Log::info('Processing row: ' . json_encode($row, JSON_PRETTY_PRINT));

        $table_type = strtolower(trim($row['table_type'] ?? ''));
        $table_type = str_replace([' ', '_'], '', $table_type);

        if (empty($table_type)) {
            \Log::warning('Skipping row: Empty or missing table_type');
            return null;
        }

        $table_type_map = [
            'coogs' => 'coogs',
            'coogsdata' => 'coogs',
            'remittance' => 'remittance',
            'remittances' => 'remittance',
            'returns' => 'returns',
            'returndata' => 'returns',
            'dfinvoice' => 'df_invoice',
            'dfinvoices' => 'df_invoice',
            'poinvoice' => 'po_invoice',
            'poinvoices' => 'po_invoice',
            'approvedcoogs' => 'approved_coogs',
            'approvedcoogsdata' => 'approved_coogs',
        ];

        $mapped_table_type = $table_type_map[$table_type] ?? $table_type;

        switch ($mapped_table_type) {
            case 'coogs':
                // Same as before, no changes needed
                return $this->createCoogsData($row);

            case 'df_invoice':
                return $this->createDfInvoice($row);

            case 'approved_coogs':
                return $this->createApprovedCoogsData($row);

            case 'po_invoice':
                return $this->createPoInvoice($row);

            case 'remittance':
                return $this->createRemittance($row);

            case 'returns':
                return $this->createReturnData($row);

            default:
                \Log::warning('Skipping row with unrecognized table_type: ' . $table_type, $row);
                return null;
        }
    }

    // Extracted methods for each table to keep code DRY
    private function createCoogsData(array $row)
    {
        if (empty($row['invoice_id']) && empty($row['Invoice ID']) && empty($row['invoice id']) &&
            empty($row['agreement_id']) && empty($row['Agreement ID']) && empty($row['agreement id'])) {
            \Log::warning('Skipping coogs row: Missing required fields');
            return null;
        }
        return new CoogsData([
            'invoice_id'        => $this->getValue($row, ['invoice_id', 'Invoice ID', 'invoice id']),
            'invoice_date'      => $this->parseDate($row, ['invoice_date', 'Invoice Date', 'invoice date']),
            'agreement_id'      => $this->getValue($row, ['agreement_id', 'Agreement ID', 'agreement id']),
            'agreement_title'   => $this->getValue($row, ['agreement_title', 'Agreement Title', 'agreement title']),
            'funding_type'      => $this->getValue($row, ['funding_type', 'Funding Type', 'funding type']),
            'original_balance'  => $this->parseFloat($row, ['original_balance', 'Original Balance'], 0.0),
        ]);
    }

    private function createDfInvoice(array $row)
    {
        if (empty($row['invoice_number']) && empty($row['Invoice Number']) && empty($row['invoice number']) &&
            empty($row['sale_order_number']) && empty($row['Sale Order Number']) && empty($row['sale order number'])) {
            \Log::warning('Skipping df_invoice row: Missing required fields');
            return null;
        }
        return new DfInvoice([
            'date'               => $this->parseDate($row, ['date', 'Date']),
            'sale_order_number'  => $this->getValue($row, ['sale_order_number', 'Sale Order Number', 'sale order number']),
            'invoice_number'     => $this->getValue($row, ['invoice_number', 'Invoice Number', 'invoice number']),
            'channel_entry'      => $this->parseFloat($row, ['channel_entry', 'Channel Entry'], 0.0),
            'product_name'       => $this->getValue($row, ['product_name', 'Product Name', 'product name']),
            'product_sku_code'   => $this->getValue($row, ['product_sku_code', 'Product SKU Code', 'product sku code']),
            'qty'                => $this->parseInt($row, ['qty', 'Qty'], 0),
            'unit_price'         => $this->parseFloat($row, ['unit_price', 'Unit Price'], 0.0),
            'currency'           => $this->getValue($row, ['currency', 'Currency']),
            'total'              => $this->parseFloat($row, ['total', 'Total'], 0.0),
        ]);
    }

    private function createApprovedCoogsData(array $row)
    {
        if (empty($row['asin']) && empty($row['ASIN']) && empty($row['asin code']) && empty($row['ASIN Code'])) {
            \Log::warning('Skipping approved_coogs row: Missing required fields');
            return null;
        }
        return new ApprovedCoogsData([
            'asin'             => $this->getValue($row, ['asin', 'ASIN', 'asin code', 'ASIN Code']),
            'gross_ship_gms'   => $this->parseFloat($row, ['gross_ship_gms', 'Gross Ship GMS'], null),
            'net_ship_gms'     => $this->parseFloat($row, ['net_ship_gms', 'Net Ship GMS'], null),
            'order_date'       => $this->parseDate($row, ['order_date', 'Order Date']),
            'net_ship_units'   => $this->parseInt($row, ['net_ship_units', 'Net Ship Units'], null),
            'duration'         => $this->getValue($row, ['duration', 'Duration']),
            'net_net'          => $this->parseFloat($row, ['net_net', 'Net Net'], 0.0),
            'net_served'       => $this->parseFloat($row, ['net_served', 'Net Served'], null),
            'coop'             => $this->parseInt($row, ['coop', 'Coop'], null),
            'final_coop'       => $this->parseFloat($row, ['final_coop', 'Final Coop'], null),
        ]);
    }

    // Add similar methods for po_invoice, remittance, and returns...

    private function getValue(array $row, array $keys)
    {
        foreach ($keys as $key) {
            if (!empty($row[$key])) {
                return $row[$key];
            }
        }
        return null;
    }

    private function parseDate(array $row, array $keys): ?\DateTime
    {
        foreach ($keys as $key) {
            if (isset($row[$key]) && is_numeric($row[$key])) {
                try {
                    return Date::excelToDateTimeObject($row[$key]);
                } catch (\Exception $e) {
                    \Log::warning("Failed to parse date for key '$key': " . $e->getMessage());
                }
            }
        }
        return null;
    }

    private function parseFloat(array $row, array $keys, ?float $default = null): ?float
    {
        foreach ($keys as $key) {
            if (isset($row[$key]) && is_numeric($row[$key])) {
                return (float) $row[$key];
            }
        }
        return $default;
    }

    private function parseInt(array $row, array $keys, ?int $default = null): ?int
    {
        foreach ($keys as $key) {
            if (isset($row[$key]) && is_numeric($row[$key])) {
                return (int) $row[$key];
            }
        }
        return $default;
    }
}
