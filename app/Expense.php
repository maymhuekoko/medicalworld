<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        
        'type','period','date','title','description','amount','profit_loss_flag'
    ];
}
