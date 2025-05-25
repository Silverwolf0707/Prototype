<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SpreadsheetReader;

trait CsvImportTrait
{
    public function processCsvImport(Request $request)
    {
        try {
            $filename   = $request->input('filename');
            $path       = storage_path('app/private/csv_import/' . $filename);
            $fields     = $request->input('fields', []);
            $fields     = array_flip(array_filter($fields));
            $modelName  = $request->input('modelName');
            $modelClass = "App\\Models\\" . $modelName;

            $reader = new SpreadsheetReader($path);
            // Auto-detect header row
            $reader->rewind();
            $firstRow = $reader->current();
            $matchCount = 0;
            foreach ($firstRow as $cell) {
                if (in_array(strtolower(trim($cell)), array_map('strtolower', array_keys($fields)))) {
                    $matchCount++;
                }
            }
            $skipHeader = $matchCount > 0;

            $insert = [];

            foreach ($reader as $index => $row) {
                // Skip detected header
                if ($skipHeader && $index === 0) {
                    continue;
                }

                $tmp = [];
                foreach ($fields as $header => $colIndex) {
                    if (isset($row[$colIndex]) && $row[$colIndex] !== '') {
                        $value = $row[$colIndex];
                        if (in_array($header, ['date_processed', 'created_at', 'updated_at'])) {
                            try {
                                $value = Carbon::createFromFormat('m/d/Y H:i', $value)
                                               ->format('Y-m-d H:i:s');
                            } catch (\Exception $e) {
                                $value = null;
                            }
                        }
                        $tmp[$header] = $value;
                    }
                }

                // Only insert rows where all mapped fields are present
                if (count($tmp) === count($fields)) {
                    $insert[] = $tmp;
                }
            }

            // Insert in chunks
            foreach (array_chunk($insert, 100) as $batch) {
                $modelClass::insert($batch);
            }

            $rows  = count($insert);
            $table = Str::plural($modelName);

            File::delete($path);
            session()->flash('message', trans(
                'global.app_imported_rows_to_table',
                ['rows' => $rows, 'table' => $table]
            ));

            return redirect($request->input('redirect'));
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function parseCsvImport(Request $request)
    {
        $file = $request->file('csv_file');
        $request->validate([
            'csv_file' => 'mimes:csv,txt',
        ]);

        $path    = $file->path();
        $reader  = new SpreadsheetReader($path);
        $headers = $reader->current();

        $lines = [];
        for ($i = 1; $i <= 5; $i++) {
            if ($reader->next() === false) {
                break;
            }
            $lines[] = $reader->current();
        }

        $filename = Str::random(10) . '.csv';
        $file->storeAs('csv_import', $filename);

        $modelName     = $request->input('model');
        $fullModelName = "App\\Models\\" . $modelName;

        $model       = new $fullModelName();
        $fillables   = $model->getFillable();
        // Exclude timestamp fields from mapping dropdown
        $exclude     = ['created_at', 'updated_at', 'deleted_at'];
        $fillables   = array_filter($fillables, function($f) use ($exclude) {
            return !in_array($f, $exclude);
        });

        $redirect  = url()->previous();
        $routeName = 'admin.' . strtolower(Str::plural(Str::kebab($modelName))) . '.processCsvImport';

        return view('csvImport.parseInput', compact(
            'headers',
            'filename',
            'fillables',
            'modelName',
            'lines',
            'redirect',
            'routeName'
        ));
    }
}
