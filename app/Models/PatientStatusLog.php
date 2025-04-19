<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientStatusLog extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    const STATUS_SUBMITTED = 'Submitted';
    const STATUS_APPROVED = 'Approved';
    const STATUS_REJECTED = 'Rejected';

    protected $fillable = [
        'patient_id',
        'status',
        'user_id',
        'created_at',
    ];


    public function patient()
    {
        return $this->belongsTo(PatientRecord::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

