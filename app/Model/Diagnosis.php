<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Diagnosis extends Model
{
    //use SoftDeletes;

    protected $table = "diagnose";

    protected $primaryKey = "id";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'transaction_id',
        'findings',
        'created_dt',
        'created_by',
        'remarks',
        'created_by_id',
        'prescription',
        'followup',
        'for_admission',
        'admission_reason',
        'weight',
        'height',
        'temp',
        'bp',
        'diet_full',
        'diet_fat',
        'diet_soft',
        'diet_salt',
        'diet_others',
        'diet_specs',
        'act_specs',
        'act_no_restrict',
        'act_w_restrict',
        'act_assisted',
        'act_ind',
        'additional_ins',
        'remarks',
        'followup_place',
        'to_other',
        'chiefcomplaints',
        'history',
        'diagosis',
        'opd_remarks',
        'done_followup',
        'medcert_req_date',
        'confirmed_payment_by',
        'confirmed_payment_dt',
        'confirmed_payment_id',
        'cert_diagnosis',
        'recupation',
        'created_dt_mc',
        'hascert',
        'hascert_status',
        'fittowork',
        'o2_stat',
        'pulse_rate',
        'rr',
        'inserted_initial_data_dt',
        'inserted_initial_data_by',
        'ps_patregisgter',
    ];
}
