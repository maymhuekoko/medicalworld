<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{

	use SoftDeletes;

    protected $guarded = [];

    protected $fillable = [
    	'voucher_code',
    	'total_price',
    	'total_quantity',
    	'sale_by',
    	'type',
    	'voucher_date',
    	'status',
    	'order_id',
    	'sales_customer_id',
    	'sales_customer_name',
    	'sales_customer_phone',
        'from_id',
        'is_mobile',
        'is_print',
        'pay',
        'change',
        'discount',
        'discount_type',
        'discount_value',
        'sales_remark',
    	'deleted_at'
    ];

    public function counting_unit() {
        return $this->belongsToMany(CountingUnit::class)->withPivot('quantity','price','discount','discount_type','discount_value');
    }

    public function user()
    {
        return $this->belongsTo('App\User','sale_by');
    }

    public function order() {
        return $this->belongsTo('App\Order');
    }
    public function sale_customer() {
		return $this->belongsTo('App\SalesCustomer','sales_customer_id');
	}

    public function getCreatedAtAttribute($date) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('H:i A');
    }
}

