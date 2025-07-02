<?php
namespace App\Imports;

use App\Models\Remittance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class RemittanceImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        \Log::info('Processing remittance row: ' . json_encode($row, JSON_PRETTY_PRINT));

        if (empty($row['payment_number']) && empty($row['Payment Number']) && empty($row['payment number']) &&
            empty($row['invoice_number']) && empty($row['Invoice Number']) && empty($row['invoice number']) &&
            empty($row['invoice_amount']) && empty($row['Invoice Amount'])) {
            \Log::warning('Skipping remittance row: No valid data');
            return null;
        }

        \Log::info('Inserting into remittances: ' . json_encode($row, JSON_PRETTY_PRINT));
        return new Remittance([
            'payment_number'           => $row['payment_number'] ?? $row['Payment Number'] ?? $row['payment number'] ?? null,
            'invoice_number'           => $row['invoice_number'] ?? $row['Invoice Number'] ?? $row['invoice number'] ?? null,
            'invoice_date'             => isset($row['invoice_date']) && is_numeric($row['invoice_date']) ? Date::excelToDateTimeObject($row['invoice_date']) : (isset($row['Invoice Date']) && is_numeric($row['Invoice Date']) ? Date::excelToDateTimeObject($row['Invoice Date']) : null),
            'transaction_type'         => $row['transaction_type'] ?? $row['Transaction Type'] ?? $row['transaction type'] ?? null,
            'transaction_description'  => $row['transaction_description'] ?? $row['Transaction Description'] ?? $row['transaction description'] ?? null,
            'invoice_amount'           => isset($row['invoice_amount']) && is_numeric($row['invoice_amount']) ? (float) $row['invoice_amount'] : (isset($row['Invoice Amount']) && is_numeric($row['Invoice Amount']) ? (float) $row['Invoice Amount'] : null),
            'amount_paid'              => isset($row['amount_paid']) && is_numeric($row['amount_paid']) ? (float) $row['amount_paid'] : (isset($row['Amount Paid']) && is_numeric($row['Amount Paid']) ? (float) $row['Amount Paid'] : null),
        ]);
    }
}
