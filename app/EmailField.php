<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailField extends Model
{
    public $fillable = [
        'subject', 'title', 'subtitle', 'description', 'link', 'photo', 'attach'
    ];

    public $timestamps = false;
}
