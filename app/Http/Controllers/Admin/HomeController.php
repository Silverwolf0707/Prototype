<?php

namespace App\Http\Controllers\Admin;

use App\Models\PatientRecord;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;


class HomeController
{
    public function index()
    {
        $user = Auth::user();

        if ($user->roles->contains('title', 'Admin')) {
            // Admin Dashboard
            $settings1 = [
                'chart_title'        => 'Roles',
                'chart_type'         => 'bar',
                'report_type'        => 'group_by_string',
                'model'              => 'App\Models\Role',
                'group_by_field'     => 'title',
                'aggregate_function' => 'count',
                'filter_field'       => 'created_at',
                'column_class'       => 'col-md-3',
                'entries_number'     => '5',
                'translation_key'    => 'role',
            ];

            $chart1 = new LaravelChart($settings1);

            $settings2 = [
                'chart_title'        => 'Users',
                'chart_type'         => 'pie',
                'report_type'        => 'group_by_string',
                'model'              => 'App\Models\User',
                'group_by_field'     => 'name',
                'aggregate_function' => 'count',
                'filter_field'       => 'created_at',
                'column_class'       => 'col-md-3',
                'entries_number'     => '5',
                'translation_key'    => 'user',
            ];

            $chart2 = new LaravelChart($settings2);

            return view('home', compact('chart1', 'chart2'));
        } else {
            $year = request('year');

            // Get all available years for the dropdown
            $availableYears = PatientRecord::selectRaw('YEAR(date_processed) as year')
                ->distinct()
                ->orderByDesc('year')
                ->pluck('year')
                ->toArray();
    
            // Filter condition
            $query = PatientRecord::query();
            if ($year) {
                $query->whereYear('date_processed', $year);
            }

            // number blocks
            $totalPatients = PatientRecord::count();
            $totalBurialPatient = PatientRecord::where('case_category', 'Burial Assistance')->count();
            $totalEducationalPatient = PatientRecord::where('case_category', 'Educational Assistance')->count();
            $totalMedicalPatient = PatientRecord::where('case_category', 'Medical Assistance')->count();

            // bar charts
            $barchartSettings = [
                'chart_title'           => 'Patients Per Barangay',
                'chart_type'            => 'bar',
                'report_type'           => 'group_by_string',
                'model'                 => 'App\Models\PatientRecord',
                'group_by_field'        => 'barangay',  // <-- uses the accessor
                'column_class'          => 'col-md-12',
                'filter_field'          => 'created_at',
                'aggregate_function'    => 'count',
            ];
            $barangayChart = new LaravelChart($barchartSettings);
            
            // line chart time series
            $patientsPerMonth = PatientRecord::selectRaw('COUNT(*) as count, YEAR(date_processed) as year, MONTH(date_processed) as month')
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();

            // Prepare data for the line chart
            $months = [];
            $counts = [];
            foreach ($patientsPerMonth as $record) {
                $months[] = Carbon::createFromDate($record->year, $record->month, 1)->format('F Y'); // Format as "Month Year"
                $counts[] = $record->count;
            }

            // Time series line chart
            $linechartSettings = [
                'chart_title'        => 'Patients Per Month',
                'chart_type'         => 'line',  // Change to line chart
                'report_type'        => 'group_by_date',
                'model'              => 'App\Models\PatientRecord',
                'group_by_field'     => 'date_processed',
                'group_by_period'    => 'month',  // Group by created_at (date)
                'aggregate_function' => 'count',
                'filter_field'       => 'date_processed',
                'column_class'       => 'col-md-12',
                // 'data'               => [
                //     'labels'   => $months,  // X-axis labels (Month-Year)
                //     'datasets' => [
                //         [
                //             'label'           => 'Patients',
                //             'data'            => $counts,  // Y-axis data (Patient count)
                //             'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                //             'borderColor'     => 'rgba(75, 192, 192, 1)',
                //             'borderWidth'     => 10,
                //         ],
                //     ],
                // ],
            ];

            // Create the chart
            $lineChart = new LaravelChart($linechartSettings);
            
            return view('dashboard_offices', compact(
            'totalPatients', 
            'totalBurialPatient', 
            'totalEducationalPatient', 
            'totalMedicalPatient', 'barangayChart','lineChart','availableYears'));
        }
    }
}