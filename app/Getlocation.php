<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Getlocation extends Model
{
    protected $fillable = ['rider_id','address','lat','long'];
}
