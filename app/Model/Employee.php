<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = "employee";

    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = [
        'name', 'email', 'address','salary','photo','phone','nid','joined_date',
    ];

}


