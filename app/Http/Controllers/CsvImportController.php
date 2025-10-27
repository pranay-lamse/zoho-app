<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CsvImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');

        // ✅ Open the CSV file
        $handle = fopen($file->getRealPath(), 'r');

        $header = fgetcsv($handle); // Skip header row

        $batchData = [];
        $batchSize = 5000; // Chunk insert for performance

        while (($row = fgetcsv($handle)) !== FALSE) {

            $batchData[] = [
                'name' => $row[0] ?? null,
                'email' => $row[1] ?? null,
                'phone' => $row[2] ?? null,
                'state' => $row[3] ?? null,
                'city' => $row[4] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($batchData) >= $batchSize) {
                DB::table('import_data')->insert($batchData);
                $batchData = [];
            }
        }

        // Insert remaining rows
        if (!empty($batchData)) {
            DB::table('import_data')->insert($batchData);
        }

        fclose($handle);

        return back()->with('success', 'CSV Imported Successfully ✅');
    }
}
