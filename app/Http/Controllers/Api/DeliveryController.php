<?php

namespace App\Http\Controllers\Api;

use App\Getlocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiBaseController;


class DeliveryController extends ApiBaseController
{
    public function deliverySendlocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'rider_id' => 'required',
			'address' => 'required',
			'lat' => 'required',
			'long' => 'required',
		]);

		if ($validator->fails()) {			

			return $this->sendFailResponse("Something Wrong! Validation Error.", "400");
		}
        $sendLocation  = Getlocation::create([
            'rider_id'=> $request->rider_id,
            'address'=> $request->address,
            'lat'=> $request->lat,
            'long'=> $request->long,
        ]);
		return $this->sendSuccessResponse("location", $sendLocation);

    }
    public function deliveryGetlocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'rider_id' => 'required'
		]);

		if ($validator->fails()) {			

			return $this->sendFailResponse("Something Wrong! Validation Error.", "400");
		}
        $sendLocation  = Getlocation::where('rider_id',$request->rider_id)->latest()->first();;

		return $this->sendSuccessResponse("location", $sendLocation);

    }
}
