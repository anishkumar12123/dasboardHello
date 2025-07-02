<?php
namespace App\Imports;

use App\Models\CoogsData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CoogsDataImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        \Log::info('Processing coogs row: ' . json_encode($row, JSON_PRETTY_PRINT));

        // Skip if all key fields are empty
        if (empty($row['invoice_id']) && empty($row['Invoice ID']) && empty($row['invoice id']) &&
            empty($row['agreement_id']) && empty($row['Agreement ID']) && empty($row['agreement id']) &&
            empty($row['original_balance']) && empty($row['Original Balance'])) {
            \Log::warning('Skipping coogs row: No valid data');
            return null;
        }

        \Log::info('Inserting into coogs_data: ' . json_encode($row, JSON_PRETTY_PRINT));
        return new CoogsData([
            'invoice_id'        => $row['invoice_id'] ?? $row['Invoice ID'] ?? $row['invoice id'] ?? null,
            'invoice_date'      => isset($row['invoice_date']) && is_numeric($row['invoice_date']) ? Date::excelToDateTimeObject($row['invoice_date']) : (isset($row['Invoice Date']) && is_numeric($row['Invoice Date']) ? Date::excelToDateTimeObject($row['Invoice Date']) : null),
            'agreement_id'      => $row['agreement_id'] ?? $row['Agreement ID'] ?? $row['agreement id'] ?? null,
            'agreement_title'   => $row['agreement_title'] ?? $row['Agreement Title'] ?? $row['agreement title'] ?? null,
            'funding_type'      => $row['funding_type'] ?? $row['Funding Type'] ?? $row['funding type'] ?? null,
            'original_balance'  => isset($row['original_balance']) && is_numeric($row['original_balance']) ? (float) $row['original_balance'] : (isset($row['Original Balance']) && is_numeric($row['Original Balance']) ? (float) $row['Original Balance'] : null),
        ]);
    }
}
