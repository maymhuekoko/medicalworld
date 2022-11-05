<?php

namespace App\Http\Controllers\Api;

use App\Size;
use DateTime;
use App\Colour;
use App\Design;
use App\Fabric;
use App\Gender;
use App\Township;
use App\Getlocation;
use App\CountingUnit;
use App\Mail\Invoice;
use App\EcommerceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiBaseController;


class EcommerceOrderApiController extends ApiBaseController
{
   //Index
   public function index(){
       $instock = EcommerceOrder::where('order_type',1)->get();
       $preorder = EcommerceOrder::where('order_type',2)->get();
        return response()->json([
            'instock' => $instock,
            'preorder' => $preorder,
            ]);
   }

   //Store
   public function store(Request $request){
        // dd($request->all());
        $items = $request->products;
        // dd($items[0]['unitid']);

       $date = new DateTime('Asia/Yangon');


        $order_date = $date->format('Y-m-d');

        $last_order = EcommerceOrder::count();
        if($last_order != null){
            $order_code =  "ECVOU-" .date('y') . sprintf("%02s", (intval(date('m')))) . sprintf("%02s", ($last_order +1));

        }else{
            $order_code =  "ECVOU-" .date('y') . sprintf("%02s", (intval(date('m')))) .sprintf("%02s", 1);
        }

    $ecommerce_order = EcommerceOrder::create([
            "order_code" => $order_code,
            "order_date" => $order_date,
            "customer_id" => $request->id,
            "customer_name" => $request->name,
            "customer_phone" => $request->phone,
            "order_type" => 1,
            "order_status" => "received",
            "total_quantity" => $request->quantity,
            "total_amount" => $request->amount,
            "delivery_fee" => $request->charges,
            "discount_type" => "",
            "discount_amount" => 0,
            "payment_type" => "cod",
            "payment_channel" => "cash",
            "advance" => 0,
            "collect_amount" => 0,
            "deliver_address" => $request->address,
            "billing_address" => "",
            "remark" => $request->remark,
        ]);

        foreach ($items as $item) {

            DB::table('counting_unit_ecommerce_order')->insert([
                 'order_id' => $ecommerce_order->id,
                 'counting_unit_id' => $item['unitid'],
                 'quantity' => $item['quantity'] ,
                 'price' => $item['price'],
                ]);

            // $ecommerce_order->counting_unit()->attach($item->id, ['quantity' => $item->quantity,'price' => $item->price,'discount_type' => "",'discount_value' => 0]);

            // $counting_unit = CountingUnit::find($item->id);
            // $stock=$counting_unit->current_quantity;
            // $balance_qty = ($stock - $item->order_qty);

            // $counting_unit->current_quantity = $balance_qty;

            // $counting_unit->save();

        }

        return response()->json([
            'data'=>$ecommerce_order,
            ],200);
   }

   //show price
   public function showprice(Request $request){
    // dd($request->all());
    $search = explode(' ', $request->unit);
    $design = Design::where('design_name',$search[0])->first();
    $fabric = Fabric::where('fabric_name',$search[1])->first();
    $colour = Colour::where('colour_name',$search[2])->first();
    $size = Size::where('size_name',$search[3])->first();
    $gender = Gender::where('gender_name',$search[4])->first();
    $unit = CountingUnit::where('design_id',$design->id)
    ->where('fabric_id',$fabric->id)
    ->where('colour_id',$colour->id)
    ->where('size_id',$size->id)
    ->where('gender_id',$gender->id)
    ->first();

    return response()->json([
        'data'=>$unit->order_price,
        ],200);
}

   public function detail($id){

        try {

            $orders = EcommerceOrder::findOrFail($id);
            $customUnitOrders = DB::table('counting_unit_ecommerce_order')->where('order_id',$id)->get();

            $counting = [];
             foreach($customUnitOrders as $count){
                 $unit = CountingUnit::where('id',$count->counting_unit_id)->first();
                 array_push($counting,$unit);
             }
                // $counting =  CountingUnit::all();

            // dd($counting_units);

        } catch (\Exception $e) {

            alert()->error("Order Not Found!")->persistent("Close!");

            return response()->json($e);
        }

        return response()->json([
            "orders" => $orders,
            // "units"  => $customUnitOrders,
            "counting_units" => $counting
             ]);
   }

   public function township(){
       $township = Township::all();
       return response()->json($township);
   }

   public function township_charges($id){
       $township_charges = Township::find($id);
       return response()->json($township_charges);
   }

   public function type(){
       $fabric = Fabric::all();
       $color = Colour::all();
       $size = Size::all();
       $gender = Gender::all();
       return response()->json([
         'fabric' => $fabric,
         'color' => $color,
         'size' => $size,
         'gender' => $gender,
        ]);
   }

   //Preorder Store
   public function preorderstore(Request $request){
        // dd($request->all());
        $items = $request->orders;


       $date = new DateTime('Asia/Yangon');


        $order_date = $date->format('Y-m-d');

        $last_order = EcommerceOrder::count();
        if($last_order != null){
            $order_code =  "ECVOU-" .date('y') . sprintf("%02s", (intval(date('m')))) . sprintf("%02s", ($last_order +1));

        }else{
            $order_code =  "ECVOU-" .date('y') . sprintf("%02s", (intval(date('m')))) .sprintf("%02s", 1);
        }

        $ecommerce_order = EcommerceOrder::create([
            "order_code" => $order_code,
            "order_date" => $order_date,
            "customer_id" => $request->id,
            "customer_name" => $request->name,
            "customer_phone" => $request->phone,
            "order_type" => 2,
            "order_status" => "received",
            "total_quantity" => 3,
            "deliver_address" => $request->address,
        ]);

        foreach ($items as $item) {
            $search = explode(' ', $item['testname']);
            $design = Design::where('design_name',$search[0])->first();
            $fabric = Fabric::where('fabric_name',$search[1])->first();
            $colour = Colour::where('colour_name',$search[2])->first();
            $size = Size::where('size_name',$search[3])->first();
            $gender = Gender::where('gender_name',$search[4])->first();
            $unit = CountingUnit::where('design_id',$design->id)
            ->where('fabric_id',$fabric->id)
            ->where('colour_id',$colour->id)
            ->where('size_id',$size->id)
            ->where('gender_id',$gender->id)
            ->first();
            // dd($unit->id);
            DB::table('counting_unit_ecommerce_order')->insert([
                 'order_id' => $ecommerce_order->id,
                 'counting_unit_id' =>$unit->id,
                 'quantity' => $item['testqty'],
                ]);

            // $ecommerce_order->counting_unit()->attach($item->id, ['quantity' => $item->quantity,'price' => $item->price,'discount_type' => "",'discount_value' => 0]);

            // $counting_unit = CountingUnit::find($item->id);
            // $stock=$counting_unit->current_quantity;
            // $balance_qty = ($stock - $item->order_qty);

            // $counting_unit->current_quantity = $balance_qty;

            // $counting_unit->save();

        }

        return response()->json([
            'data'=>$ecommerce_order,
            ],200);
   }

   public function invoice_mail(Request $request)
    {
        Mail::to('maymyatmoe211099@gmail.com')->send(new Invoice($request->id,$request->name,$request->phone,$request->address,$request->preorders));
        return response()->json(["message" => "Email sent successfully."]);
    }

}
