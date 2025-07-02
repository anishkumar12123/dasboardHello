<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DfInvoiceImport;
use App\Imports\ApprovedCoogsImport;
use App\Imports\CoogsDataImport;
use App\Imports\PoInvoiceImport;
use App\Imports\RemittanceImport;
use App\Imports\ReturnDataImport;
use App\Models\CoogsData;
use Illuminate\Support\Facades\Storage;

class ExcelUploadController extends Controller
{
    // ExcelUploadController.php (inside upload function)

    // Map aliases for sheet names (use lowercase and trimmed keys)
    public function upload(Request $request)
    {
        try {
            $request->validate([
                'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
            ]);

            $file = $request->file('excel_file');
            if (!$file->isValid()) {
                \Log::error('Invalid file uploaded: ' . $file->getClientOriginalName());
                return back()->with('error', '❌ Invalid file uploaded.');
            }

            $filename = $file->getClientOriginalName();
            \Log::info('Uploaded file: ' . $filename);

            $path = $file->storeAs('temp', $filename, 'local');

            if (!Storage::disk('local')->exists($path)) {
                \Log::error('File not found after upload: ' . storage_path('app/' . $path));
                return back()->with('error', '❌ File could not be saved.');
            }



            $imports = [
                // DF Invoice
                'df_invoice'         => DfInvoiceImport::class,
                'df invoice'         => DfInvoiceImport::class,
                'dfinvoicesheet'     => DfInvoiceImport::class,

                // Approved Coogs
                'approved_coogs'     => ApprovedCoogsImport::class,
                'approved coogs'     => ApprovedCoogsImport::class,
                'approvedcoogs'      => ApprovedCoogsImport::class,
                'coogs_approved'     => ApprovedCoogsImport::class,

                // PO Invoice
                'po_invoice'         => PoInvoiceImport::class,
                'po invoice'         => PoInvoiceImport::class,
                'purchaseorder'      => PoInvoiceImport::class,
                'purchase_order'     => PoInvoiceImport::class,

                // Coogs
                'coogs'              => CoogsDataImport::class,
                'coogs_data'         => CoogsDataImport::class,
                'coogs data'         => CoogsDataImport::class,

                // Remittance
                'remittance'         => RemittanceImport::class,
                'remittance_data'    => RemittanceImport::class,
                'remittance data'    => RemittanceImport::class,

                // Returns
                'returns'            => ReturnDataImport::class,
                'return_data'        => ReturnDataImport::class,
                'return data'        => ReturnDataImport::class,
                'returns_data'       => ReturnDataImport::class,
            ];


            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/' . $path));
            $sheetNames = $spreadsheet->getSheetNames();
            \Log::info('Available sheets in Excel file: ' . implode(', ', $sheetNames));

            $failures = [];
            $processedSheets = 0;

            foreach ($sheetNames as $index => $sheetName) {
                $sheetNameClean = strtolower(trim($sheetName));

                foreach ($imports as $alias => $importClass) {
                    if (str_contains($sheetNameClean, $alias)) {
                        \Log::info("✅ Importing sheet: '$sheetName' using $importClass");
                        $import = new $importClass();
                        Excel::import($import, storage_path('app/' . $path), null, \Maatwebsite\Excel\Excel::XLSX, ['sheet' => $index]);
                        $processedSheets++;

                        if (method_exists($import, 'failures') && $import->failures()->isNotEmpty()) {
                            $failures = array_merge($failures, $import->failures()->toArray());
                        }

                        break;
                    }
                }
            }

            if ($processedSheets === 0) {
                \Log::error('No matching sheets found.');
                return back()->with('error', '❌ No matching sheets were found in the uploaded file.');
            }

            if (!empty($failures)) {
                $errorMessages = [];
                foreach ($failures as $failure) {
                    $errorMessages[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
                }
                \Log::error('Import failures: ' . implode('; ', $errorMessages));
                return back()->with('error', 'Some rows failed to import: ' . implode('; ', $errorMessages));
            }

            return back()->with('success', '✅ All matched sheets imported successfully!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
            }
            \Log::error('Validation errors: ' . implode('; ', $errorMessages));
            return back()->with('error', 'Validation errors: ' . implode('; ', $errorMessages));
        } catch (\Exception $e) {
            \Log::error('Error importing file: ' . $e->getMessage());
            return back()->with('error', ' ❌ Error importing file: ' . $e->getMessage());
        }
    }
}
