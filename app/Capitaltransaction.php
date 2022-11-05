<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Capitaltransaction extends Model
{
    //
    protected $fillable = [
        'type',
        'amount',
        'date',
        'source',
        'remark',
    ];
}

