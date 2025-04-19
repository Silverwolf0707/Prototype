<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PatientRecord;
use App\Models\PatientStatusLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ProcessTrackingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('process_tracking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $patients = PatientRecord::with(['latestStatusLog'])->get();
    
        return view('admin.processTracking.index', compact('patients'));
    }
    

    public function show($id)
    {
        abort_if(Gate::denies('process_tracking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $patient = PatientRecord::with(['statusLogs.user'])
            ->select('id', 'control_number', 'date_processed', 'claimant_name', 'case_worker')
            ->findOrFail($id);
    
        $latestStatus = $patient->statusLogs->last(); // or ->whereNotNull('created_at')->last()
    
        return view('admin.processTracking.show', compact('patient', 'latestStatus'));
    }
    
    
    public function approve($id)
    {
        abort_if(Gate::denies('approve_patient'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $patient = PatientRecord::findOrFail($id);
        PatientStatusLog::create([
            'patient_id' => $patient->id,
            'status' => PatientStatusLog::STATUS_APPROVED,
            'user_id' => Auth::id(),
        ]);
        

        return redirect()->route('admin.process-tracking.show', $id)->with('status', 'Patient has been approved.');
    }
    public function reject($id)
    {
        abort_if(Gate::denies('reject_patient'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $patient = PatientRecord::findOrFail($id);
        PatientStatusLog::create([
            'patient_id' => $patient->id,
            'status' => PatientStatusLog::STATUS_REJECTED,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.process-tracking.show', $id)->with('status', 'Patient has been rejected.');
    }
}
