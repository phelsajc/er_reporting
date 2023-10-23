<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class trans_m extends Model
{
    protected $table = "trans_m";

    protected $connection = 'peds_uk';

    public $timestamps = false;

    protected $primaryKey = "trans_m_id";

    protected $fillable = [
        'transaction_date',
        'inserted_by',
        'inserted_date',
        'total_amt_reg_price',
        'total_amt_disc_price',
        'total_amt_sc_pwd_price',
        'row_status',
        'transaction_type',
        'osca_id',
        'contact_no'
    ];
}
