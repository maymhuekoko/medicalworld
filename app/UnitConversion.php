<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitConversion extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'from_unit_id', 
        'from_unit_quantity', 
        'to_unit_id',
        'to_unit_quantity',
        'item_id'
    ];
}
