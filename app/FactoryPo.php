<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FactoryPo extends Model
{
    //
    protected $guarded = [];

    protected $fillable = [
        'po_number',
        'po_date',
        'po_type',
        'receive_date',
        'total_rolls',
        'total_yards',
        'total_quantity',
        'total_price',
        'status',
        'requested_by',
       'approved_by',
       'attach_file_path',
    ];

    public function factory_items() {       
        return $this->belongsToMany("App\FactoryItem")->withPivot('purchase_price','rolls','yards_per_roll','sub_yards','order_qty','remark');
    }
}
