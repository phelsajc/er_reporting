<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Basket_detail extends Model
{
    protected $table = "basket_detail";

    protected $primaryKey = "id";

    public $timestamps = false;

    protected $fillable = [
        'basket_id',
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
    ];
}
