<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisbursementVoucher extends Model
{
    use HasFactory;
    protected $table = 'disbursement_voucher';


    protected $fillable = ['patient_id', 'user_id', 'dv_code', 'dv_date'];

    public function patient()
    {
        return $this->belongsTo(PatientRecord::class, 'patient_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
