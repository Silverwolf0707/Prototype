@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        View Process Tracking
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tr><th>Control Number</th><td>{{ $patient->control_number }}</td></tr>
            <tr><th>Date Processed</th><td>{{ $patient->date_processed }}</td></tr>
            <tr><th>Claimant Name</th><td>{{ $patient->claimant_name }}</td></tr>
            <tr><th>Case Worker</th><td>{{ $patient->case_worker }}</td></tr>
            <tr><th>Status</th><td>{{ $patient->status }}</td></tr>
        </table>

        @can('approve_patient')
            @if($patient->status != 'Approved')
                <form action="{{ route('admin.process-tracking.approve', $patient->id) }}" method="POST">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-success">Approve</button>
                </form>
            @else
                <button type="button" class="btn btn-success" disabled>Approved</button>
            @endif
        @endcan
    </div>
</div>
@endsection
