<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = "customers";

    protected $connection = 'peds_uk';

    public $timestamps = false;

    protected $primaryKey = "customer_id";

    protected $fillable = [
        'customer_id',
        'lastname',
        'firstname',
        'middlename',
        'birthdate',
        'address',
        'username',
        'mobile_no',
        'is_verified',
        'verified_date',
        'date_inserted',
        'confirmation_code',
        'updated_at',
        'created_at',
        'patient_id',
        'is_migrated',
    ];
}
