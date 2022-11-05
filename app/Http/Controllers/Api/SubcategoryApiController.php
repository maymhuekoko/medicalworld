<?php

namespace App\Http\Controllers\Api;

use App\Getlocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiBaseController;
use App\Category;
use App\SubCategory;



class SubcategoryApiController extends ApiBaseController
{
   public function index(){
       $subcategories = SubCategory::all();
      
       //========================
       $subcategory_list = array();
            foreach($subcategories as $subcategory){
            //Category
                $category = Category::find($subcategory->category_id);
                
            //   
                
            $id = $subcategory->id;
            $subcategory_code = $subcategory->subcategory_code;
            $name = $subcategory->name;
            $category_name = $category->category_name;
            $type_flag = $subcategory->type_flag;
            $combined = array('id' => $id, 'subcategory_code' => $subcategory_code, 'name' => $name, 'category_name' => $category_name, 'type_flag' =>$type_flag);

            array_push($subcategory_list, $combined);
                
            }
       //========================
       return response()->json([
           "data" => $subcategory_list,
           ]);
   }
   
   public function getSubcategoryById(Request $request,$id){
       $category_id = $id;
       $subcategories = SubCategory::where('category_id',$category_id)->get();
       return response()->json($subcategories);
   }
}