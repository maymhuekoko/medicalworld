<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomUnitOrder extends Model
{
    protected $fillable= ['item_name','design_id','fabric_id','colour_id','size_id','gender_id','selling_price'];
}
