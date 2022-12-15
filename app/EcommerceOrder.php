<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EcommerceOrder extends Model
{

	//use SoftDeletes;

    protected $guarded = [];

    protected $fillable = [
    	'order_code',
    	'order_date',
    	'delivered_date',
    	'customer_id',
    	'customer_name',
    	'customer_phone',
    	'order_type',
    	'order_status',
        'attach_flag',
    	'total_quantity',
    	'total_amount',
    	'delivery_fee',
    	'discount_type',
    	'discount_amount',
    	'payment_type',
    	'payment_channel',
        'advance',
        'collect_amount',
        'deliver_address',
        'billing_address',
        'remark',
    ];

    public function counting_unit() {
        return $this->belongsToMany(CountingUnit::class)->withPivot('quantity','price','discount_type','discount_value');
    }

    public function user()
    {
        return $this->belongsTo('App\User','sale_by');
    }


    public function sale_customer() {
		return $this->belongsTo('App\SalesCustomer','sales_customer_id');
	}

    // public function getCreatedAtAttribute($date) {
    //     return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('H:i A');
    // }
}

