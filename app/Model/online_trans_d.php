<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class online_trans_d extends Model
{
    protected $table = "online_trans_d";

    protected $connection = 'peds_uk';

    public $timestamps = false;

    protected $primaryKey = "online_trans_d_id";

    protected $fillable = [
        'online_trans_m_id',
        'pk_iwitems',
        'item_description',
        'item_generic_name',
        'item_reg_price',
        'item_discounted_price',
        'item_sc_price',
        'item_qty',
        'item_total_amt_reg',
        'item_total_amt_disc',
        'item_total_amt_sc_disc',
        'customer_id',
        'inserted_date',
        'cancelled_by',
        'cancelled_date',
        'cancel_reason',
        'trans_confirmation_code',
        'updated_by',
        'updated_date',
        'is_cancelled',
        'inserted_by00',
    ];
}
