<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stockcount extends Model
{
    protected $fillable=['stock_qty','counting_unit_id','from_id'];
   
    public function stockunit()
    {
        return $this->belongsTo(CountingUnit::class,'counting_unit_id');
        
    }
}
