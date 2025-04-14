<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPatientRecordRequest;
use App\Http\Requests\StorePatientRecordRequest;
use App\Http\Requests\UpdatePatientRecordRequest;
use App\Models\PatientRecord;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PatientRecordsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('patient_record_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $patientRecords = PatientRecord::all();

        return view('admin.patientRecords.index', compact('patientRecords'));
    }

    public function create()
    {
        abort_if(Gate::denies('patient_record_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        // Auto-generate control number
        $latestId = PatientRecord::withTrashed()->max('id') + 1;
        $today = now()->format('Ymd');
        $controlNumber = 'CSWD-' . $today . '-' . str_pad($latestId, 4, '0', STR_PAD_LEFT);
    
        return view('admin.patientRecords.create', compact('controlNumber'));
    }
    

    public function store(StorePatientRecordRequest $request)
    {
        $request->merge([
            'status' => $request->status ?: 'Submitted', 
        ]);
        $patientRecord = PatientRecord::create($request->all());

        return redirect()->route('admin.patient-records.index');
    }

    public function edit(PatientRecord $patientRecord)
    {
        abort_if(Gate::denies('patient_record_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.patientRecords.edit', compact('patientRecord'));
    }

    public function update(UpdatePatientRecordRequest $request, PatientRecord $patientRecord)
    {
        $patientRecord->update($request->all());

        return redirect()->route('admin.patient-records.index');
    }

    public function show(PatientRecord $patientRecord)
    {
        abort_if(Gate::denies('patient_record_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.patientRecords.show', compact('patientRecord'));
    }

    public function destroy(PatientRecord $patientRecord)
    {
        abort_if(Gate::denies('patient_record_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $patientRecord->delete();

        return back();
    }

    public function massDestroy(MassDestroyPatientRecordRequest $request)
    {
        $patientRecords = PatientRecord::find(request('ids'));

        foreach ($patientRecords as $patientRecord) {
            $patientRecord->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
    


}