<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class orderCustomer extends Model{
    //use SoftDeletes;
    
    protected $table = "order_customers";
    
    protected $guarded = [];
    
    protected $fillable = [
            'name',
            'phone',
            'address',
            'total_purchase_amount',
            'total_purchase_quantity',
            'total_purchase_times',
            'last_purchase_date'
        ];
        
    public function User(){
        return $this->belongsTo('App\User');
    }
}