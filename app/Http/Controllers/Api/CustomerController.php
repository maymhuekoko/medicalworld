<?php

namespace App\Http\Controllers\Api;

use App\CountingUnit;
use App\Customer;
use App\Item;
use App\Order;
use App\User;
use App\Http\Resources\CountingUnitResource;
use App\Http\Resources\ItemResource;
use App\Http\Resources\OrderResource;
use App\Http\Controllers\ApiBaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Datetime;

class CustomerController extends ApiBaseController
{
	protected function today()
	{
		$now = new DateTime;

		$today = strtotime($now->format('d-m-Y H:i'));

		return $today;
	}

	protected function editProfile(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'email' => 'required',
			'phone' => 'required',
			'address' => 'required',
		]);

		if ($validator->fails()) {			

			return $this->sendFailResponse("Something Wrong! Validation Error.", "400");
		}

		if ($request->hasfile('photo')) {

			$image = $request->file('photo');

			$name = $image->getClientOriginalName();

			$photo_path =  time()."-".$name;

			$image->move(public_path() . '/photo/Customer', $photo_path);
		}
		else{

			$photo_path = "default.jpg";

		}

		$customer = Customer::where('user_id', $request->user()->id)->first();

		$user = User::find($request->user()->id);

		$user->name = $request->name;

		$user->email = $request->email;

		$user->photo_path = $photo_path;

		$user->save();

		$customer->phone = $request->phone;

		$customer->address = $request->address;

		$customer->save();

		$photo = url("/") . '/photo/Customer/' . $user->photo_path;

		$collection = collect(['id ','user_code', 'name','email','photo_path','phone','address']);

		$combined = $collection->combine([$user->id,$user->user_code,$user->name,$user->email,$photo,$customer->phone,$customer->address]);
		
		return $this->sendSuccessResponse("user", $combined);
	}

    protected function getItemListbyCategory(Request $request)
    {	
   		$validator = Validator::make($request->all(), [
			'category_id' => 'required',
		]);

		if ($validator->fails()) {			

			return $this->sendFailResponse("Something Wrong! Validation Error.", "400");
		}

		$item_lists = Item::where('category_id', $request->category_id)->whereNull("deleted_at")->get();

		$final_item_lists = ItemResource::collection($item_lists);

		return $this->sendSuccessResponse("item_lists", $final_item_lists);
    }

    protected function getCountingUnit(Request $request)
    {

    	$validator = Validator::make($request->all(), [
			'item_id' => 'required',
		]);

		if ($validator->fails()) {			

			return $this->sendFailResponse("Something Wrong! Validation Error.", "400");
		}

		$count_unit = CountingUnit::where('item_id', $request->item_id)->whereColumn('current_quantity', ">" ,'reorder_quantity')->whereNull("deleted_at")->get();

		$fianl_count_units = CountingUnitResource::collection($count_unit);

		return $this->sendSuccessResponse("count_unit_lists", $fianl_count_units);
    }

    protected function storeOrder(Request $request)
    {

    	$today = $this->today();

    	$validator = Validator::make($request->all(), [
			'address' => 'required',
			'phone' => 'required',
			'name' => 'required',
			'total_qty' => 'required',
			'order_date' => 'required|after:today',
			'counting_unit' => 'required',
			'customer_id' => 'required',
		]);

		if ($validator->fails()) {			

			return $this->sendFailResponse("Something Wrong! Validation Error.", "400");
		}

		$order_format_date = date('Y-m-d', strtotime($request->order_date));

		$count_unit_lists = json_decode(json_encode($request->counting_unit));

		$unit_lists = CountingUnit::all();

		$check_qty = 0;

		$est_price = 0;

		$customer = Customer::where('user_id', $request->user()->id)->first();

		if($customer->customer_level == 1 ) {

			foreach ($count_unit_lists as $count_unit) {
				
				foreach ($unit_lists as $unit) {
					
					if ($unit->id == $count_unit->count_unit_id) {

						$est_price += $count_unit->qty * $unit->normal_sale_price;	
					}					
				}
			}	

		} elseif ($customer->customer_level == 2) {

			foreach ($count_unit_lists as $count_unit) {
				
				foreach ($unit_lists as $unit) {
					
					if ($unit->id == $count_unit->count_unit_id) {

						$est_price += $count_unit->qty * $unit->whole_sale_price;
						
					}
					
				}
			}

		} else{

			foreach ($count_unit_lists as $count_unit) {
				
				foreach ($unit_lists as $unit) {
					
					if ($unit->id == $count_unit->count_unit_id) {

						$est_price += $count_unit->qty * $unit->order_price;
					}
					
				}
			}

		}
		

		foreach ($count_unit_lists as $count_unit) {
			
			$check_qty += $count_unit->qty;
		}

		if ($check_qty != $request->total_qty) {
			
			return $this->sendFailResponse("Something Wrong! Not equal amount.", "400");
		}
		else{	

			try {

	            $order = Order::create([
	                'address' => $request->address,
	                'name' => $request->name,
	                'phone' => $request->phone,
	                'total_quantity' => $request->total_qty,
	                'est_price' => $est_price,
	                'order_date' => $order_format_date,
	                'customer_id' => $customer->id,
	                'status' => 1, 										// Order Status = 1
	            ]);

	            $order->order_number = "ORD-".sprintf("%04s", $order->id);

	            $order->save();

	            foreach ($count_unit_lists as $count_unit) {
				
					$order->counting_unit()->attach($count_unit->count_unit_id, ['quantity' => $count_unit->qty]);
				}

				return $this->sendSuccessResponse("order", $order);

            
        	} catch (\Exception $e) {
            
            return $this->sendFailResponse("Something Wrong! When store Order.", "422");

        	}
		}	
    }

    protected function getOrderList(Request $request)
    {
    	$user = User::find($request->user()->id);

    	$customer = Customer::where('user_id', $user->id)->first();

    	$order_lists = Order::where('customer_id', $customer->id)->orderBy('id', 'desc')->get();

    	$final_orders = OrderResource::collection($order_lists);

    	return $this->sendSuccessResponse("order_lists", $final_orders);
    }

    protected function getOrderDetails(Request $request)
    {
    	$validator = Validator::make($request->all(), [
			'order_id' => 'required',
		]);

		if ($validator->fails()) {			

			return $this->sendFailResponse("Something Wrong! Validation Error.", "400");
		}

		try {

			$order = Order::findOrFail($request->order_id);

   		} catch (\Exception $e) {
   		    
        	return $this->sendFailResponse("Something Wrong! Order Cannot Be found.", "400");

    	}

    	$unit_lists = array();

    	foreach($order->counting_unit as $unit){

    		$unit_id = $unit->id;

    		$unit_name = $unit->unit_name;

    		$item_name = $unit->item->item_name;

    		$order_qty = $unit->pivot->quantity;

    		$collection = collect(['count_unit_id','unit_name', 'item_name','qty']);

			$combined = $collection->combine([$unit_id,$unit_name,$item_name,$order_qty]);

    		array_push($unit_lists, $combined);

    	}

    	$order_response = Order::where('id',$request->order_id)->get();

    	$final_orders = OrderResource::collection($order_response);

    	return response()->json([
    		"message" => "Successful",
    		"status" => 200,
    		"order" => $final_orders,
    		"unit_lists" => $unit_lists,
    	]);	                                                                 
		                            
    }

    protected function changeOrder(Request $request)
    {
    	$validator = Validator::make($request->all(), [
			'order_id' => 'required',
			'total_qty' => 'required',
			'counting_unit' => 'required',
		]);

		if ($validator->fails()) {			

			return $this->sendFailResponse("Something Wrong! Validation Error.", "400");
		}

		$check_qty = 0;

		$est_price = 0;

		$unit_lists = CountingUnit::all();

		try {

			$order = Order::findOrFail($request->order_id);

			$order->counting_unit()->detach();	

			$customer = Customer::findOrFail($order->customer_id);
			
		} catch (\Exception $e) {

			return $this->sendFailResponse("Something Wrong! Order cannot be found.", "422");			
		}

		if ($order->status == 4) {

			return $this->sendFailResponse("Something Wrong! Order cannot be changed.", "422");
		}
		else{

			$count_unit_lists = json_decode(json_encode($request->counting_unit));

			foreach ($count_unit_lists as $count_unit) {
				
				$check_qty += $count_unit->qty;
			}

			if ($check_qty != $request->total_qty) {
				
				return $this->sendFailResponse("Something Wrong! Not equal amount.", "400");
			}

			foreach ($count_unit_lists as $count_unit) {
					
				$order->counting_unit()->attach($count_unit->count_unit_id, ['quantity' => $count_unit->qty]);
			}

			if($customer->customer_level == 1 ) {

				foreach ($count_unit_lists as $count_unit) {
					
					foreach ($unit_lists as $unit) {
						
						if ($unit->id == $count_unit->count_unit_id) {

							$est_price += $count_unit->qty * $unit->normal_sale_price;	
						}					
					}
				}	

			} elseif ($customer->customer_level == 2) {

				foreach ($count_unit_lists as $count_unit) {
					
					foreach ($unit_lists as $unit) {
						
						if ($unit->id == $count_unit->count_unit_id) {

							$est_price += $count_unit->qty * $unit->whole_sale_price;
							
						}
						
					}
				}

			} else{

				foreach ($count_unit_lists as $count_unit) {
					
					foreach ($unit_lists as $unit) {
						
						if ($unit->id == $count_unit->count_unit_id) {

							$est_price += $count_unit->qty * $unit->order_price;
						}
						
					}
				}
				
			}

			$order->total_quantity = $request->total_qty;

			$order->est_price = $est_price;

			$order->status = 3;

			$order->save();

			return $this->sendSuccessResponse("order", $order);

		}
    }

    protected function acceptOrder(Request $request)
    {
    	$today = $this->today();

    	$validator = Validator::make($request->all(), [
			'order_id' => 'required',
			'remark' => 'required'
		]);

		if ($validator->fails()) {			

			return $this->sendFailResponse("Something Wrong! Validation Error.", "400");
		}

		try {

			$order = Order::findOrFail($request->order_id);

   		} catch (\Exception $e) {
   		    
        	return $this->sendFailResponse("Something Wrong! Order Cannot Be found.", "400");

    	}

    	if ($order->status != 4 ) {

    		return $this->sendFailResponse("Something Wrong! This Order is Not Delivered!.", "400");

    	} else {

    		$accept_date = date('Y-m-d H:i', $today);
    		
    		$order->accepted_date = $accept_date;

			$order->remark = $request->remark;

			$order->status = 5;

			$order->save();

			return $this->sendSuccessResponse("order", $order);

    	}
    	
    }
}
