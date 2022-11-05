<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleCustomerCreditlist extends Model
{
    protected $fillable=['sales_customer_id','voucher_id','voucher_code','credit_amount','repaymentdate','status'

];

    public function sale_customer(){
        return $this->belongsTo('App\SalesCustomer','sales_customer_id');
    }
}

