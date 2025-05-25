@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ __('Time Series Analytics') }}
        </div>

        <div class="card-body">
            <canvas id="timeSeriesChart" height="100"></canvas>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Fetch STL JSON output from Laravel storage
        fetch("{{ asset('storage/stl_output.json') }}")
            .then(res => res.json())
            .then(data => {
                const ctx = document.getElementById('timeSeriesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.dates,
                        datasets: [
                            {
                                label: 'Observed',
                                data: data.observed,
                                borderColor: 'rgba(54, 162, 235, 1)',
                                fill: false,
                            },
                            {
                                label: 'Trend',
                                data: data.trend,
                                borderColor: 'rgba(255, 99, 132, 1)',
                                fill: false,
                            },
                            {
                                label: 'Seasonal',
                                data: data.seasonal,
                                borderColor: 'rgba(255, 206, 86, 1)',
                                fill: false,
                            },
                            {
                                label: 'Residual',
                                data: data.residual,
                                borderColor: 'rgba(153, 102, 255, 1)',
                                fill: false,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        },
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Month'
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Application Counts'
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error loading STL data:', error);
            });
    </script>
@endsection
