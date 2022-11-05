<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountMain extends Model
{
    //
    protected $fillable = [
        "voucher_id",
        "voucher_code",
        "voucher_date",
        "discount_flag",
        "sale_customer_name",
        "items",
        "discount_type",
        "foc_flag",
        "all_foc_flag",
        "total_voucher_amount"
     ];
}

