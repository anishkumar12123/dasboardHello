<?php
namespace App\Imports;

use App\Models\ApprovedCoogsData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ApprovedCoogsImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        \Log::info('Processing approved_coogs row: ' . json_encode($row, JSON_PRETTY_PRINT));

        // Skip if key fields are empty
        if (empty($row['asin']) && empty($row['ASIN']) && empty($row['asin code']) && empty($row['ASIN Code']) &&
            empty($row['gross_ship_gms']) && empty($row['Gross Ship GMS']) && empty($row['gross ship gms'])) {
            \Log::warning('Skipping approved_coogs row: No valid data');
            return null;
        }

        // Handle net_net with default value
        $netNet = null;
        if (isset($row['net_net']) && is_numeric($row['net_net'])) {
            $netNet = (float) $row['net_net'];
        } elseif (isset($row['Net Net']) && is_numeric($row['Net Net'])) {
            $netNet = (float) $row['Net Net'];
        } elseif (isset($row['net net']) && is_numeric($row['net net'])) {
            $netNet = (float) $row['net net'];
        } else {
            \Log::warning('net_net is missing or non-numeric, defaulting to 0.0: ' . json_encode($row));
            $netNet = 0.0; // Default value
        }

        \Log::info('Inserting into approved_coogs_data: ' . json_encode($row, JSON_PRETTY_PRINT));
        return new ApprovedCoogsData([
            'asin'             => $row['asin'] ?? $row['ASIN'] ?? $row['asin code'] ?? $row['ASIN Code'] ?? null,
            'gross_ship_gms'  => isset($row['gross_ship_gms']) && is_numeric($row['gross_ship_gms']) ? (float) $row['gross_ship_gms'] : (isset($row['Gross Ship GMS']) && is_numeric($row['Gross Ship GMS']) ? (float) $row['Gross Ship GMS'] : null),
            'net_ship_gms'    => isset($row['net_ship_gms']) && is_numeric($row['net_ship_gms']) ? (float) $row['net_ship_gms'] : (isset($row['Net Ship GMS']) && is_numeric($row['Net Ship GMS']) ? (float) $row['Net Ship GMS'] : null),
            'order_date'      => isset($row['order_date']) && is_numeric($row['order_date']) ? Date::excelToDateTimeObject($row['order_date']) : (isset($row['Order Date']) && is_numeric($row['Order Date']) ? Date::excelToDateTimeObject($row['Order Date']) : null),
            'net_ship_units'  => isset($row['net_ship_units']) && is_numeric($row['net_ship_units']) ? (int) $row['net_ship_units'] : (isset($row['Net Ship Units']) && is_numeric($row['Net Ship Units']) ? (int) $row['Net Ship Units'] : null),
            'duration'        => $row['duration'] ?? $row['Duration'] ?? null,
            'net_net'         => $netNet,
            'net_served'      => isset($row['net_served']) && is_numeric($row['net_served']) ? (float) $row['net_served'] : (isset($row['Net Served']) && is_numeric($row['Net Served']) ? (float) $row['Net Served'] : null),
            'coop'            => isset($row['coop']) && is_numeric($row['coop']) ? (int) $row['coop'] : (isset($row['Coop']) && is_numeric($row['Coop']) ? (int) $row['Coop'] : null),
            'final_coop'      => isset($row['final_coop']) && is_numeric($row['final_coop']) ? (float) $row['final_coop'] : (isset($row['Final Coop']) && is_numeric($row['Final Coop']) ? (float) $row['Final Coop'] : null),
        ]);
    }
}
