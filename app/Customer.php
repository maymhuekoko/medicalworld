<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
	
    protected $guarded = [];

    protected $fillable = [ 
       	'phone','address','allow_credit','customer_level','user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
