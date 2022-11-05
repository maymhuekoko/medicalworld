<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deliveryreceive extends Model
{
    protected $fillable = ["customer_name","customer_phone","pick_delivery","pickup_address","pickup_township_id","pickup_charges","contactname_at_pickup","contactphone_at_pickup","destination_address","township_id","delivery_charges","contactname_at_destination","contactphone_at_destination"];

    public function packagelists() {
		return $this->belongsToMany('App\Packagetype')->withPivot('id','dimension','pickup_delivery','qty','price');
	}
}
