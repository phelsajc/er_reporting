<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $table = "logs";

    protected $primaryKey = "id";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'idno',
        'name',
        'ipaddress',
        'date_attempt',
    ];
}
