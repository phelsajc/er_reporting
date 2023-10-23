<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $table = "inquiry";

    protected $primaryKey = "id";

    public $timestamps = false;

    protected $fillable = [
        'id',
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
        'ancillary_location',
        'pspat',
    ];
}
