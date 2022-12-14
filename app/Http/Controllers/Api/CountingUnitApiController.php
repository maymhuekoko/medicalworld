<?php

namespace App\Http\Controllers\Api;

use App\Getlocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiBaseController;
use App\CountingUnit;
use App\Design;
use App\Fabric;
use App\Colour;
use App\Size;
use App\Gender;
use App\Item;


class CountingUnitApiController extends ApiBaseController
{
   public function index(){
       $countingUnits = CountingUnit::where('current_quantity', '>', 0)->get();
      
       //========================
       $counting_unit_list = array();
            foreach($countingUnits as $counting_unit){
            //Specs
                $design = Design::find($counting_unit->design_id);
                $fabric = Fabric::find($counting_unit->fabric_id);
                $colour = Colour::find($counting_unit->colour_id);
                $size = Size::find($counting_unit->size_id);
                $gender = Gender::find($counting_unit->gender_id);
            //   
                
            $id = $counting_unit->id;
            $unit_code = $counting_unit->unit_code;
            $unit_name = $counting_unit->unit_name;
            $design_name = $design->design_name;
            $fabric_name = $fabric->fabric_name ?? 'Fabric is Null';
            $colour_name = $colour->colour_name;
            $size_name = $size->size_name;
            $gender_name = $gender->gender_name;
            $order_price = $counting_unit->order_price;
            $purchase_price = $counting_unit->purchase_price;
            $item_id = $counting_unit->item_id;
            $combined = array('id' => $id, 'unit_code' => $unit_code, 'unit_name' => $unit_name, 'design_name' => $design_name, 'fabric_name' =>$fabric_name, 'colour_name' => $colour_name, 'size_name' => $size_name, 'gender_name' => $gender_name, 'order_price' => $order_price, 'purchase_price' => $purchase_price, 'item_id' => $item_id);

            array_push($counting_unit_list, $combined);
                
            }
       //========================
       return response()->json([
           "data" => $counting_unit_list,
           ]);
   }
   
   public function getUnitById(Request $request,$id){
       $countingUnits = CountingUnit::where('item_id',$id)->where('current_quantity', '>', 0)->get();
       $item = Item::find($id);

       $flag = Item::where('id', $id)->first();
       $valueofinstock = $flag->instock;
       $valueofpreorder = $flag->preorder;
      
       //========================
       $counting_unit_list = array();
            foreach($countingUnits as $counting_unit){
            //Specs
                $design = Design::find($counting_unit->design_id);
                $fabric = Fabric::find($counting_unit->fabric_id);
                $colour = Colour::find($counting_unit->colour_id);
                $size = Size::find($counting_unit->size_id);
                $gender = Gender::find($counting_unit->gender_id);
            //   
                
            $id = $counting_unit->id;
            $unit_code = $counting_unit->unit_code;
            $unit_name = $counting_unit->unit_name;
            $design_name = $design->design_name;
            $fabric_name = $fabric->fabric_name ?? 'Fabric is Null';
            $colour_name = $colour->colour_name;
            $size_name = $size->size_name;
            $gender_name = $gender->gender_name;
            $current_quantity = $counting_unit->current_quantity;
            $order_price = $counting_unit->order_price;
            $purchase_price = $counting_unit->purchase_price;
            $item_id = $counting_unit->item_id;
            $combined = array('id' => $id, 'unit_code' => $unit_code, 'unit_name' => $unit_name, 'design_name' => $design_name, 'fabric_name' =>$fabric_name, 'colour_name' => $colour_name, 'size_name' => $size_name, 'gender_name' => $gender_name, 'current_quantity' => $current_quantity, 'order_price' => $order_price, 'purchase_price' => $purchase_price, 'item_id' => $item_id);

            array_push($counting_unit_list, $combined);
                
            }
       //========================
       return response()->json(["item" => $item,"counting_units" =>$counting_unit_list,"valueofinstock" => $valueofinstock, "valueofpreorder"=>$valueofpreorder]
           );
   }
}