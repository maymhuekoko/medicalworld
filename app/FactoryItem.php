<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FactoryItem extends Model
{
    //

    use SoftDeletes;

    protected $guarded = [];

    protected $fillable = [
        'item_code', 
        'item_name', 
        'created_by',
        'category_id',
        'subcategory_id',
        'deleted_at',
        'purchase_price',
        'instock_qty',
        'reserved_qty',
    ];

    
	public function category() {
        return $this->belongsTo(Category::class);
    }
    
    public function sub_category() {
        return $this->belongsTo(SubCategory::class);
    }
}
