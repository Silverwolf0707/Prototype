@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ __('Time Series Analytics') }}
        </div>

        <div class="card-body">
            <select id="caseCategorySelector" class="form-control mb-3"></select>

            <div id="loadingSpinner" style="display: none; text-align:center; padding: 40px;">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <canvas id="timeSeriesChart" height="100" style="display:none;"></canvas>
        </div>

    </div>
@endsection


@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let chart;
        const loadingSpinner = document.getElementById('loadingSpinner');
        const canvas = document.getElementById('timeSeriesChart');
        const selector = document.getElementById('caseCategorySelector');

        function renderChart(category, data) {
            const dataset = data[category];
            const ctx = canvas.getContext('2d');
            if (chart) chart.destroy();

            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dataset.dates,
                    datasets: [
                        { label: 'Observed', data: dataset.observed, borderColor: 'rgba(54, 162, 235, 1)', fill: false },
                        { label: 'Trend', data: dataset.trend, borderColor: 'rgba(255, 99, 132, 1)', fill: false },
                        { label: 'Seasonal', data: dataset.seasonal, borderColor: 'rgba(255, 206, 86, 1)', fill: false },
                        { label: 'Residual', data: dataset.residual, borderColor: 'rgba(153, 102, 255, 1)', fill: false }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: { mode: 'nearest', axis: 'x', intersect: false },
                    scales: {
                        x: { title: { display: true, text: 'Month' } },
                        y: { title: { display: true, text: 'Applications' } }
                    }
                }
            });

            loadingSpinner.style.display = 'none'; // hide spinner
            canvas.style.display = 'block';        // show chart
            selector.disabled = false;              // enable selector
        }

        loadingSpinner.style.display = 'block';   // show spinner on start
        canvas.style.display = 'none';             // hide chart while loading
        selector.disabled = true;                   // disable selector while loading

        fetch("{{ asset('storage/stl_output.json') }}")
            .then(res => res.json())
            .then(data => {
                const categories = Object.keys(data);

                categories.forEach(cat => {
                    const option = document.createElement('option');
                    option.value = cat;
                    option.textContent = cat;
                    selector.appendChild(option);
                });

                // Render first category chart
                renderChart(categories[0], data);

                selector.addEventListener('change', (e) => {
                    loadingSpinner.style.display = 'block';
                    canvas.style.display = 'none';
                    selector.disabled = true;

                    // Small delay to show spinner if needed
                    setTimeout(() => {
                        renderChart(e.target.value, data);
                    }, 300);
                });
            });


    </script>
@endsection