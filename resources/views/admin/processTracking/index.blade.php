@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Process Tracking
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-ProcessTracking">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>Control Number</th>
                        <th>Date Processed</th>
                        <th>Claimant Name</th>
                        <th>Case Worker</th>
                        <th>Status</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient)
                        <tr data-entry-id="{{ $patient->id }}">
                            <td></td>
                            <td>{{ $patient->control_number }}</td>
                            <td>{{ $patient->date_processed }}</td>
                            <td>{{ $patient->claimant_name }}</td>
                            <td>{{ $patient->case_worker }}</td>
                            <td>
                                @php
                                    $statusColor = '';
                                    switch($patient->status) {
                                        case 'Submitted':
                                            $statusColor = '#0000FF'; // Light Blue
                                            break;
                                        case 'Approved':
                                            $statusColor = '#90EE90'; // Light Green
                                            break;
                                        case 'Rejected':
                                            $statusColor = '#F08080'; // Light Coral
                                            break;
                                        // Add more cases as needed
                                        default:
                                            $statusColor = '#D3D3D3'; // Light Gray
                                            break;
                                    }
                                @endphp
                                <span class="badge" style="background-color: {{ $statusColor }}; padding: 5px 10px; border-radius: 20px; color: white;">
                                    {{ $patient->status }}
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.process-tracking.show', ['process_tracking' => $patient->id]) }}">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@parent
<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[1, 'desc']],
            pageLength: 100,
        });

        let table = $('.datatable-ProcessTracking:not(.ajaxTable)').DataTable({ 
            buttons: dtButtons 
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    });
</script>
@endsection
