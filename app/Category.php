<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
	
    protected $guarded = [];

    protected $fillable = [
        'category_code', 
        'category_name', 
        'created_by',
        'deleted_at',
    ];
}
