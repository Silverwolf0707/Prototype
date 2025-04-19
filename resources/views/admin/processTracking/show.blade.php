@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            View Process Tracking
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>Control Number</th>
                    <td>{{ $patient->control_number }}</td>
                </tr>
                <tr>
                    <th>Date Processed</th>
                    <td>{{ \Carbon\Carbon::parse($patient->date_processed)->format('F j, Y g:i A') }}</td>
                </tr>
                <tr>
                    <th>Claimant Name</th>
                    <td>{{ $patient->claimant_name }}</td>
                </tr>
                <tr>
                    <th>Case Worker</th>
                    <td>{{ $patient->case_worker }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $latestStatus->status}}</td>
                </tr>

            </table>
            @if ($patient->statusLogs->count())
                <div class="mt-4">
                    <h5>Process Summary</h5>
                    <ul class="list-group">
                        @foreach ($patient->statusLogs as $log)
                            <li class="list-group-item">
                                <strong>{{ ucfirst($log->status) }}:</strong>
                                {{ $log->user->name ?? 'System' }} -
                                {{ \Carbon\Carbon::parse($log->created_at)->format('F j, Y g:i A') }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif


            @php
                $isFinalized = in_array(optional($latestStatus)->status, ['Approved', 'Rejected']);
            @endphp

            <div class="mt-4 d-flex gap-2">
                @can('approve_patient')
                    <form action="{{ route('admin.process-tracking.approve', $patient->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to approve this application?');">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-success" {{ $isFinalized ? 'disabled' : '' }}>
                            {{ $isFinalized && optional($latestStatus)->status === 'Approved' ? 'Approved' : 'Approve' }}
                        </button>
                    </form>
                @endcan

                @can('reject_patient')
                    <form action="{{ route('admin.process-tracking.reject', $patient->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to reject this application?');">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-danger" {{ $isFinalized ? 'disabled' : '' }}>
                            {{ $isFinalized && optional($latestStatus)->status === 'Rejected' ? 'Rejected' : 'Reject' }}
                        </button>
                    </form>
                @endcan

            </div>

        </div>
    </div>
@endsection