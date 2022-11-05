<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharerHolderList extends Model
{
    //
    protected $fillable = [
        'general_capital_id',
        'name',
        'nrc_passprot',
        'position',
        'share_percent',
        'divident_percent',
        'capital_amount'
    ];

}
