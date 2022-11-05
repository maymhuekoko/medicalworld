<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itemrequest extends Model
{
    protected $fillable = ['total_quantity','date','request_by','from_id','status'];

    // public function counting_units() {
    //     return $this->belongsToMany(CountingUnit::class)->withPivot('counting_unit_id','quantity');
    // }
    public function counting_units() {
		return $this->belongsToMany(CountingUnit::class)->withPivot('id','itemrequest_id','counting_unit_id','quantity','send_quantity');
	}

	public function user(){
        return $this->belongsTo('App\User','request_by');
    }
    public function from(){
        return $this->belongsTo('App\From','from_id');
    }
}
