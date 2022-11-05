<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colour extends Model
{
    protected $fillable= ['colour_name','colour_description','fabric_id'];
    protected $with= ['fabric'];
    public function fabric(){
        return $this->belongsTo(Fabric::class);
    }
}
