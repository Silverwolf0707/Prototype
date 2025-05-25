<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PatientRecord;
use App\Models\PatientStatusLog;
use App\Models\DisbursementVoucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ProcessTrackingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('process_tracking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $patients = PatientRecord::whereHas('statusLogs')->with(['latestStatusLog'])->get();


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


    public function decision(Request $request, $id)
    {
        abort_if(Gate::denies('approve_patient'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'remarks' => 'required|string|max:1000',
            'action' => 'required|in:approve,reject',
        ]);

        $patient = PatientRecord::findOrFail($id);
        $status = $request->action === 'approve' ? PatientStatusLog::STATUS_APPROVED : PatientStatusLog::STATUS_REJECTED;

        PatientStatusLog::create([
            'patient_id' => $patient->id,
            'status' => $status,
            'user_id' => Auth::id(),
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('admin.process-tracking.show', $id)
            ->with('status', 'Patient has been ' . strtolower($status) . '.');
    }

    public function storeDV(Request $request, $id)
{
    abort_if(Gate::denies('accounting_dv_input'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $request->validate([
        'dv_code' => 'required|string|max:255',
        'dv_date' => 'required|date',
    ]);

    $patient = PatientRecord::findOrFail($id);

    // Prevent multiple DV entries
    if ($patient->disbursementVoucher) {
        return back()->with('error', 'DV already submitted for this patient.');
    }

    DisbursementVoucher::create([
        'patient_id' => $patient->id,
        'user_id' => Auth::id(),
        'dv_code' => $request->dv_code,
        'dv_date' => $request->dv_date,
    ]);

    PatientStatusLog::create([
        'patient_id' => $patient->id,
        'user_id' => Auth::id(),
        'status' => 'DV Submitted',
        'remarks' => 'DV recorded: ' . $request->dv_code,
    ]);

    return redirect()->route('admin.process-tracking.show', $id)
        ->with('status', 'Disbursement Voucher added successfully.');
}
}
