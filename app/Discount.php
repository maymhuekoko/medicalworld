<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    //
    protected $fillable = [
       "item_id",
       "counting_unit_id",
       "voucher_id",
       "voucher_code",
       "voucher_date",
       "discount_flag",
       "discount_item_amount",
       "discount_voucher_amount",
       "original_price",
       "item_name",
       "counting_unit_name",
       "sale_customer_name",
       "discount_main_id"
    ];
    public function counting_units(){
        return $this->belongsTo(CountingUnit::class,'counting_unit_id');
    }
    public function item() {
		return $this->belongsTo(Item::class);
	}
    public function voucher() {
		return $this->belongsTo(Voucher::class);
	}
}


