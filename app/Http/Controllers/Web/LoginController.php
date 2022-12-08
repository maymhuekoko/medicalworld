<?php

namespace App\Http\Controllers\Web;


use Auth;
use Session;
use App\From;
use App\User;
use DateTime;
use App\Order;
use App\Income;
use App\Expense;
use App\Voucher;
use App\Purchase;
use App\FactoryPo;
use App\BankAccount;
use App\Transaction;
use App\CountingUnit;
use App\FactoryOrder;
use App\SupplierCreditList;
use Illuminate\Http\Request;
use App\CustomUnitFactoryOrder;
use Jenssegers\Agent\Facades\Agent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index(Request $request) {

        if (Session::has('user')) {

            if($request->session()->get('user')->role == "Owner"){
                //$from = From::find(1);

                $total_sales = 0;

        $total_order = 0;

        $total_profit = 0;

        $other_income = 0;

        $other_expense = 0;

        $total_purchase = 0;

        $total_transaction = 0;

                $date = new DateTime('Asia/Yangon');

                $current_date = strtotime($date->format('Y-m-d'));
                $to = $date->format('Y-m-d');



                $current_month = $date->format('m');
                $current_month_year = $date->format('Y');

                $today_date = $date->format('Y-m-d');
                $daily_sales = Voucher::whereDate('voucher_date', $today_date)->get();

                $daily_sales_count = count($daily_sales->toArray());
                $daily_sales_amt = 0;
                foreach($daily_sales as $day){
                if($day->discount_value > 1 && $day->discount_type != 'foc'){
                $daily_sales_amt += $day->total_price - $day->discount_value;
            }
            elseif ($day->discount_value == 0 || $day->discount_type == ''){
                $daily_sales_amt += $day->total_price;
            }
            else {
                $daily_sales_amt += 0;
                }
            }

            $daily_order = Order::whereDate('order_date', $today_date)->get();

                $daily_order_count = count($daily_order->toArray());
                $daily_order_amt = 0;
                foreach($daily_order as $day){
                if($day->total_discount_value > 1 && $day->total_discount_type != 'foc'){
                $daily_order_amt += $day->est_price - $day->total_discount_value;
            }
            elseif ($day->total_discount_value == 0 || $day->total_discount_type == ''){
                $daily_order_amt += $day->est_price;
            }
            else {
                $daily_order_amt += 0;
                }
            }

            $daily_factory_order = FactoryOrder::whereDate('created_at',$today_date)->get();

            $daily_factoryorder_count = count($daily_factory_order->toArray());
            $daily_factoryorder_itemcount = 0;
            foreach($daily_factory_order as $day){
                $factory_order_items = CustomUnitFactoryOrder::where('factory_order_id',$day->id)->get();
                foreach($factory_order_items as $item){
                    $daily_factoryorder_itemcount += $item->quantity;
                }
            }

            $daily_factory_po = FactoryPo::whereDate('po_date',$today_date)->get();

            $daily_factorypo_count = count($daily_factory_po->toArray());
            $daily_factorypo_itemcount = 0;
            foreach($daily_factory_po as $day){

                    $daily_factorypo_itemcount += $day->total_qty;

            }

            $daily_purchase = Purchase::whereDate('purchase_date',$today_date)->where('purchase_type',2)->get();

            $daily_purchase_count = count($daily_purchase->toArray());
            $daily_purchase_amt = 0;
            foreach($daily_purchase as $day){

                    $daily_purchase_amt += $day->total_price;

            }

            $daily_transaction = Transaction::whereDate('tran_date',$today_date)->get();

            $daily_transaction_count = count($daily_transaction->toArray());
            $daily_transaction_amt = 0;
            foreach($daily_transaction as $day){

                    $daily_transaction_amt += $day->pay_amount;

            }

            $counting_units = CountingUnit::all();
            $total_inventory = 0;
            foreach($counting_units as $unit){
                $total_inventory += ($unit->purchase_price * $unit->current_quantity);
            }

            $orders = Order::all();
            $total_receivable = 0;
            foreach($orders as $order){
                $total_receivable += ($order->est_price - $order->advance_pay);
            }

            $bank_accounts = BankAccount::all();
            $total_cash = 0;
            foreach($bank_accounts as $account){
                $total_cash += $account->balance;
            }

            $supplier_credit_lists = SupplierCreditList::all();
            $total_payable = 0;
            foreach($supplier_credit_lists as $credit_list){
                $total_payable += $credit_list->credit_amount;
            }


            $voucher_lists = Voucher::whereMonth('voucher_date', $current_month)->get();

             $order_lists = Order::whereMonth('order_date', $current_month)->get();

            $other_incomes = Income::whereMonth('date', $current_month)->orWhere('type', 1)->get();

            foreach($other_incomes as $other){
                if($other->type == 1 && $other->period == 1){
                    $other_income += $other->amount * 30;
                }
                else if($other->type == 1 && $other->period == 2){
                    $other_income += $other->amount * 4;
                }
                else if($other->type == 1 && $other->period == 3){
                    $other_income += $other->amount;
                }
                else{
                    $other_income += $other->amount;
                }
            }

            $other_expenses = Expense::whereMonth('date', $current_month)
                                        ->orWhere('type', 1)->get();

            foreach($other_expenses as $other){
                if($other->type == 1 && $other->period == 1){
                    $other_expense += $other->amount * 30;
                }
                else if($other->type == 1 && $other->period == 2){
                    $other_expense += $other->amount * 4;
                }
                else if($other->type == 1 && $other->period == 3){
                    $other_expense += $other->amount;
                }
                else{
                    $other_expense += $other->amount;
                }
            }

             $purchase_lists = Purchase::whereMonth('purchase_date', $current_month)->where('purchase_type',2)->get();

            foreach($purchase_lists as $purchae){
                $total_purchase += $purchae->total_price;
            }

            $transaction_lists = Transaction::whereMonth('tran_date', $current_month)->get();

            foreach($transaction_lists as $transaction){
                $total_transaction += $transaction->pay_amount;
            }


            foreach ($voucher_lists as $lists) {

                if($lists->discount_value > 1 && $lists->discount_type != 'foc'){
                $total_sales += $lists->total_price - $lists->discount_value;
            }
            else if ($lists->discount_value == 0 || $lists->discount_type == ''){
                $total_sales += $lists->total_price;
            }
            else{
                $total_sales += 0;
            }



                foreach ($lists->counting_unit as $unit) {

                    $total_profit += ($unit->pivot->price * $unit->pivot->quantity) - ($unit->purchase_price * $unit->pivot->quantity);
                }

            }

        foreach($order_lists as $order){
            $total_order += $order->est_price;
        }




                return view('Admin.manager_dashboard',compact('total_sales','total_order','total_profit','total_purchase','total_transaction','other_income','other_expense','total_inventory','total_receivable','total_payable','total_cash','daily_sales_count','daily_sales_amt','daily_order_count','daily_order_amt','daily_purchase_count','daily_purchase_amt','daily_transaction_count','daily_transaction_amt','daily_factoryorder_count','daily_factoryorder_itemcount','daily_factorypo_count','daily_factorypo_itemcount'));

                //return redirect()->route('stock_count');

            }elseif ($request->session()->get('user')->role == "Sales" || $request->session()->get('user')->role == "Sales_Inventory") {
            $from_id= $request->session()->get('user')->from_id;
            $request->session()->put('from',$from_id);
            return redirect()->route('sale_page');

            }elseif($request->session()->get('user')->role == "Stock"){
                return redirect()->route('stock_count');
            }elseif($request->session()->get('user')->role == "Factory"){
                return redirect()->route('factorypo_page');
            }elseif($request->session()->get('user')->role == "Finance"){
                return redirect()->route('financial');
            }
            elseif($request->session()->get('user')->role == "Partner"){
                return redirect()->route('sale_history');
            }
        }
        else{

            return view('login');

        }

	}

    public function loginProcess(Request $request){

        // $res = Http::post('http://192.168.100.25:8080/api/getUserAccess', [
        //     'appcode' => 'app_001',
        //     'token' => '12345',
        // ]);

        // if($res == 'true'){
        //     $validator = Validator::make($request->all(), [
        //         'user_code' => 'required',
        //         'email' => 'required',
        //         'password' => 'required',
        //     ]);

        //     if ($validator->fails()) {

        //         alert()->error('Something Wrong! Validation Error!');

        //         return redirect()->back()->withErrors($validator)->withInput();
        //     }

        //     $user = User::where('email', $request->email)->where('user_code', $request->user_code)->first();

        //     if (!isset($user)) {

        //         alert()->error('Wrong User Code Or Email!');

        //         return redirect()->back();
        //     }
        //     elseif (!\Hash::check($request->password, $user->password)) {

        //         alert()->error('Wrong Password!');

        //         return redirect()->back();
        //     }elseif ($user->access_flag == 'false'){
        //         alert()->error('Access Denied!');

        //         return redirect()->back();
        //     }

        // $device = Agent::device();
        // $platform = Agent::platform();
        // $browser = Agent::browser();
        // if( Agent::isDesktop()==true)
        // {
        // $user_device_info=' Desktop '.$device.' '.$platform.' '.$browser.' ';

        // }
        // else if (Agent::isTablet()==true)
        // {

        //     $user_device_info=' Tablet '.$device.' '.$platform.' '.$browser.' ';

        // }
        // else if(  Agent::isPhone()==true)
        // {

        // $user_device_info=' Phone '.$device.' '.$platform.' '.$browser.' ';

        // }

        // date_default_timezone_set('Asia/Yangon');
        // $user->last_login = date('d-m-y h:i:s');
        // $user->save();

        //     session()->put('user', $user);

        //     $today_date = (new DateTime)->format('Y-m-d');

        //     $last_date = date('Y-m-d', strtotime('-1day', strtotime($today_date)));

        //     $today_sale = 0;

        //     $last_day_sale = 0;

        //     $today_vouchers = Voucher::where('voucher_date', $today_date)->get();

        //     $last_date_vouchers = Voucher::where('voucher_date', $last_date)->get();

        //     foreach ($today_vouchers as $tdy) {

        //         $today_sale += $tdy->total_price;
        //     }

        //     foreach ($last_date_vouchers as $last) {

        //         $last_day_sale += $last->total_price;
        //     }

        //     session()->put('today_sale', $today_sale);

        //     session()->put('last_day_sale', $last_day_sale);

        //     return redirect()->route('index');
        // }else{
        //     alert()->error('Access Denied!');
        //     return redirect()->back();
        // }
        $validator = Validator::make($request->all(), [
            'user_code' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error('Something Wrong! Validation Error!');

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->where('user_code', $request->user_code)->first();

        if (!isset($user)) {

            alert()->error('Wrong User Code Or Email!');

            return redirect()->back();
        }
        elseif (!\Hash::check($request->password, $user->password)) {

            alert()->error('Wrong Password!');

            return redirect()->back();
        }elseif ($user->access_flag == 'false'){
            alert()->error('Access Denied!');

            return redirect()->back();
        }

    $device = Agent::device();
    $platform = Agent::platform();
    $browser = Agent::browser();
    if( Agent::isDesktop()==true)
    {
    $user_device_info=' Desktop '.$device.' '.$platform.' '.$browser.' ';

    }
    else if (Agent::isTablet()==true)
    {

        $user_device_info=' Tablet '.$device.' '.$platform.' '.$browser.' ';

    }
    else if(  Agent::isPhone()==true)
    {

    $user_device_info=' Phone '.$device.' '.$platform.' '.$browser.' ';

    }

    date_default_timezone_set('Asia/Yangon');
    $user->last_login = date('d-m-y h:i:s');
    $user->save();

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

    public function logoutProcess(Request $request){

        Session::flush();

        alert()->success("Successfully Logout");

        return redirect()->route('index');

    }

    public function getChangePasswordPage(){

        return view('change_pw');
    }

    protected function updatePassword(Request $request){

        $validator = Validator::make($request->all(), [
             'current_pw' => 'required',
             'new_pw' => 'required|confirmed|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/'

        ]);

        if ($validator->fails()) {

            alert()->error('Something Wrong!');
            return redirect()->back()->withErrors($validator);

        }

        $user = $request->session()->get('user');

        $current_pw = $request->current_pw;

        if(!\Hash::check($current_pw, $user->password)){

            alert()->info("Wrong Current Password!");

            return redirect()->back();
        }

        $has_new_pw = \Hash::make($request->new_pw);

        $user->password = $has_new_pw;

        $user->save();

        alert()->success('Successfully Changed!');

        return redirect()->route('Admin.shoplists');
    }
}
