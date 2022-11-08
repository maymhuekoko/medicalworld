<?php

namespace App\Http\Controllers\Api;

use App\Getlocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiBaseController;
use Illuminate\Support\Facades\DB;

class WebsiteUserApiController extends ApiBaseController
{
   //Index
   public function index(){
       $users = DB::select('select * from website_user');
        return response()->json([
            'data'=>$users,
            ],200);
   }

   //Store
   public function store(Request $request){

      $user = DB::table('website_user')->insert([
        "name" => $request->name,
        "phone" => $request->phone,
        "address" => $request->address,
        "username" => $request->username,
        "email" => $request->email,
        "password" => \Hash::make($request->password),
          ]);

       $user_id = DB::table('website_user')->latest('id')->first();
    //   dd($user_id->id);
        return response()->json([
            'data'=>$user_id->id,
            ],200);
   }

   public function login(Request $request){
       $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => 'Validation Fails',
                'data' => null
            ]);
        }

        $user = User::where('email', $request->email)->where('user_code', $request->user_code)->first();

        if (!isset($user)) {

            alert()->error('Wrong User Code Or Email!');

            return redirect()->back();
        }
        elseif (!\Hash::check($request->password, $user->password)) {

            alert()->error('Wrong Password!');

            return redirect()->back();
        }

        session()->put('user', $user);

        $today_date = (new DateTime)->format('Y-m-d');

        $last_date = date('Y-m-d', strtotime('-1day', strtotime($today_date)));

        $today_sale = 0;

        $last_day_sale = 0;

        $today_vouchers = Voucher::where('voucher_date', $today_date)->get();

        $last_date_vouchers = Voucher::where('voucher_date', $last_date)->get();

        foreach ($today_vouchers as $tdy) {

            $today_sale += $tdy->total_price;
        }

        foreach ($last_date_vouchers as $last) {

            $last_day_sale += $last->total_price;
        }

        session()->put('today_sale', $today_sale);

        session()->put('last_day_sale', $last_day_sale);

        return redirect()->route('index');
   }
}
