<?php

namespace App\Http\Controllers\Api;

use App\Getlocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiBaseController;
use App\Category;
use App\SubCategory;
use App\Item;



class ItemApiController extends ApiBaseController
{
   public function index(){
       $items = Item::all();
      
       //========================
       $item_list = array();
            foreach($items as $item){
            //Category
                $category = Category::find($item->category_id);
            // 
             //SubCategory
                $subcategory = SubCategory::find($item->sub_category_id);
            //   
                
            $id = $item->id;
            $item_code = $item->item_code;
            $item_name = $item->item_name;
            $customer_console = $item->customer_console;
            $unit_name = $item->unit_name;
            $category_name = $category->category_name;
            $subcategory_name = $subcategory->name;
            
            $combined = array('id' => $id, 'item_code' => $item_code, 'item_name' => $item_name, 'customer_console' => $customer_console, 'unit_name' =>$unit_name, 'category_name' => $category_name, 'subcategory_name' => $subcategory_name);

            array_push($item_list, $combined);
                
            }
       //========================
       return response()->json([
           "data" => $item_list,
           ]);
   }
   
   public function getItemByProductLine(Request $request){
       $items = Item::where('category_id',$request->category_id)->where('sub_category_id',$request->subcategory_id)->get();
       
       return response()->json($items);
   }
   
   public function getNewArrivalItems(){
       $item_list = Item::where('new_product_flag',1)->get();
       return response()->json($item_list);
   }
   
   public function getPromotionItems(){
       $item_list = Item::where('promotion_product_flag',1)->get();
       return response()->json($item_list);
   }
   public function getHotSaleItems(){
       $item_list = Item::where('hot_sale_flag',1)->get();
       return response()->json($item_list);
   }
}