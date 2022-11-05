<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierPayCredit extends Model
{
    //
    protected $fillable = [

        'purchase_id',
        'pay_amount',
        'description',
        'paid_status',
        'pay_date',
        'left_amount',
        'supplier_id'

    ];
}

