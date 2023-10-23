<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Diagnostic_m extends Model
{
    protected $table = "diagnostic";

    protected $primaryKey = "diagnostic_id";

    public $timestamps = false;

    protected $fillable = [
        'diagnosis_id',
        'instructions',
        'diagnostic',
        'diagnostic_code',
        'created_at',
        'created_by',
        'updated_at',
        'isdone',
        'batch',
        'for_followup',
        'iscovid',
        'pspat',
        'doctor',
        'patientid',
    ];
}
