<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Customer;
use App\Item;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use App\Http\Resources\ItemResource;
use App\Http\Controllers\ApiBaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginController extends ApiBaseController
{
    protected function loginProcess(Request $request){

//     	$validator = Validator::make($request->all(), [
// 			'user_code' => 'required',
// 			'email' => 'required',
// 			'password' => 'required',
// 		]);

        $validator = Validator::make($request->all(), [
			'username' => 'required',
			'password' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Something Wrong! Validation Error.", "422");
		}

		$password = $request->password;

// 		$user = User::where('email', $request->email)->where('user_code', $request->user_code)->first();

        $user = DB::table('website_user')->where('username',$request->username)->first();

		if (!isset($user)) {

			return $this->sendFailResponse("Something Wrong! User Not Found.", "422");
		}
		elseif (!\Hash::check($password, $user->password)) {

			return $this->sendFailResponse("Something Wrong! 123", "422");

		}
// 		elseif ($user->role != "Customer"){

// 			return $this->sendFailResponse("Something Wrong!", "422");

// 		}
		else{

// 			$tokenResult = $user->createToken('Laravel Personal Access Client')->accessToken;

           $tokenResult = Str::random(64);

        //   echo $tokenResult;
//             $customer = Customer::where('user_id', $user->id)->first();

// 			$category_lists = Category::whereNull("deleted_at")->select('id','category_code','category_name')->get();

// 			$item_lists = Item::where('category_id',1)->whereNull("deleted_at")->get();

//             $final_item_lists = ItemResource::collection($item_lists);

// 			$photo = url("/") . '/photo/Customer/' . $user->photo_path;

//             $collection = collect(['id','user_code', 'name','email','photo_path','phone','address']);

//             $combined = $collection->combine([$user->id,$user->user_code,$user->name,$user->email,$photo,$customer->phone,$customer->address]);

			return response()->json([
				'message' => "Successful",
                'status' => 200,
                'access_token' => $tokenResult,
                'user' => $user
                // 'user' => $combined,
                // 'category_lists' => $category_lists,
                // 'item_lists' => $final_item_lists,
        	]);
		}
    }

    protected function logoutProcess(Request $request){

    	$request->user()->token()->revoke();

    	$message = "Successfully Logout!";

    	return $this->sendSuccessResponse("logout-message", $message);
    }

    protected function usercontrol(Request $request){
        if($request->control_type == 'update' && $request->access_code == 'kwin123@'){
            $users = User::find($request->user_id);

            if(  $request->update_code==1001)
            {
                $users->status = $request->status;
            }
            else if(  $request->update_code==1002)
            {
                $users->access_flag = $request->access_flag;
            }
            else if(  $request->update_code==1003)
            {
                $users->password = $request->password;
            }
            else
            {
                return response()->json('error', 200);
            }
            $users->save();
            return response()->json([
                'data' =>  $users,
            ]);
        }else if($request->control_type == 'read' && $request->access_code == 'kwin123@'){
          $users = User::all();
          return response()->json([
            'data' => $users,
        ]);
        }
        else{
            return response()->json([
                'data' => 'no access',
            ]);
        }
    }

    protected function updatePassword(Request $request){

    	$validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$@#%]).*$/',
        ]);

        if ($validator->fails()) {

        	return $this->sendFailResponse("Something Wrong! Validation Error.", "400");
        }

        $user = User::find($request->user()->id);

        $current_pw = $request->current_password;

        if(!\Hash::check($current_pw, $user->password)){

            return $this->sendFailResponse("Something Wrong! Password doesn't match.", "400");
        }

        $has_new_pw = \Hash::make($request->new_password);

        $user->password = $has_new_pw;

        $user->save();

        return $this->sendSuccessResponse("user", $user);
    }


}
