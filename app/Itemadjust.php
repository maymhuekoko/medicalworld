<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itemadjust extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'counting_unit_id', 
        'oldstock_qty', 
        'adjust_qty',
        'extra_qty',
        'newstock_qty',
        'from_id',
        'user_id',
        'adjust_date',
        'adjust_remark'
    ];

    public function from(){
        return $this->belongsTo(From::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function counting_unit(){
        return $this->belongsTo(CountingUnit::class);
    }
}
