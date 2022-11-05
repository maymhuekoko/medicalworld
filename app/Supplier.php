<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $fillable = [


        'name',
        'phone_number',
        'credit_amount',

    ];
}
