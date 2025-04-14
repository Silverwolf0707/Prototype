@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.patientRecord.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.patient-records.update", [$patientRecord->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="date_processed">{{ trans('cruds.patientRecord.fields.date_processed') }}</label>
                <input class="form-control datetime {{ $errors->has('date_processed') ? 'is-invalid' : '' }}" type="text" name="date_processed" id="date_processed" value="{{ old('date_processed', $patientRecord->date_processed) }}" required>
                @if($errors->has('date_processed'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_processed') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.patientRecord.fields.date_processed_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="case_type">{{ trans('cruds.patientRecord.fields.case_type') }}</label>
                <input class="form-control {{ $errors->has('case_type') ? 'is-invalid' : '' }}" type="text" name="case_type" id="case_type" value="{{ old('case_type', $patientRecord->case_type) }}" required>
                @if($errors->has('case_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('case_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.patientRecord.fields.case_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="control_number">{{ trans('cruds.patientRecord.fields.control_number') }}</label>
                <input class="form-control {{ $errors->has('control_number') ? 'is-invalid' : '' }}" type="text" name="control_number" id="control_number" value="{{ old('control_number', $patientRecord->control_number) }}" readonly required>
                @if($errors->has('control_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('control_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.patientRecord.fields.control_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="claimant_name">{{ trans('cruds.patientRecord.fields.claimant_name') }}</label>
                <input class="form-control {{ $errors->has('claimant_name') ? 'is-invalid' : '' }}" type="text" name="claimant_name" id="claimant_name" value="{{ old('claimant_name', $patientRecord->claimant_name) }}" required>
                @if($errors->has('claimant_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('claimant_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.patientRecord.fields.claimant_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.patientRecord.fields.case_category') }}</label>
                <select class="form-control {{ $errors->has('case_category') ? 'is-invalid' : '' }}" name="case_category" id="case_category" required>
                    <option value disabled {{ old('case_category', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\PatientRecord::CASE_CATEGORY_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('case_category', $patientRecord->case_category) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('case_category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('case_category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.patientRecord.fields.case_category_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="patient_name">{{ trans('cruds.patientRecord.fields.patient_name') }}</label>
                <input class="form-control {{ $errors->has('patient_name') ? 'is-invalid' : '' }}" type="text" name="patient_name" id="patient_name" value="{{ old('patient_name', $patientRecord->patient_name) }}" required>
                @if($errors->has('patient_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('patient_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.patientRecord.fields.patient_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="diagnosis">{{ trans('cruds.patientRecord.fields.diagnosis') }}</label>
                <textarea class="form-control {{ $errors->has('diagnosis') ? 'is-invalid' : '' }}" name="diagnosis" id="diagnosis" required>{{ old('diagnosis', $patientRecord->diagnosis) }}</textarea>
                @if($errors->has('diagnosis'))
                    <div class="invalid-feedback">
                        {{ $errors->first('diagnosis') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.patientRecord.fields.diagnosis_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="age">{{ trans('cruds.patientRecord.fields.age') }}</label>
                <input class="form-control {{ $errors->has('age') ? 'is-invalid' : '' }}" type="number" name="age" id="age" value="{{ old('age', $patientRecord->age) }}" step="1" required>
                @if($errors->has('age'))
                    <div class="invalid-feedback">
                        {{ $errors->first('age') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.patientRecord.fields.age_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="address">{{ trans('cruds.patientRecord.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $patientRecord->address) }}" required>
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.patientRecord.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="contact_number">{{ trans('cruds.patientRecord.fields.contact_number') }}</label>
                <input class="form-control {{ $errors->has('contact_number') ? 'is-invalid' : '' }}" type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', $patientRecord->contact_number) }}" required>
                @if($errors->has('contact_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('contact_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.patientRecord.fields.contact_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="case_worker">{{ trans('cruds.patientRecord.fields.case_worker') }}</label>
                <input class="form-control {{ $errors->has('case_worker') ? 'is-invalid' : '' }}" type="text" name="case_worker" id="case_worker" value="{{ old('case_worker', $patientRecord->case_worker) }}" readonly>
                @if($errors->has('case_worker'))
                    <div class="invalid-feedback">
                        {{ $errors->first('case_worker') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.patientRecord.fields.case_worker_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection