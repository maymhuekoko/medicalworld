<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wayplanning extends Model
{
    protected $fillable = ['wayno','delivery_id','date','pick_delivery','township_id','start_time','end_time'];
}
