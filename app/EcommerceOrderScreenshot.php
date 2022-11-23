<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcommerceOrderScreenshot extends Model
{
    use HasFactory;

    protected $fillable = ['ecommerce_order_id','screenshot','remark','amount'];
}
