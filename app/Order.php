<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
   // use SoftDeletes;
    protected $guarded = [];
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    protected $fillable = [
       'order_number','address','name','phone','showroom','order_date','order_by','last_payment_date','delivered_date','total_quantity','total_discount_type','total_discount_value','est_price','status','customer_id','employee_id','payment_type','advance_pay','collect_amount','payment_clear_flag','delivery_fee','logo_fee','deleted_at'
    ];

    public function counting_unit() {
		return $this->belongsToMany('App\CountingUnit')->withPivot('id','quantity');
	}
	
	public function customer() {
		return $this->belongsTo('App\Customer');
	}

	public function employee() {

		return $this->belongsTo('App\Employee');
	}

    public function  customUnitOrder(){
        return $this->hasMany(CustomUnitOrder::class);
    }
    
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    
    public function factory_orders(){
        return $this->hasMany(FactoryOrder::class);
    }
    
    public function order_voucher() {
        return $this->belongsTo(OrderVoucher::class);
    }
}
