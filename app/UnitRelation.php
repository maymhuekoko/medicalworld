<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitRelation extends Model
{

	protected $guarded = [];

	protected $fillable = [
        'from_unit', 
        'to_unit', 
        'quantity',
        'item_id'
    ];

    public function from_unit_detail(){
        return $this->belongsTo(CountingUnit::class, "from_unit", "id");
    }
    public function to_unit_detail(){
        return $this->belongsTo(CountingUnit::class, "to_unit", "id");
    }
}
