<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiBaseController extends Controller
{
    protected function sendSuccessResponse( $data_name = "", $data = [] ){

    	$successStatus = 200;
    	
    	return response()->json([
    		"message" => "Successful",
    		"status" => $successStatus,
    		$data_name => $data,
    	]);
    }

    
    protected function sendFailResponse($message, $status){
    	
    	return response()->json([
    		"message" => $message,
    		"status" => $status
    	]);
    }
}
