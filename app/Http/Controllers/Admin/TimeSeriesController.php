<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TimeSeriesController extends Controller
{
    public function index()
    {
        return view('admin.timeSeries.index');
    }

    public function exportToCsvFile()
    {
        $data = DB::table('patient_records')
            ->select('date_processed')
            ->whereNull('deleted_at')
            ->orderBy('date_processed')
            ->get();

        $csv = "date_processed,value\n";
        foreach ($data as $row) {
            $csv .= "{$row->date_processed},1\n";
        }

        Storage::disk('public')->put('patient_records.csv', $csv);

        return response()->json(['message' => 'CSV exported successfully']);
    }

    public function runPythonStl()
    {
        $pythonPath = base_path('venv/Scripts/python.exe'); // no leading C:\ if base_path is project root
        $scriptPath = base_path('python/stl_analysis.py'); // relative to project root

        exec("\"$pythonPath\" \"$scriptPath\"", $output, $return_var);

        if ($return_var !== 0) {
            return response()->json(['error' => 'Python script failed', 'output' => $output], 500);
        }

        // The file path here should not have 'storage/storage' doubled
        $jsonPath = storage_path('app/public/stl_output.json');

        if (!file_exists($jsonPath)) {
            return response()->json(['error' => 'STL output JSON file not found'], 500);
        }

        $json = file_get_contents($jsonPath);
        $data = json_decode($json, true);

        return response()->json($data);
    }
}
