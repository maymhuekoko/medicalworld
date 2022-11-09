<?php

namespace App\Http\Controllers\Api;

use App\Getlocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiBaseController;
use App\Category;



class CategoryApiController extends ApiBaseController
{
   public function index(){
       $categories = Category::where('type_flag',1)->wherein('id',[1,2,3,4,5])->get();

       //========================

       //========================
       return response()->json($categories);
   }
}
