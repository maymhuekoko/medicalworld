<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierCreditList extends Model
{
    //
    protected $fillable = [

        'purchase_id',
        'credit_amount',
        'repay_date',
        'paid_status',
        'supplier_id',

    ];
    public function purchase(){
        return $this->belongsTo('App\Purchase','purchase_id');
    }
    public function supplier(){
        return $this->belongsTo('App\Supplier','supplier_id');
    }

}

