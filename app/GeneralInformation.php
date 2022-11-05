<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralInformation extends Model
{
    //
    protected $fillable = [
        'bussiness_name',
        'business_type',
        'total_starting_capital',
        'number_shareholder',
        'current_capital',
        'current_fixedasset',
        'current_cash',
        'current_equity',
        'reinvest_percent',
        'future_year',
        'old_holder'

    ];
}
