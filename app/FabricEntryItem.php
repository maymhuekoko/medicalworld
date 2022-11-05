<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FabricEntryItem extends Model
{
    protected $fillable= ['factory_item_id','factory_item_name','instock_qty'];
}
