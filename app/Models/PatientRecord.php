<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientRecord extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'patient_records';

    protected $dates = [
        'date_processed',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const CASE_CATEGORY_SELECT = [
        'Burial Assistance'      => 'Burial Assistance',
        'Educational Assistance' => 'Educational Assistance',
        'Medical Assistance'     => 'Medical Assistance',
    ];

    protected $fillable = [
        'date_processed',
        'case_type',
        'control_number',
        'claimant_name',
        'case_category',
        'patient_name',
        'diagnosis',
        'age',
        'address',
        'contact_number',
        'case_worker',
        'created_at',
        'updated_at',
        'deleted_at',
        'status',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getDateProcessedAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setDateProcessedAttribute($value)
    {
        $this->attributes['date_processed'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }
    public function getBarangayAttribute()
{
    $barangays = [
        'Bagong Silang', 'Calendola', 'Chrysanthemum', 'Cuyab', 'Estrella', 'Fatima', 'GSIS', 'Landayan',
        'Langgam', 'Laram', 'Magsaysay', 'Maharlika', 'Narra', 'Nueva', 'Pacita 1', 'Pacita 2',
        'Poblacion', 'Riverside', 'Rosario', 'Sampaguita', 'San Antonio', 'San Isidro', 'San Lorenzo Ruiz',
        'San Roque', 'San Vicente', 'Santo Niño', 'United Bayanihan', 'United Better Living'
    ];

    $address = strtolower($this->address);

    foreach ($barangays as $brgy) {
        if (str_contains($address, strtolower($brgy))) {
            return $brgy;
        }
    }

    return 'Unknown';
}

}