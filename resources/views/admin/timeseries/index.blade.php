@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-1">{{ __('Time Series Analytics') }}</h5>
        <small class="text-muted">Visualize trends, seasonality, and variations in patient application categories over time.</small>
    </div>

    <div class="card-body">
        <div class="row mb-3 align-items-center">
            <div class="col-md-8">
                <select id="caseCategorySelector" class="form-control" style="width: 100%;"></select>
            </div>
            <div class="col-md-4 text-end">
                <button id="downloadChart" class="btn btn-outline-primary">Download Chart</button>
            </div>
        </div>

        <div id="loadingSpinner" style="display: none; text-align:center; padding: 40px;">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <canvas id="timeSeriesChart" height="100" style="display:none;"></canvas>

        {{-- Include the summary report partial --}}
        @include('admin.timeseries.report')
    </div>
</div>
@endsection

@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script>
        let chart;
        const loadingSpinner = document.getElementById('loadingSpinner');
        const canvas = document.getElementById('timeSeriesChart');
        const selector = document.getElementById('caseCategorySelector');

        const summaryContainer = document.getElementById('summaryReport');
        const summaryContent = document.getElementById('summaryContent');

        // Initial UI state
        loadingSpinner.style.display = 'block';
        canvas.style.display = 'none';
        selector.disabled = true;
        summaryContainer.style.display = 'none';

        $(document).ready(function () {
            $(selector).select2({
                placeholder: "Select a Case Category",
                width: 'resolve'
            });

            setTimeout(() => {
                fetchDataAndRender();
            }, 10);
        });

        function fetchDataAndRender() {
            fetch("{{ asset('storage/stl_output.json') }}")
                .then(res => res.json())
                .then(data => {
                    const categories = Object.keys(data);

                    // Populate selector
                    categories.forEach(cat => {
                        const option = document.createElement('option');
                        option.value = cat;
                        option.textContent = cat;
                        selector.appendChild(option);
                    });

                    $(selector).val(categories[0]).trigger('change');
                    renderChart(categories[0], data);

                    selector.addEventListener('change', (e) => {
                        loadingSpinner.style.display = 'block';
                        canvas.style.display = 'none';
                        selector.disabled = true;
                        summaryContainer.style.display = 'none';

                        setTimeout(() => {
                            renderChart(e.target.value, data);
                        }, 300);
                    });

                    document.getElementById('downloadChart').addEventListener('click', () => {
                        const link = document.createElement('a');
                        link.href = chart.toBase64Image();
                        link.download = `${selector.value}_time_series_chart.png`;
                        link.click();
                    });
                });
        }

        function renderChart(category, data) {
            const dataset = data[category];
            const ctx = canvas.getContext('2d');
            if (chart) chart.destroy();

            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dataset.dates,
                    datasets: [
                        {
                            label: 'Observed',
                            data: dataset.observed,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Trend',
                            data: dataset.trend,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Seasonal',
                            data: dataset.seasonal,
                            borderColor: 'rgba(255, 206, 86, 1)',
                            backgroundColor: 'rgba(255, 206, 86, 0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Residual',
                            data: dataset.residual,
                            borderColor: 'rgba(153, 102, 255, 1)',
                            backgroundColor: 'rgba(153, 102, 255, 0.1)',
                            fill: true,
                            tension: 0.4
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
                    plugins: {
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        },
                        legend: {
                            position: 'bottom'
                        }
                    },
                    scales: {
                        x: {
                            title: { display: true, text: 'Month' }
                        },
                        y: {
                            title: { display: true, text: 'Applications' }
                        }
                    }
                }
            });

            loadingSpinner.style.display = 'none';
            canvas.style.display = 'block';
            selector.disabled = false;

            generateSummary(dataset);
        }

        function generateSummary(dataset) {
            const avg = arr => arr.reduce((a, b) => a + b, 0) / arr.length;
            const max = arr => Math.max(...arr);
            const min = arr => Math.min(...arr);

            const observed = dataset.observed;
            const dates = dataset.dates;
            const maxValue = max(observed);
            const minValue = min(observed);
            const maxIndex = observed.indexOf(maxValue);
            const minIndex = observed.indexOf(minValue);
            const average = avg(observed).toFixed(2);

            summaryContent.innerHTML = `
                <li class="list-group-item"><strong>Average Applications per Month:</strong> ${average}</li>
                <li class="list-group-item"><strong>Peak Applications:</strong> ${maxValue} in ${dates[maxIndex]}</li>
                <li class="list-group-item"><strong>Lowest Applications:</strong> ${minValue} in ${dates[minIndex]}</li>
                <li class="list-group-item"><strong>Trend Insight:</strong> ${interpretTrend(dataset.trend)}</li>
            `;

            summaryContainer.style.display = 'block';
        }

        function interpretTrend(trend) {
            const start = trend[0];
            const end = trend[trend.length - 1];
            if (end > start) return "Upward trend observed.";
            else if (end < start) return "Downward trend observed.";
            else return "Stable trend.";
        }
    </script>
@endsection
