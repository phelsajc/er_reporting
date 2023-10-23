<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Census extends Model
{
    protected $table = "census";

    protected $primaryKey = "id";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'psadmission',
        'psrooms',
        'bedno',
        'patregister',
        'status',
        'registrycode',
        'registryclass',
        'patienttype',
        'patientid',
        'patientcode',
        'name',
        'plan',
        'sssgsisno',
        'station',
        'address',
        'sex',
        'civilstatus',
        'dischargedate',
        'registrydate',
        'age',
        'primaryadmitdoctor',
        'serviceid',
        'servicetype',
        'newbornstatus',
        'admissiontype',
        'primaryattendingdoctor',
        'created_dt',
    ];
}
