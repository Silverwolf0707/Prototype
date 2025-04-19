@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.patientRecord.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.patientRecord.fields.date_processed') }}
                        </th>
                        <td>
                            {{ \Carbon\Carbon::parse($patientRecord->date_processed)->format('F j, Y g:i A') }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patientRecord.fields.case_type') }}
                        </th>
                        <td>
                            {{ $patientRecord->case_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patientRecord.fields.control_number') }}
                        </th>
                        <td>
                            {{ $patientRecord->control_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patientRecord.fields.claimant_name') }}
                        </th>
                        <td>
                            {{ $patientRecord->claimant_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patientRecord.fields.case_category') }}
                        </th>
                        <td>
                            {{ App\Models\PatientRecord::CASE_CATEGORY_SELECT[$patientRecord->case_category] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patientRecord.fields.patient_name') }}
                        </th>
                        <td>
                            {{ $patientRecord->patient_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patientRecord.fields.diagnosis') }}
                        </th>
                        <td>
                            {{ $patientRecord->diagnosis }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patientRecord.fields.age') }}
                        </th>
                        <td>
                            {{ $patientRecord->age }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patientRecord.fields.address') }}
                        </th>
                        <td>
                            {{ $patientRecord->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patientRecord.fields.contact_number') }}
                        </th>
                        <td>
                            {{ $patientRecord->contact_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patientRecord.fields.case_worker') }}
                        </th>
                        <td>
                            {{ $patientRecord->case_worker }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.patient-records.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection