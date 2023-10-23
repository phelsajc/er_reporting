<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Prescriptions_m extends Model
{
    protected $table = "prescription";

    protected $primaryKey = "prescription_id";

    public $timestamps = false;

    protected $fillable = [
        'diagnosis_id',
        'medecine_id',
        'medecine_desc',
        'dosage',
        'instruction',
        'created_by',
        'created_at',
        'updated_at',
        'generic_name',
        'bf_a',
        'bf_b',
        'ln_a',
        'ln_b',
        'sp_a',
        'sp_b',
        'quantity',
        'days',
        'frequency',
        'days',
        'time',
        'ispc',
        'frequency_txt',
        'isdone',
        'batch',
        'price',
        'sc_price',
        'dc_price',
        'isprinted',
        'for_followup',
        'iscovid',
        'pspat',
        'doctor',
        'bf_time',
        'ln_time',
        'sp_time',
        'bbt_time',
        'due',
    ];

    /* public function patient_profile()
    {
        return $this->hasOneThrough(Patient::class);
    } */
}
