<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class From extends Model
{
    protected $fillable=['name'];

    public function items()
    {
		return $this->belongsToMany('App\Item','from_item','from_id','item_id')->withPivot('id','item_id','from_id');
    }
    public function counting_units()
    {
        return $this->hasManyThrough(CountingUnit::class, Item::class);
    }
}
