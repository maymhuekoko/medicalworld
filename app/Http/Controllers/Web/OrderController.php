<?php

namespace App\Http\Controllers\Web;

use App\Colour;
use App\CustomUnitFactoryOrder;
use App\CustomUnitOrder;
use App\Design;
use App\Fabric;
use App\FactoryOrder;
use App\Http\Controllers\Controller;
use App\OrderVoucher;
use App\Size;
use App\Transaction;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use App\Customer;
use App\Order;
use App\Employee;
use App\Voucher;
use App\CountingUnit;
use App\From;
use App\FactoryPo;
use App\FactoryItem;
use Datetime;
use App\Category;
use App\EcommerceOrder;
use App\EcommerceOrderScreenshot;
use App\SubCategory;
use App\OrderCustomer;
use Maatwebsite\Excel\Excel;
use App\Exports\OrderHistoryExport;
use App\Exports\TotalOrderHistoryExport;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private $excel;


    public function __construct(Excel $excel){
        $this->excel = $excel;
    }

    protected function getOrderPanel(){

    	return view('Order.order_panel');
    }

    protected function getOrderPage($type){

    	$order_lists = Order::where('status',$type)->orderBy('id','desc')->get();
        $vouchers = Voucher::find($type);

        $employee_lists = Employee::all();

    	return view('Order.order_page', compact('order_lists','type','employee_lists','vouchers'));
    }

    protected function getWebsiteOrder(){

    	$order_lists = EcommerceOrder::where('order_type',1)->get();
        $counting = CountingUnit::all();


    	return view('Order.website_order', compact('order_lists','counting'));
    }

    public function showscreenshot(Request $request){
        $screenshot = EcommerceOrderScreenshot::where('id',$request->order_id)->first();
        // dd($screenshot);
        return response()->json([
            'screenshot' => $screenshot->screenshot,
        ]);
    }

    protected function getWebsitePreOrder(){

    	$order_lists = EcommerceOrder::where('order_type',2)->get();
        $counting = CountingUnit::all();

    	return view('Order.website_preorder', compact('order_lists','counting'));
    }



    protected function getFactoryPOPage(){

    	$po_lists = FactoryPO::all();

        $employee_lists = Employee::all();

    	return view('Itemrequest.porequest_page', compact('po_lists'));
    }

    protected function newOrderPage(Request $request){
        $role= $request->session()->get('user')->role;
        if($role=='Sale_Person'){
            $item_from= $request->session()->get('user')->from_id;
        }
        else {
            $item_from = 1;
        }
        $froms = From::find($item_from);
        $items = $froms->items()->get();
        $designs = Design::all();
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $customers = Customer::all();

        $employees = Employee::all();

        $date = new DateTime('Asia/Yangon');
        $vou_date = $date->format('d m y');

        $today_date = strtotime($date->format('d-m-Y H:i'));
        $last_voucher = Order::count();

        if($last_voucher != null){
            $voucher_code =  "OVOU-" .date('y') . sprintf("%02s", (intval(date('m')))) .sprintf("%02s", ($last_voucher - 477));
        }else{
            $voucher_code =  "OVOU-" .date('y') . sprintf("%02s", (intval(date('m')))) .sprintf("%02s", 1);
        }
        $ordercustomers = OrderCustomer::all();

    	return view('Order.neworder_page',compact('voucher_code','items','categories','customers','employees','today_date','sub_categories','ordercustomers','designs','vou_date'));
    }

    protected function storeCustomerOrderv2(Request $request){
         $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'customer_address' => 'required',
            'customer_phone' => 'required',
            'item' => 'required',
            'grand_total' => 'required',
            'order_date' => 'required',
            'payment_type' => 'required',
            'advance_pay' => 'required',
            'delivery_fee' => 'required',
            'showroom' => 'required',
            'voucher_code' => 'required',
            'customer_id' => 'required'
        ]);
        if ($validator->fails()) {

            return response()->json(['error' => 'Something Wrong! Validation Error'], 404);
        }
         $user = session()->get('user');
        $payment_clear_flag = 0;
        $items = json_decode($request->item);

        $grand = json_decode($request->grand_total);
        $total_quantity = $grand->total_qty;
        $total_amount = $grand->sub_total;
        $total_discount_type = $grand->total_discount_type;
        $total_discount_value = $grand->total_discount_value;
        $collect_amount = ($total_amount+$request->delivery_fee+$request->logo_fee) - $request->advance_pay - $total_discount_value;
        if($request->payment_type == 1){
            $payment_clear_flag = 1;
        }
      // $customer = Customer::find($request->customer_id);
        $order_format_date = date('Y-m-d', strtotime($request->order_date));
        try{

               if ($request->edit_voucher != 0){
                $order = Order::find($request->edit_voucher);
                $order->address = $request->customer_address;
                $order->name = $request->customer_name;
                $order->phone = $request->customer_phone;
                $order->showroom = $request->showroom;
                if($order->status != 3){
                    $order->previous_status = $order->status;
                    $order->status = 3;
                }
                $order->total_quantity = $total_quantity;
                $order->total_discount_type = $total_discount_type;
                $order->total_discount_value = $total_discount_value;
                $order->est_price = $total_amount;
                $order->order_date = $order_format_date;
                $order->payment_type = $request->payment_type;
                $order->advance_pay = $request->advance_pay;
                $order->delivery_fee = $request->delivery_fee;
                $order->logo_fee = $request->logo_fee;
                $order->collect_amount = $collect_amount;
                $order->customer_id = $request->customer_id;
                $order->order_by = $request->user_name;
                $order->update_times += 1;
                $order->save();

            }else{
             $order = Order::create([
                    'order_number'=> $request->voucher_code,
                    'address' => $request->customer_address,
                    'name' => $request->customer_name,
                    'phone' => $request->customer_phone,
                    'showroom'=>$request->showroom,
                    'customer_id'=>$request->customer_id,
                    'order_by' =>$request->user_name,
                    'total_quantity' => $total_quantity,
                    'total_discount_type' => $total_discount_type,
                    'total_discount_value' => $total_discount_value,
                    'est_price' => $total_amount,
                    'order_date' => $order_format_date,
                    'status' => 1,
                    'payment_type' => $request->payment_type,
                    'advance_pay' => $request->advance_pay,
                    'delivery_fee' => $request->delivery_fee,
                    'logo_fee' => $request->logo_fee,
                    'collect_amount' => $collect_amount,
                    'payment_clear_flag' => $payment_clear_flag,
                ]);

                if($request->customer_id != null && $request->customer_id != 0){
            $order_customer = OrderCustomer::find($request->customer_id);
            $order_customer->total_purchase_amount += $total_amount;
            $order_customer->total_purchase_quantity += $total_quantity;
            $order_customer->total_purchase_times += 1;
            $order_customer->last_purchase_date = $order_format_date;
            $order_customer->save();
        }

            if($request->advance_pay != null && $request->advance_pay != 0){
            $transaction = Transaction::create([
            'bank_acc_id' => 1,
            'tran_date' => $order_format_date,
            //'tran_time' => $time,
            'remark' => "Advance Payment",
            'pay_amount' => $request->advance_pay,
            'order_id' => $order->id,
        ]);
            }

            }


            $old_items_id = [];
            if($request->edit_voucher != 0){
                foreach($items as $item){
                    if($item->oldunit_flag){
                        array_push($old_items_id,$item->oldunit_id);
                    }
                }
                $customUnits =  CustomUnitOrder::where('order_id',$request->edit_voucher)->get();
                foreach($customUnits as $unit){
                    if(!in_array($unit->id,$old_items_id)){
                        $unit->delete();
                        // $total_amount = $unit->selling_price * $unit->order_qty;
                        // $order = Order::find($request->edit_voucher);
                        // $order->est_price -= $total_amount;
                        // $order->total_quantity -= $unit->order_qty;
                        // $order->collect_amount -= $total_amount;
                        // $order->save();
                    }
                }

            }


            foreach ($items as $item) {

                if($item->oldunit_flag){
                    $customUnitOrder= CustomUnitOrder::find($item->oldunit_id);
                $customUnitOrder->order_id = $order->id;
                $customUnitOrder->item_name = $item->item_name;
                $customUnitOrder->design_id = $item->design_id;
                $customUnitOrder->design_name = $item->design_name;
                $customUnitOrder->fabric_id = $item->fabric_id;
                $customUnitOrder->fabric_name = $item->fabric_name;
                $customUnitOrder->colour_id = $item->color_id;
                $customUnitOrder->colour_name = $item->color_name;
                $customUnitOrder->size_id = $item->size_id;
                $customUnitOrder->size_name = $item->size_name;
                $customUnitOrder->gender_id = $item->gender_id;
                $customUnitOrder->gender_name = $item->gender_name;
                $customUnitOrder->selling_price = $item->selling_price;
                $customUnitOrder->discount_type = $item->discount_type;
                $customUnitOrder->discount_value = $item->discount_value;
                $customUnitOrder->order_qty = $item->order_qty;
                $customUnitOrder->save();

                }else{
                $customUnitOrder= new CustomUnitOrder();
                $customUnitOrder->order_id = $order->id;
                $customUnitOrder->item_name = $item->item_name;
                $customUnitOrder->design_id = $item->design_id;
                $customUnitOrder->design_name = $item->design_name;
                $customUnitOrder->fabric_id = $item->fabric_id;
                $customUnitOrder->fabric_name = $item->fabric_name;
                $customUnitOrder->colour_id = $item->color_id;
                $customUnitOrder->colour_name = $item->color_name;
                $customUnitOrder->size_id = $item->size_id;
                $customUnitOrder->size_name = $item->size_name;
                $customUnitOrder->gender_id = $item->gender_id;
                $customUnitOrder->gender_name = $item->gender_name;
                $customUnitOrder->selling_price = $item->selling_price;
                $customUnitOrder->discount_type = $item->discount_type;
                $customUnitOrder->discount_value = $item->discount_value;
                $customUnitOrder->order_qty = $item->order_qty;
                $customUnitOrder->save();
                }
            }

        }catch (\Exception $e) {

            return response()->json([$e], 404);
//            return response()->json(['error' => 'Something Wrong! When Store Customer Order'], 404);

        }

         return response()->json([
                "items"=>$items,
                "grand" => $grand,
            ]);
    }

    protected function storeCustomerOrder(Request $request){

        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'customer_address' => 'required',
            'customer_phone' => 'required',
            'item' => 'required',
            'grand_total' => 'required',
            'order_date' => 'required|after_or_equal:today',
            'payment_type' => 'required',
            'advance_pay' => 'required',
            'delivery_fee' => 'required',
            'showroom' => 'required',
            'voucher_code' => 'required',
            'customer_id' => 'required'
        ]);
        if ($validator->fails()) {

            return response()->json(['error' => 'Something Wrong! Validation Error'], 404);
        }
        $user = session()->get('user');
        $payment_clear_flag = 0;
        $items = json_decode($request->item);

        $grand = json_decode($request->grand_total);
        $total_quantity = $grand->total_qty;
        $total_amount = $grand->sub_total;
        $total_discount_type = $grand->total_discount_type;
        $total_discount_value = $grand->total_discount_value;
        $collect_amount = ($total_amount+$request->delivery_fee) - $request->advance_pay;
        if($request->payment_type == 1){
            $payment_clear_flag = 1;
        }
      // $customer = Customer::find($request->customer_id);
        $order_format_date = date('Y-m-d', strtotime($request->order_date));

        try {
            // if ($request->edit_voucher != 0){
            //     $order = Order::where('id',$request->edit_voucher)->get();
            //     $order->address = $request->customer_address;
            //     $order->name = $request->customer_name;
            //     $order->phone = $request->customer_phone;
            //     $order->showroom = $request->showroom;
            //     $order->total_quantity = $total_quantity;
            //     $order->total_discount_type = $total_discount_type;
            //     $order->total_discount_value = $total_discount_value;
            //     $order->est_price = $total_amount;
            //     $order->order_date = $order_format_date;
            //     $order->payment_type = $request->payment_type;
            //     $order->advance_pay = $request->advance_pay;
            //     $order->delivery_fee = $request->delivery_fee;
            //     $order->collect_amount = $collect_amount;
            //     $order->customer_id = $request->customer_id;
            //     $order->save();

            // }else{
                $order = Order::create([
                    'order_number'=> $request->voucher_code,
                    'address' => $request->customer_address,
                    'name' => $request->customer_name,
                    'phone' => $request->customer_phone,
                    'showroom'=>$request->showroom,
                    'customer_id'=>$request->customer_id,
                    'total_quantity' => $total_quantity,
                    'total_discount_type' => $total_discount_type,
                    'total_discount_value' => $total_discount_value,
                    'est_price' => $total_amount,
                    'order_date' => $order_format_date,
                    'status' => 1,
                    'payment_type' => $request->payment_type,
                    'advance_pay' => $request->advance_pay,
                    'delivery_fee' => $request->delivery_fee,
                    'collect_amount' => $collect_amount,
                    'payment_clear_flag' => $payment_clear_flag,
                ]);
            //}



            if($request->advance_pay != null && $request->advance_pay != 0){
            $transaction = Transaction::create([
            'bank_acc_id' => 1,
            'tran_date' => $order_format_date,
            //'tran_time' => $time,
            'remark' => "Advance Payment",
            'pay_amount' => $request->advance_pay,
            'order_id' => $order->id,
        ]);
            }

            foreach ($items as $item) {

                // if($item->oldunit_flag){
                //     $customUnitOrder= CustomUnitOrder::find($item->oldunit_id);
                // $customUnitOrder->order_id = $order->id;
                // $customUnitOrder->item_name = $item->item_name;
                // $customUnitOrder->design_id = $item->design_id;
                // $customUnitOrder->design_name = $item->design_name;
                // $customUnitOrder->fabric_id = $item->fabric_id;
                // $customUnitOrder->fabric_name = $item->fabric_name;
                // $customUnitOrder->colour_id = $item->color_id;
                // $customUnitOrder->colour_name = $item->color_name;
                // $customUnitOrder->size_id = $item->size_id;
                // $customUnitOrder->size_name = $item->size_name;
                // $customUnitOrder->gender_id = $item->gender_id;
                // $customUnitOrder->gender_name = $item->gender_name;
                // $customUnitOrder->selling_price = $item->selling_price;
                // $customUnitOrder->discount_type = $item->discount_type;
                // $customUnitOrder->discount_value = $item->discount_value;
                // $customUnitOrder->order_qty = $item->order_qty;
                // $customUnitOrder->save();
                // }else{
                $customUnitOrder= new CustomUnitOrder();
                $customUnitOrder->order_id = $order->id;
                $customUnitOrder->item_name = $item->item_name;
                $customUnitOrder->design_id = $item->design_id;
                $customUnitOrder->design_name = $item->design_name;
                $customUnitOrder->fabric_id = $item->fabric_id;
                $customUnitOrder->fabric_name = $item->fabric_name;
                $customUnitOrder->colour_id = $item->color_id;
                $customUnitOrder->colour_name = $item->color_name;
                $customUnitOrder->size_id = $item->size_id;
                $customUnitOrder->size_name = $item->size_name;
                $customUnitOrder->gender_id = $item->gender_id;
                $customUnitOrder->gender_name = $item->gender_name;
                $customUnitOrder->selling_price = $item->selling_price;
                $customUnitOrder->discount_type = $item->discount_type;
                $customUnitOrder->discount_value = $item->discount_value;
                $customUnitOrder->order_qty = $item->order_qty;
                $customUnitOrder->save();
                //}
            }
            $last_voucher = Order::get()->last();
            if($last_voucher != null){
                $voucher_code = "OVOU-" .date('y') . sprintf("%02s", (intval(date('m')) + 1)) .sprintf("%02s", ($last_voucher->id+1));
            }else{
                $voucher_code = "OVOU-" .date('y') . sprintf("%02s", (intval(date('m')) + 1)) .sprintf("%02s", 1);
            }

            return response()->json([
                "order"=>$order,
                "voucher_code" => $voucher_code,
            ]);

        } catch (\Exception $e) {

            return response()->json([$e], 404);
//            return response()->json(['error' => 'Something Wrong! When Store Customer Order'], 404);

        }

    }

    public function orderDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'admin_code' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json(0);
        }

        if($request->admin_code != "ADMINMDW2022")
        {
            return response()->json(0);
        }


        try {
            $order = Order::findOrfail($request->order_id);
            $order->delete();
            $customUnitOrders = CustomUnitOrder::where('order_id', $request->order_id)->get();

            foreach($customUnitOrders as $unit){

                $unit->delete();

            }
            // $deleted = DB::table('orders')->where('id', $request->order_id)->delete();

        } catch (\Exception $e) {

            return response()->json(0);

        }

        return response()->json(1);

    }

    protected function storePurchaseOrder(Request $request){
        $now = new DateTime;
        $today = strtotime($now->format('d-m-Y'));


        $user = session()->get('user');

        $items = json_decode($_POST['item']);

        $grand = json_decode($_POST['grand_total']);

        $po_type = $_POST['po_type'];

        if($po_type == 9){


        $total_rolls = $grand->total_rolls;

        $total_yards = $grand->total_yards;

        $total_quantity = $grand->total_yards;

        }else if($po_type == 10){


            $total_rolls = 0;

        $total_yards = 0;

        $total_quantity = $grand->total_qty;
        }

        $total_amount = $grand->sub_total;

        $po_number = $_POST['po_number'];

        $po_format_date = date('Y-m-d', strtotime($_POST['po_date']));

        $receive_format_date = date('Y-m-d', strtotime($_POST['receive_date']));

        $requested_by = $_POST['requested_by'];
         $approved_by = $_POST['approved_by'];
         $file_path = '';

         if(isset($_FILES['file']['name'])){

              $filename = $_FILES['file']['name'];


              $location = public_path() . '/files/attachments/' . $filename;
              if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                  $file_path = '/files/attachments/' . $filename;
              }

         }else{
             $file_path = "defaultfile.pdf";
         }


      //return response()->json($items);

        try {

             $factoryPO = FactoryPo::create([
                'po_number' => $po_number,
                'po_date' => $po_format_date,
                'po_type' => $po_type,
                'receive_date' => $receive_format_date,
                'total_rolls'=> $total_rolls,
                'total_yards'=> $total_yards,
                'total_quantity' => $total_quantity,
                'total_price'=> $total_amount,
                'status' => 0,
                'requested_by' => $requested_by,
                'approved_by'=> $approved_by,
                'attach_file_path' => $file_path,
            ]);

            foreach ($items as $item) {
                if($po_type == 9){
                    $rolls = $item->rolls;

        $yards_per_roll = $item->yards_per_roll;

        $sub_yards = $item->sub_yards;

        $order_qty = $item->sub_yards;
                }else if($po_type == 10){
                    $rolls = 0;

        $yards_per_roll = 0;

        $sub_yards = 0;

        $order_qty = $item->order_qty;
                }
            $factoryPO->factory_items()->attach($item->id, ['purchase_price' => $item->purchase_price,'rolls' => $rolls,'yards_per_roll' => $yards_per_roll,'sub_yards' => $sub_yards,'order_qty' => $order_qty,'remark'=> $item->remark]);
                //$factory_item = FactoryItem::findOrFail($item->id);
                //$factory_item->reserved_qty += $item->order_qty;
                //$factory_item->save();
            }

            return response()->json($factoryPO);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Something Wrong! When Store Purchase Order'], 404);

        }

    }

    protected function getPoDetails($id){
        try{
            $PO = FactoryPo::findOrFail($id);
        }catch(\Exception $e){
            alert()->error("PO Not Found!")->persistent("Close!");
            return redirect()->back;
        }
        return view('Itemrequest.po_details',compact('PO'));
    }

    public function attachimg(Request $request)
	{
		if($request->file_path == "default.jpg"){
			alert()->error(' Not Attachment Images !');
			return redirect()->back();
		}else{
		    $attach_file_path = $request->file_path;
		    $po_id = $request->po_id;
		}

		return view(('Itemrequest.attachimg'),compact('attach_file_path','po_id'));
	}

    protected function getOrderDetailsPage($id){

        try {

            $orders = Order::findOrFail($id);
            $customUnitOrders = CustomUnitOrder::where('order_id',$id)->get();

            $customUnitOrder_ids=[];
            foreach ($customUnitOrders as $customUnitOrder){
                array_push($customUnitOrder_ids,$customUnitOrder->id);
            }
            $design = Design::whereIn('id',$customUnitOrder_ids)->get();
            $transaction = Transaction::where('order_id',$id)->get();

        } catch (\Exception $e) {

            alert()->error("Order Not Found!")->persistent("Close!");

            return redirect()->back();
        }
//        return redirect()->back();

        return view('Order.neworder_details', compact('orders','customUnitOrders','design','transaction'));
    }

    protected function getWebsiteOrderDetailsPage($id){

        try {

            $orders = EcommerceOrder::findOrFail($id);
            $customUnitOrders = DB::table('counting_unit_ecommerce_order')->where('order_id',$id)->get();

            $counting =  CountingUnit::all();

            // dd($counting_units);

        } catch (\Exception $e) {

            alert()->error("Order Not Found!")->persistent("Close!");

            return redirect()->back();
        }
//        return redirect()->back();

        return view('Order.website_order_details', compact('orders','customUnitOrders','counting'));
    }


    protected function changePOStatus(Request $request){
        $validator = Validator::make($request->all(), [
            'po_id' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error('Something Wrong! Validation Error!');

            return redirect()->back();
        }

        $user = session()->get('user');

    	try {

        	$factory_po = FactoryPo::findOrFail($request->po_id);

   		} catch (\Exception $e) {

        	alert()->error("PO Not Found!")->persistent("Close!");

            return redirect()->back();
    	}

        if ($factory_po->status == 0 ) {

                $factory_po->status = 1;

                $factory_po->save();


                foreach($factory_po->factory_items as $factory_item){
                    $factory_item->instock_qty -= $factory_item->pivot->quantity;
                    $factory_item->reserved_qty -= $factory_item->pivot->quantity;
                    $factory_item->save();
                }

                return response()->json(1);



        }
    }

     protected function changeWebsiteOrderStatus(Request $request){
        //   dd($request->all());
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'status'  => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error('Something Wrong! Validation Error!');

            return redirect()->back();
        }

    	try {
        	$order = EcommerceOrder::findOrFail($request->order_id);

            if($request->status == 'received'){
                $order->order_status = $request->status;
                $order->status = 1;
            }
            if($request->status == 'confirmed'){
                $order->order_status = $request->status;
                $order->status = 2;
            }
            if($request->status == 'delivered'){
                $order->order_status = $request->status;
                $order->status = 4;
            }
            if($request->status == 'canceled'){
                $order->order_status = $request->status;
                $order->status = 5;
            }

            $order->save();

        } catch (\Exception $e) {

        	alert()->error("Order Not Found!")->persistent("Close!");
            return redirect()->back();
    	}
    	return response()->json($order);
     }

     protected function changeOrderStatusWebsite(Request $request){

        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error('Something Wrong! Validation Error!');

            return redirect()->back();
        }

        $user = session()->get('user');

    	try {
        	$order = EcommerceOrder::findOrFail($request->order_id);
//            $customUnitOrders = CustomUnitOrder::where('id',$request->order_id)->get();


        } catch (\Exception $e) {

        	alert()->error("Order Not Found!")->persistent("Close!");
            return redirect()->back();
    	}

        if ($order->status == 1 ) {
//            if (is_null($request->delivered_date)) {
//                alert()->error("Something Wrong! Delivered Date Can't be Empty!")->persistent("Close!");
//                return redirect()->back();
//            }
//            else{
                $order->status = 2;
                $order->order_status = 'confirmed';
                $order->delivered_date = $request->delivered_date;
                $order->save();
                alert()->success('Order Confirm Succeed!');
                return redirect()->back();
//            }
//        }elseif ($order->status == 2 || $order->status == 3) {
        }elseif ($order->status == 2) {

//            if (is_null($request->delivered_date) && is_null($request->employee)) {
            if (is_null($request->delivered_date) && is_null($request->delivered_by)) {
                alert()->error("Something Wrong! Delivered Date Can't be Empty!")->persistent("Close!");
                return redirect()->back();
            }
            else{
//                $total = $customUnitOrders->selling_price * $customUnitOrders->order_qty;

                $order->status = 4;
//                $order->employee_id = $request->employee;
                $order->order_status = 'delivered';
                $order->delivered_date = $request->delivered_date;
                $order->delivered_by = $request->delivered_by;
                $order->delivered_remark = $request->delivered_remark;
                $order->save();
               // $count = OrderVoucher::count();
                //$order_voucher_number = "OVOU-".sprintf("%04s",($count+1));
                $order_voucher_number = $order->order_code;
                $orderVoucher = new OrderVoucher();
                $orderVoucher->voucher_number = $order_voucher_number;
                $orderVoucher->total_price = $order->total_amount;
                $orderVoucher->discount = $order->discount_amount;
                $orderVoucher->discount_value = $order->discount_amount;
                $orderVoucher->discount_type = $order->discount_type;
                $orderVoucher->total_quantity = $order->total_quantity;
                $orderVoucher->advance = $order->advance;
                $orderVoucher->outstanding = $order->collect_amount;
                $orderVoucher->delivered_date = $request->delivered_date;
                $orderVoucher->sale_by = $user->id;
                $orderVoucher->sales_customer_id = $order->customer_id;
                $orderVoucher->sales_customer_name = $order->customer_name;
                $orderVoucher->voucher_date = $request->delivered_date;
                $orderVoucher->order_date = $order->order_date;
                $orderVoucher->order_id = $request->order_id;
                $orderVoucher->from_id = 1;
                $orderVoucher->save();
                alert()->success('Successfully Changed');
                //$orderVoucher = OrderVoucher::where('order_id',$order->id)->get();
                return view('Order.order_deliver_voucher_website', compact("order","orderVoucher"));
            }

        }
        else{

            alert()->error('Something Wrong! Order is Delivered!');

            return redirect()->back();
        }
    }


    protected function changeOrderStatus(Request $request){

        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error('Something Wrong! Validation Error!');

            return redirect()->back();
        }

        $user = session()->get('user');

    	try {
        	$order = Order::findOrFail($request->order_id);
//            $customUnitOrders = CustomUnitOrder::where('id',$request->order_id)->get();


        } catch (\Exception $e) {

        	alert()->error("Order Not Found!")->persistent("Close!");
            return redirect()->back();
    	}

        if ($order->status == 1 ) {
//            if (is_null($request->delivered_date)) {
//                alert()->error("Something Wrong! Delivered Date Can't be Empty!")->persistent("Close!");
//                return redirect()->back();
//            }
//            else{
                $order->status = 2;
                $order->delivered_date = $request->delivered_date;
                $order->save();
                alert()->success('Order Confirm Succeed!');
                return redirect()->back();
//            }
//        }elseif ($order->status == 2 || $order->status == 3) {
        }elseif ($order->status == 2) {

//            if (is_null($request->delivered_date) && is_null($request->employee)) {
            if (is_null($request->delivered_date) && is_null($request->delivered_by)) {
                alert()->error("Something Wrong! Delivered Date Can't be Empty!")->persistent("Close!");
                return redirect()->back();
            }
            else{
//                $total = $customUnitOrders->selling_price * $customUnitOrders->order_qty;
                $order->status = 4;
//                $order->employee_id = $request->employee;
                $order->delivered_date = $request->delivered_date;
                $order->delivered_by = $request->delivered_by;
                $order->delivered_remark = $request->delivered_remark;
                $order->save();
               // $count = OrderVoucher::count();
                //$order_voucher_number = "OVOU-".sprintf("%04s",($count+1));
                $order_voucher_number = $order->order_number;
                $orderVoucher = new OrderVoucher();
                $orderVoucher->voucher_number = $order_voucher_number;
                $orderVoucher->total_price = $order->est_price;
                $orderVoucher->discount = $order->total_discount_value;
                $orderVoucher->discount_value = $order->total_discount_value;
                $orderVoucher->discount_type = $order->total_discount_type;
                $orderVoucher->total_quantity = $order->total_quantity;
                $orderVoucher->advance = $order->advance_pay;
                $orderVoucher->outstanding = $order->collect_amount;
                $orderVoucher->delivered_date = $request->delivered_date;
                $orderVoucher->sale_by = $user->id;
                $orderVoucher->sales_customer_id = $order->customer_id;
                $orderVoucher->sales_customer_name = $order->name;
                $orderVoucher->voucher_date = $request->delivered_date;
                $orderVoucher->order_date = $order->order_date;
                $orderVoucher->order_id = $request->order_id;
                $orderVoucher->from_id = 1;
                $orderVoucher->save();
                alert()->success('Successfully Changed');
                //$orderVoucher = OrderVoucher::where('order_id',$order->id)->get();
                return view('Order.order_deliver_voucher', compact("order","orderVoucher"));
            }

        }elseif($order->status == 3){
            $order->status = $order->previous_status;
            $order->previous_status = 0;
            $order->save();
            alert()->success('Change Order Approve Succeed!');
                return redirect()->back();
        }
        else{

            alert()->error('Something Wrong! Order is Delivered!');

            return redirect()->back();
        }
    }

    protected function getOrderVoucherPrint($id){
        $order = Order::findOrFail($id);

        if($order->status == 4){
        $orderVoucher = OrderVoucher::where('order_id',$id)->first();
        }else{
            $orderVoucher = null;
        }
        return view('Order.order_deliver_voucher', compact("order","orderVoucher"));
    }

    protected function getWebsiteOrderVoucherPrint($id){
        $order = EcommerceOrder::findOrFail($id);

        return view('Order.website_order_deliver_voucher', compact("order"));
    }

    protected function getOrderHistoryPage(){
         $from_date = date("Y-m-d");
        $to_date = date("Y-m-d");
        $orderVouchers = OrderVoucher::orderBy('id','desc')->get();
//        $voucher_lists = Voucher::where('type', 2)->whereBetween('voucher_date',[$from_date,$to_date])->get();
        $customer_lists = array();
        $total_sales  = 0;
        $customers = OrderCustomer::all();
        foreach ($orderVouchers as $orderVou){
            if($orderVou->discount_value > 1 && $orderVou->discount_type != 'foc'){
                $total_sales += $orderVou->total_price - $orderVou->discount_value;
            }
            else if ($orderVou->discount_value == 0 || $orderVou->discount_type == ''){
                $total_sales += $orderVou->total_price;
            }
            else{
                $total_sales += 0;
            }

        }

        $date = new DateTime('Asia/Yangon');

        $current_date = strtotime($date->format('Y-m-d'));
        $to = $date->format('Y-m-d');

        $weekly = date('Y-m-d', strtotime('-1week', $current_date));


        $weekly_data = OrderVoucher::whereBetween('voucher_date', [$weekly,$to])->get();

        $weekly_sales = 0;

        foreach($weekly_data as $weekly){
            if($weekly->discount_value > 1 && $weekly->discount_type != 'foc'){
                $weekly_sales += $weekly->total_price - $weekly->discount_value;
            }
            else if ($weekly->discount_value == 0 || $weekly->discount_type == ''){
                $weekly_sales += $weekly->total_price;
            }
            else{
                $weekly_sales += 0;
            }
        }

        $today_date = $date->format('Y-m-d');
        $daily = OrderVoucher::whereDate('created_at', $today_date)->get();


        $daily_sales = 0;
        foreach($daily as $day){
            if($day->discount_value > 1 && $day->discount_type != 'foc'){
                $daily_sales += $day->total_price - $day->discount_value;
            }
            elseif ($day->discount_value == 0 || $day->discount_type == '' ){
                $daily_sales += $day->total_price;
            }
            else {
                $daily_sales += 0;
            }
        }

        $current_month = $date->format('m');
        $current_month_year = $date->format('Y');
        $monthly = OrderVoucher::whereMonth('created_at',$current_month)->whereYear('created_at',$current_month_year)->get();


        $monthly_sales = 0;

        foreach ($monthly as $month){

            if($month->discount_value > 1 && $month->discount_type != 'foc'){
                $monthly_sales += $month->total_price - $month->discount_value;
            }
            else if ($month->discount_value == 0 && $month->discount_type == ''){
                $monthly_sales += $month->total_price;
            }
            else{
                $monthly_sales += 0;
            }
        }
//        foreach($voucher_lists as $voucher){
//            $customer_name = Order::find($voucher->order_id)->name;
//            $customer_lists[$voucher->id] = $customer_name;
//        }

        return view('Order.order_history_page', compact('orderVouchers','customers','customer_lists','total_sales','weekly_sales','daily_sales','monthly_sales'));

    }

    public function validateData($request)
    {
        return  Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required',
        ]);
    }

    protected function searchOrderHistory(Request $request){
        // $validator = $this->validateData($request);
        if ($this->validateData($request)->fails()) {
            alert()->error('Something Wrong!');
            return redirect()->back();
        }


        if($request->customer == 0 && $request->sales == 'All'){
            $orders = Order::whereBetween('order_date',[$request->from, $request->to])->where('status',$request->type)->with('order_voucher')->with('factory_orders')->get();
        }else if($request->customer == 0 && $request->sales != 'All'){
            $orders = Order::whereBetween('order_date',[$request->from, $request->to])->where('order_by',$request->sales)->where('status',$request->type)->with('order_voucher')->with('factory_orders')->get();
        }else if($request->customer != 0 && $request->sales == 'All'){
            $orders = Order::whereBetween('order_date',[$request->from, $request->to])->where('customer_id',$request->customer)->where('status',$request->type)->with('order_voucher')->with('factory_orders')->get();
        }else{
            $orders = Order::whereBetween('order_date',[$request->from, $request->to])->where('customer_id',$request->customer)->where('order_by',$request->sales)->where('status',$request->type)->with('order_voucher')->with('factory_orders')->get();
        }

        return response()->json($orders);
    }

    protected function searchFactoryOrderHistory(Request $request){
        // $validator = $this->validateData($request);
        if ($this->validateData($request)->fails()) {
            alert()->error('Something Wrong!');
            return redirect()->back();
        }

            $factoryorders = FactoryOrder::whereBetween('created_at',[$request->from, $request->to])->where('status',$request->type)->get();
             $final_orders = array();
             foreach($factoryorders as $factoryorder){
                 $order = Order::find($factoryorder->order_id);
                 $item_quantity = 0;
                $factoryCustomUnits = CustomUnitFactoryOrder::where("factory_order_id",$factoryorder->id)->get();
                 foreach($factoryCustomUnits as $customUnit){
                     $item_quantity += $customUnit->quantity;
                 }

                 if($request->sales == "All" || ($order != null && $order->order_by == $request->sales)){
                 $combined = array('id' => $factoryorder->id, 'factoryorder_number' => $factoryorder->factory_order_number, 'order_number' => $order ? $order->order_number : '-', 'order_by' => $order ? $order->order_by : '-', 'order_date' => $order ? $order->order_date : '-', 'department_name' => $factoryorder->department_name,'plan_date' => $factoryorder->plan_date, 'remark' => $factoryorder->remark,'showroom'=>$factoryorder->showroom,'total_quantity' => $factoryorder->total_quantity, 'item_quantity' => $item_quantity, 'print_status' => $factoryorder->print_status);
                array_push($final_orders,$combined);
                 }

             }

        return response()->json($final_orders);
    }

    protected function searchOrderVoucherHistory(Request $request){
        // $validator = $this->validateData($request);
        if ($this->validateData($request)->fails()) {
            alert()->error('Something Wrong!');
            return redirect()->back();
        }

        if($request->customer == 0){
            $orderVouchers = OrderVoucher::whereBetween('voucher_date',[$request->from, $request->to])->get();
        }else{
            $orderVouchers = OrderVoucher::whereBetween('voucher_date',[$request->from, $request->to])->where('sales_customer_id',$request->customer)->get();
        }

        return response()->json($orderVouchers);
    }

    protected function orderHistoryExport(Request $request,$from,$to,$id,$data_type,$type){
        return $this->excel->download(new OrderHistoryExport($from,$to,$id,$data_type),'order_voucher_history.xlsx');
    }

    protected function totalOrderHistoryExport(Request $request,$from,$to,$id,$order_by,$order_type,$data_type,$type){
        return $this->excel->download(new TotalOrderHistoryExport($from,$to,$id,$order_by,$order_type,$data_type),'total_order_history.xlsx');
    }

    protected function orderVoucherDetails(Request $request, $id){
        try {
            $orderVoucher = OrderVoucher::find($id);
            $order = Order::where('id',$orderVoucher->order_id)->first();
        } catch (\Exception $e) {
            alert()->error("Order Not Found!")->persistent("Close!");
            return redirect()->back();
        }
        return view('Order.order_voucher', compact('orderVoucher','order'));
    }

    public function getSpecId(Request $request){
        $fabric_id = $request->fabric_id;
        $fabrics = Fabric::where("id",$fabric_id)->get();
        return response()->json([
            "data"=>$fabrics
        ],200);
    }

    public function addFactoryOrder(Request $request,$id){
        $main_order = Order::find($id);
        $customUnitOrders = CustomUnitOrder::where('order_id',$request->id)->get();
        $factory_order_number = '';
        if ($main_order->showroom == "online"){
            $factory_order_number = "Os ".date("y m");
        }elseif ($main_order->showroom == "yangon"){
            $factory_order_number = "YFHU ".date("y m");
        }elseif ($main_order->showroom == "mandalay"){
            $factory_order_number = "MFHU ".date("y m");
        }elseif ($main_order->showroom == "office"){
            $factory_order_number = "OFHU ".date("y m");
        }elseif ($main_order->showroom == "agent"){
            $factory_order_number = "OSAG ".date("y m");
        }
        $count = FactoryOrder::count();
        $factoryOrder = new FactoryOrder();
        $factoryOrder->factory_order_number = $factory_order_number." ".sprintf("%02s",($count - 494));
        $factoryOrder->order_id = $request->id;
        $factoryOrder->showroom = $main_order->showroom;
        $factoryOrder->total_quantity = $main_order->total_quantity;
        $factoryOrder->save();
        return redirect()->route('showFactoryOrderItem',$factoryOrder->id);
    }

    public function addFactoryOrderWebsite(Request $request,$id){
        $main_order = EcommerceOrder::find($id);
        $customUnitOrders = CustomUnitOrder::where('order_id',$request->id)->get();
        $factory_order_number = '';
        // if ($main_order->showroom == "online"){
        //     $factory_order_number = "Os ".date("y m");
        // }elseif ($main_order->showroom == "yangon"){
        //     $factory_order_number = "YFHU ".date("y m");
        // }elseif ($main_order->showroom == "mandalay"){
        //     $factory_order_number = "MFHU ".date("y m");
        // }elseif ($main_order->showroom == "office"){
        //     $factory_order_number = "OFHU ".date("y m");
        // }elseif ($main_order->showroom == "agent"){
        //     $factory_order_number = "OSAG ".date("y m");
        // }
        $count = FactoryOrder::count();
        $factoryOrder = new FactoryOrder();
        $factoryOrder->factory_order_number = $factory_order_number." ".sprintf("%02s",($count - 494));
        $factoryOrder->order_id = $request->id;
        // $factoryOrder->showroom = $main_order->showroom;
        $factoryOrder->total_quantity = $main_order->total_quantity;
        $factoryOrder->save();
        return redirect()->route('showFactoryOrderItem',$factoryOrder->id);
    }

    public function showFactoryOrderItem($id){
        $factoryOrder = FactoryOrder::find($id);
        return view('Order.newFactoryOrder',compact("factoryOrder"));
    }

    public function updateFactoryOrderItem($id){
        $factoryOrder = FactoryOrder::find($id);
        //dd($factoryOrder);
        $factoryOrder->status = 3;
       $factoryOrder->print_status = 0;
       $factoryOrder->save();
        //set_time_limit(1000);
        return view('Order.newFactoryOrder',compact("factoryOrder"));
    }

    public function saveFactoryOrder(Request $request,$id){
        $factoryOrder = FactoryOrder::find($id);
        $factoryOrder->department_name = $request->department_name;
        $factoryOrder->plan_date = $request->delivery_date;
        $factoryOrder->remark = $request->remark;
        $factoryOrder->save();
        return redirect()->back();
    }
    public function saveFactoryItem(Request $request){
        $request->validate([
            "person_name"=>"required",
            "quantity"=>"required",
        ]);
        $size = Size::find($request->size_id);
        $design = Design::find($request->pp_design_id);
        $colour = Colour::find($request->pp_colour_id);
        $customUnitOrderId = $request->custom_unit_order_id;
        $customUnitFactoryOrder = new CustomUnitFactoryOrder();
        $customUnitFactoryOrder->factory_order_id = $request->factory_order_id;
        $customUnitFactoryOrder->custom_unit_order_id = $request->custom_unit_order_id;
        $customUnitFactoryOrder->person_name = $request->person_name;
        $customUnitFactoryOrder->person_id = $request->person_id;
        $customUnitFactoryOrder->design_id = $request->design_id;
        $customUnitFactoryOrder->design_name = $request->design_name;
        $customUnitFactoryOrder->fabric_id = $request->fabric_id;
        $customUnitFactoryOrder->fabric_name = $request->fabric_name;
        $customUnitFactoryOrder->colour_id = $request->colour_id;
        $customUnitFactoryOrder->colour_name = $request->colour_name;
        $customUnitFactoryOrder->pp_design_id = $request->pp_design_id;
        $customUnitFactoryOrder->pp_design_name = $design->design_name ?? "NA";
        $customUnitFactoryOrder->pp_colour_id = $request->pp_colour_id;
        $customUnitFactoryOrder->pp_colour_name = $colour->colour_name ?? "NA";
        $customUnitFactoryOrder->quantity = $request->quantity;
        $customUnitFactoryOrder->remark = $request->remark;

        if ($request->gender == "male"){
            $customUnitFactoryOrder->male_size_id = $request->size_id;
            $customUnitFactoryOrder->male_size_name = $size->size_name;
        }elseif ($request->gender == "female"){
            $customUnitFactoryOrder->female_size_id = $request->size_id;
            $customUnitFactoryOrder->female_size_name = $size->size_name;
        }
        $customUnitFactoryOrder->save();
        return redirect()->back()->with('status','Successfully Added!');
    }

    public function factoryOrderDetail($id){
        $factoryOrder = FactoryOrder::find($id);
        $factoryItems = CustomUnitFactoryOrder::where('factory_order_id',$id)->get();
        $order = Order::find($factoryOrder->order_id);
        $order_quantity = $order->total_quantity;
        $factory_item_quantity = 0;
        foreach($factoryItems as $item){
            $factory_item_quantity += $item->quantity;
        }
        return view('Order.factory_order_details',compact("factoryItems","factoryOrder",'order_quantity','factory_item_quantity'));
    }

    public function getIncomingFactoryOrder(Request $request){
        $factoryOrders = FactoryOrder::where('order_id',$request->order_id)->whereIn('status',[1,3])->get();
        return response()->json($factoryOrders);
    }

    public function getDeliveredFactoryOrder(Request $request){
        $factoryOrders = FactoryOrder::where('order_id',$request->order_id)->where('status',2)->get();
        return response()->json($factoryOrders);
    }

    public function newOrderItemPrice(Request $request){
//        return $request;
        $design_id = $request->design_id;
        $fabric_id = $request->fabric_id;
        $colour_id = $request->colour_id;
        $countingUnit = CountingUnit::where('design_id',$design_id)->where('colour_id',$colour_id)->where('fabric_id',$fabric_id)->get();
        $price = 0;
        foreach ($countingUnit as $cu){
            $price = $cu->order_price;
        }
        return response()->json([$price]);
    }

    public function destroyFactoryItem($id){
        $factoryItem = CustomUnitFactoryOrder::find($id);
        $factoryItem->delete();
        return redirect()->back()->with('status','Successfully Deleted!');
    }

    public function editFactoryItem(Request $request,$id){
        $size = Size::find($request->size_id);
        $design = Design::find($request->pp_design_id);
        $colour = Colour::find($request->pp_colour_id);
        $customUnitOrderId = $request->custom_unit_order_id;
        $customUnitFactoryOrder = CustomUnitFactoryOrder::find($id);
        $customUnitFactoryOrder->person_name = $request->person_name;
        $customUnitFactoryOrder->person_id = $request->person_id;
        $customUnitFactoryOrder->pp_design_id = $request->pp_design_id;
        $customUnitFactoryOrder->pp_design_name = $design->design_name;
        $customUnitFactoryOrder->pp_colour_id = $request->pp_colour_id;
        $customUnitFactoryOrder->pp_colour_name = $colour->colour_name;
        $customUnitFactoryOrder->pp_colour_name = $colour->colour_name;
        $customUnitFactoryOrder->quantity = $request->quantity;
        $customUnitFactoryOrder->remark = $request->remark;
        if ($request->gender == "male"){
            $customUnitFactoryOrder->male_size_id = $request->size_id;
            $customUnitFactoryOrder->male_size_name = $size->size_name;
            $customUnitFactoryOrder->female_size_id = null;
            $customUnitFactoryOrder->female_size_name = null;
        }elseif ($request->gender == "female"){
            $customUnitFactoryOrder->female_size_id = $request->size_id;
            $customUnitFactoryOrder->female_size_name = $size->size_name;
            $customUnitFactoryOrder->male_size_id = null;
            $customUnitFactoryOrder->male_size_name = null;
        }
        $customUnitFactoryOrder->save();
        return redirect()->back()->with('status','Successfully Updated!');
    }

    public function changePrintStatus(Request $request){
        $factoryOrder = FactoryOrder::find($request->order_id);
        $factoryOrder->print_status = 1;
        $factoryOrder->save();
        return response()->json(1);
    }

    public function deliverFactoryOrder(Request $request,$id){
        $factoryOrder = FactoryOrder::find($id);
        $factoryOrder->status = 2;
        $factoryOrder->delivery_date = $request->delivery_date;
        $factoryOrder->delivery_remark = $request->delivery_remark;
        $factoryOrder->save();
        return redirect()->back();
    }

    public function incomingFactoryOrder(){

        return view('factoryOrder.incomingFactoryOrder');
    }

    public function changeFactoryOrder(){
        return view('factoryOrder.changeFactoryOrder');
    }

    public function deliveredFactoryOrder(){
        return view('factoryOrder.deliverFactoryOrder');
    }


}
