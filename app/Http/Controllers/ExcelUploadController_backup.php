<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MultiTableImport;

class ExcelUploadController extends Controller
{
    public function upload(Request $request)
    {
        try {
            $request->validate([
                'excel_file' => 'required|file|mimes:xlsx,xls,csv',
            ]);

            $file = $request->file('excel_file');
            $filename = $file->getClientOriginalName();
            \Log::info('Uploaded file: ' . $filename);
            $path = $file->storeAs('temp', $filename);

            // Log sheet names for debugging
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/' . $path));
            $sheetNames = $spreadsheet->getSheetNames();
            \Log::info('Available sheets in Excel file: ' . implode(', ', $sheetNames));

            // Use MultiTableImport for single-sheet import
            $import = new MultiTableImport();
            Excel::import($import, $path);

            // Check for import failures
            if (method_exists($import, 'failures') && $import->failures()->isNotEmpty()) {
                $failures = $import->failures();
                $errorMessages = [];
                foreach ($failures as $failure) {
                    $errorMessages[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
                }
                \Log::error('Import failures: ' . implode('; ', $errorMessages));
                return back()->with('error', 'Some rows failed to import: ' . implode('; ', $errorMessages));
            }

            return back()->with('success', '✅ All data imported successfully!');
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
            return back()->with('error', '❌ Error importing file: ' . $e->getMessage());
        }
    }
}
