<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class trans_d extends Model
{
    protected $table = "trans_d";

    protected $connection = 'peds_uk';

    public $timestamps = false;

    protected $primaryKey = "trans_d_id";

    protected $fillable = [
        'trans_m_id',
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
        'inserted_by',
        'inserted_date',
        'prescription_id'
    ];
}
