<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable= ['size_name','size_description','gender_id'];
    protected $with= ['gender'];
    public function gender(){
        return $this->belongsTo(Gender::class);
    }
}
