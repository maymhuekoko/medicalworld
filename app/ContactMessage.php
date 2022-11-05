<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    public $fillable = [
        'name', 'email', 'message', 'subscribe_flag'    
    ];
}
