<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShareholderList extends Model
{
    //
    protected $fillable = [
        'general_information_id',
        'name',
        'nrc_passport',
        'position',
        'share_percent',
        'devident_percent',
        'capital_amount',
    ];
}
