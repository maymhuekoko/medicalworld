<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralCapital extends Model
{
    //
    protected $fillable = [
        'bussiness_name',
        'bussiness_type',
        'total_starting_capital',
        'number_shareholder',
        'current_capital',
        'current_fixed_asset',
        'current_cash',
        'current_equity',
        'reinvest_percent'
    ];
}
