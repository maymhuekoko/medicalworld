<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayCredit extends Model
{
    //
    protected $fillable = [ 
        'sale_customer_id','voucher_id','pay_amount','left_amount','voucher_id','voucher_status','pay_date','description','paid_status'
     ];
}
