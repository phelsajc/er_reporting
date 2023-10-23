<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BedCapacity extends Model
{
    protected $table = "bed_capacity";

    protected $primaryKey = "id";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'capacity',
        'sation',
    ];
}
