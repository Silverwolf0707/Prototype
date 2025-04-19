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
                        @foreach ($patients as $patient)
                            <tr data-entry-id="{{ $patient->id }}">
                                <td></td>
                                <td>{{ $patient->control_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($patient->date_processed)->format('F j, Y g:i A') }}</td>
                                <td>{{ $patient->claimant_name }}</td>
                                <td>{{ $patient->case_worker }}</td>
                                <td>
                                    @php
                                        $currentStatus = $patient->latestStatusLog->status ?? 'Submitted';
                                        $statusColor = match ($currentStatus) {
                                            'Submitted' => '#0000FF',
                                            'Approved' => '#90EE90',
                                            'Rejected' => '#FF0000',
                                            default => '#D3D3D3',
                                        };
                                    @endphp
                                    <span class="badge"
                                        style="background-color: {{ $statusColor }}; padding: 5px 10px; border-radius: 20px; color: white;">
                                        {{ $currentStatus }}
                                    </span>

                                </td>
                                <td>
                                    <a class="btn btn-xs btn-primary"
                                        href="{{ route('admin.process-tracking.show', ['process_tracking' => $patient->id]) }}">
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
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });

            let table = $('.datatable-ProcessTracking:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });
    </script>
@endsection
