<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
        'bank_acc_id',
        'tran_date',
        'tran_time',
        'remark',
        'pay_amount',
        'order_id'
    ];
    public function bank_account() {
        return $this->belongsTo(BankAccount::class,'bank_acc_id');
    }
    
    public function order() {
        return $this->belongsTo(Order::class,'order_id');
    }
    
}
