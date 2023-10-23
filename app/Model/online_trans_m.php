<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class online_trans_m extends Model
{
    protected $table = "online_trans_m";

    protected $connection = 'peds_uk';

    public $timestamps = false;

    protected $primaryKey = "online_trans_m_id";

    protected $fillable = [
        'transaction_date',
        'customer_id',
        'inserted_date',
        'row_status',
        'transaction_type',
        'served_by',
        'served_date',
        'acknowledge_by',
        'acknowledge_date',
        'cancelled_by',
        'cancelled_date',
        'reason_to_cancel',
        'osca_id',
        'osca_id_checked',
        'prescription_checked',
        'trans_remarks',
        'trans_confirmation_code',
        'ancillary_location',
        'cash_on_hand',
        'with_transaction',
        'trans_or_number',
        'payment_opt',
        'extract_sched',
        'paymaya_id',
    ];
}
