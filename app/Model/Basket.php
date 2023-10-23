<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    protected $table = "basket";

    protected $primaryKey = "id";

    public $timestamps = false;

    protected $fillable = [
        'created_by',
        'created_dt',
        'tracking_no',
        'purchase_date',
        'delivery_guy',
        'total_amt_reg_price',
        'total_amt_disc_price',
        'total_amt_sc_pwd_price',
    ];
}
