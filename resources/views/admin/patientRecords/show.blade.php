@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.patientRecord.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>{{ trans('cruds.patientRecord.fields.date_processed') }}</th>
                            <td>{{ \Carbon\Carbon::parse($patientRecord->date_processed)->format('F j, Y g:i A') }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.patientRecord.fields.case_type') }}</th>
                            <td>{{ $patientRecord->case_type }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.patientRecord.fields.control_number') }}</th>
                            <td>{{ $patientRecord->control_number }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.patientRecord.fields.claimant_name') }}</th>
                            <td>{{ $patientRecord->claimant_name }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.patientRecord.fields.case_category') }}</th>
                            <td>{{ App\Models\PatientRecord::CASE_CATEGORY_SELECT[$patientRecord->case_category] ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.patientRecord.fields.patient_name') }}</th>
                            <td>{{ $patientRecord->patient_name }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.patientRecord.fields.diagnosis') }}</th>
                            <td>{{ $patientRecord->diagnosis }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.patientRecord.fields.age') }}</th>
                            <td>{{ $patientRecord->age }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.patientRecord.fields.address') }}</th>
                            <td>{{ $patientRecord->address }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.patientRecord.fields.contact_number') }}</th>
                            <td>{{ $patientRecord->contact_number }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.patientRecord.fields.case_worker') }}</th>
                            <td>{{ $patientRecord->case_worker }}</td>
                        </tr>
                    </tbody>
                </table>

                @php
                    $latestStatusValue = optional($latestStatus)->status;
                    $isLocked = !in_array($latestStatusValue, [null, 'Rejected']);
                @endphp

                <!-- Remarks Form -->
                @can('submit_patient_application')
                    <!-- Remarks Form -->
                    <div class="card mt-4">
                        <div class="card-header">Submit Application</div>
                        <div class="card-body">
                            <form action="{{ route('admin.patient-records.submit', $patientRecord->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Submitted">
                                <div class="mb-3">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <textarea name="remarks" id="remarks" class="form-control" rows="4" required @if($isLocked)
                                    disabled @endif></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" @if($isLocked) disabled @endif>Submit</button>
                            </form>

                            @if($isLocked)
                                <div class="alert alert-info mt-3">
                                    This application has already been submitted and is currently in process.
                                </div>
                            @endif
                        </div>
                    </div>
                @endcan


                <div class="form-group mt-3">
                    <a class="btn btn-default" href="{{ route('admin.patient-records.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <a class="btn btn-info {{ !$hasProcessTracking ? 'disabled' : '' }}"
        href="{{ $hasProcessTracking ? route('admin.process-tracking.show', $patientRecord->id) : '#' }}"
        @if(!$hasProcessTracking) aria-disabled="true" tabindex="-1" @endif>
        View Process Tracking
    </a>



@endsection