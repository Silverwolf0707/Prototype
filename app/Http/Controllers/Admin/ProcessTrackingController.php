<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PatientRecord;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ProcessTrackingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('process_tracking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $patients = PatientRecord::select('id', 'control_number', 'date_processed', 'claimant_name', 'case_worker', 'status')->get();

        return view('admin.processTracking.index', compact('patients'));
    }

    public function show($id)
    {
        abort_if(Gate::denies('process_tracking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $patient = PatientRecord::select('id', 'control_number', 'date_processed', 'claimant_name', 'case_worker', 'status')->findOrFail($id);

        return view('admin.processTracking.show', compact('patient'));
    }
    public function approve($id)
{
    abort_if(Gate::denies('approve_patient'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $patient = PatientRecord::findOrFail($id);
    $patient->status = 'Approved';  
    $patient->save();

    return redirect()->route('admin.process-tracking.show', $id)->with('status', 'Patient has been approved.');
}

}
