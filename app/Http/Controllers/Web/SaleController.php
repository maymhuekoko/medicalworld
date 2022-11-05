<?php

namespace App\Http\Controllers\Web;

use App\From;
use App\Item;
use DateTime;
use App\Order;
use App\Voucher;
use App\OrderVoucher;
use App\Category;
use App\Customer;
use App\Discount;
use App\Employee;
use Carbon\Carbon;
use App\Itemadjust;
use App\Stockcount;
use App\SubCategory;
use App\CountingUnit;
use App\DiscountMain;
use App\SalesCustomer;
use Illuminate\Http\Request;
use App\SaleCustomerCreditlist;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;
use App\Exports\SalesHistoryExport;

class SaleController extends Controller
{

    private $excel;


    public function __construct(Excel $excel){
        $this->excel = $excel;
    }

    protected function getSalePanel(){

        return view('Sale.sale_panel');

    }

    protected function getSalePage(Request $request){
        $role= $request->session()->get('user')->role;
        if($role=='Sale_Person'){
            $item_from= $request->session()->get('user')->from_id;
        }
        else {
            $item_from= $request->session()->get('from');
        }
        $froms=From::find(1);
//        $items = $froms->items()->with('category')->with('counting_units')->with("counting_units.stockcount")->with('sub_category')->get();
        // $items = Item::with('counting_units')->get();

        $items = Item::where("category_id",1)->where("sub_category_id",2)->get();
        $item_ids=[];
        //$counting_units=[];
        foreach ($items as $item){
            array_push($item_ids,$item->id);
        }
        $counting_units = CountingUnit::whereIn('item_id',$item_ids)->get();

        $categories = Category::all();

        $sub_categories = SubCategory::all();

        $customers = Customer::all();

        $employees = Employee::all();

        $date = new DateTime('Asia/Yangon');

        $today_date = strtotime($date->format('d-m-Y H:i'));
        $vou_date = $date->format('d M Y');
        
       

        $last_voucher = Voucher::count();
        if($last_voucher != null){
            $voucher_code =  "SVOU-" .date('y') . sprintf("%02s", (intval(date('m')))) . sprintf("%02s", ($last_voucher - 916));
           
        }else{
            $voucher_code =  "SVOU-" .date('y') . sprintf("%02s", (intval(date('m')))) .sprintf("%02s", 1);
        }
        //$voucher_count = count(Voucher::all());


        $salescustomers = SalesCustomer::all();
        // dd($salescustomers);
        return view('Sale.sale_page',compact('voucher_code','items','categories','customers','employees','today_date','sub_categories','salescustomers','counting_units','vou_date'));
    }

    protected function getVucherPage(Request $request){
        // dd($request->item);
        $right_now_customer= $request->right_now_customer;
        $date = new DateTime('Asia/Yangon');

        $today_date = $date->format('d-m-Y h:i:s');

        $check_date = $date->format('Y-m-d');

        $items = json_decode($request->item);

        $grand = json_decode($request->grand);

        $last_voucher = Voucher::count();

        $voucher_code =  "SVOU-".date('dmY')."-".sprintf("%03s", ($last_voucher+ 1));

        $salescustomers = SalesCustomer::all();

        $foc = json_decode($request->foc_flag);

        $has_dis = json_decode($request->has_dis);
        // dd($has_dis);

        $discount = json_decode($request->discount);
        $last_voucher = Voucher::count();

        $voucher_code =  "SVOU-".date('dmY')."-".sprintf("%03s", ($last_voucher+ 1));

        $salescustomers = SalesCustomer::all();

        return view('Sale.voucher', compact('has_dis','foc','discount','items','today_date','grand','voucher_code','right_now_customer','salescustomers'));
    }

    protected function storeVoucher(request $request){
        // dd($request->all());
        // $exitvoucher_id=(int)$request->voucher_id;
        // $exitvoucher = Voucher::find($exitvoucher_id);
        // if($exitvoucher){
        //     return response()->json($exitvoucher);
        // }
        $user = session()->get('user');

        $shop_id = session()->get('from');

        $date = new DateTime('Asia/Yangon');

        $today_date = $date->format('d-m-Y h:i:s');

        $voucher_date = $date->format('Y-m-d');

        $today_time = $date->format('g:i A');

        $items = json_decode(json_encode($request->item));

        $grand = json_decode(json_encode($request->grand));

        $total_quantity = $grand->total_qty;

        $total_amount = $grand->sub_total;

        $agent = new \Jenssegers\Agent\Agent;

        // $is_mobile = $agent->isDesktop();

        $is_mobile = $agent->isMobile();

        $discounts = json_decode(json_encode($request->discount));

        $discount_voucher = json_decode($request->vou_discount);

        $foc = json_decode(json_encode($request->foc_flag));

        $has_dis = json_decode(json_encode($request->has_dis));

        $total_quantity = $grand->total_qty;

        $total_amount = $grand->sub_total;

        // dd($discount_voucher->voucher_discount);

        $voucher = Voucher::create([
            'sale_by' => $user->id,
            'voucher_code' => $request->voucher_code,
            'total_price' =>  $total_amount,
            'total_quantity' => $total_quantity,
            'voucher_date' => $voucher_date,
            'type' => 1,
            'status' => 0,
            'sales_customer_id' => $request->sales_customer_id,
            'sales_customer_name' => $request->sales_customer_name,
            'from_id'=> $shop_id,
            'is_print'=> $request->is_print ?? 0,
            'is_mobile'=> $is_mobile ? 1 : 0,

        ]);

        if(isset($request->credit_amount) && $request->credit_amount > 0){
            $sales_customer = SalesCustomer::find($request->sales_customer_id);
            $sales_customer->credit_amount += $request->credit_amount;
            $sales_customer->deleted_at = null;
            $sales_customer->save();



            $salescustomer_credit = SaleCustomerCreditlist::create([
                'sales_customer_id' => $request->sales_customer_id,
                "voucher_id" => $voucher->id,
                "voucher_code" => $voucher->voucher_code,
                "repaymentdate"=> $request->repaymentDate,
                "credit_amount"=>$request->credit_amount,

            ]);
        }
        //  return response()->json("here");
        foreach ($items as $item) {

            $voucher->counting_unit()->attach($item->id, ['quantity' => $item->order_qty,'price' => $item->selling_price]);

            $counting_unit = CountingUnit::find($item->id);
            $stock=$counting_unit->stockcount->where('from_id', $shop_id)->first();
            $balance_qty = ($stock->stock_qty - $item->order_qty);

            $stock->stock_qty = $balance_qty;

            $stock->save();

        }
        if($discount_voucher == null && $foc == null && $has_dis != null)
        {
            $sales_customer = SalesCustomer::find($voucher->sales_customer_id);
            $discount_main = DiscountMain::create([
                "voucher_id" => $voucher->id,
                "voucher_date" => $voucher->voucher_date,
                "discount_type" => 1,
                "discount_flag" => 0,
                "voucher_code" => $voucher->voucher_code,
                "sale_customer_name" => $sales_customer->name,
                "items" => json_encode($request->discount)
            ]);
        }
        elseif($discount_voucher == null && $has_dis == null && $foc != null)
        {
            $sales_customer = SalesCustomer::find($voucher->sales_customer_id);
            $discount_main = DiscountMain::create([
                "voucher_id" => $voucher->id,
                "voucher_date" => $voucher->voucher_date,
                "discount_type" => 2,
                "discount_flag" => 3,
                "voucher_code" => $voucher->voucher_code,
                "sale_customer_name" => $sales_customer->name,
                "items" => json_encode($request->discount)
            ]);
        }
        elseif($discount_voucher != null && $has_dis == null && $foc == null)
        {
            $sales_customer = SalesCustomer::find($voucher->sales_customer_id);
            $discount_main = DiscountMain::create([
                "voucher_id" => $voucher->id,
                "voucher_date" => $voucher->voucher_date,
                "discount_type" => "Whole Voucher Discount",
                "discount_flag" => 3,
                "voucher_code" => $voucher->voucher_code,
                "sale_customer_name" => $sales_customer->name,
                "items" => json_encode($request->discount),
                "total_voucher_amount" => $discount_voucher->voucher_discount,
            ]);
        }
        elseif($discount_voucher != null && $has_dis == null && $foc != null)
        {
            $sales_customer = SalesCustomer::find($voucher->sales_customer_id);
            $discount_main = DiscountMain::create([
                "voucher_id" => $voucher->id,
                "voucher_date" => $voucher->voucher_date,
                "discount_type" => 4,
                "discount_flag" => 1,
                "voucher_code" => $voucher->voucher_code,
                "sale_customer_name" => $sales_customer->name,
                "items" => json_encode($request->discount),
                "total_voucher_amount" => $discount_voucher->voucher_discount,
            ]);
        }
        elseif($discount_voucher != null && $has_dis != null && $foc == null)
        {
            $sales_customer = SalesCustomer::find($voucher->sales_customer_id);
            $discount_main = DiscountMain::create([
                "voucher_id" => $voucher->id,
                "voucher_date" => $voucher->voucher_date,
                "discount_type" => 5,
                "discount_flag" => 2,
                "voucher_code" => $voucher->voucher_code,
                "sale_customer_name" => $sales_customer->name,
                "items" => json_encode($request->discount),
                "total_voucher_amount" => $discount_voucher->voucher_discount,
            ]);
        }
        elseif($discount_voucher == null && $has_dis != null && $foc != null)
        {
            $sales_customer = SalesCustomer::find($voucher->sales_customer_id);
            $discount_main = DiscountMain::create([
                "voucher_id" => $voucher->id,
                "voucher_date" => $voucher->voucher_date,
                "discount_type" => 7,
                "discount_flag" => 2,
                "voucher_code" => $voucher->voucher_code,
                "sale_customer_name" => $sales_customer->name,
                "items" => json_encode($request->discount)
            ]);
        }
        elseif($discount_voucher != null && $has_dis != null && $foc != null)
        {
            $sales_customer = SalesCustomer::find($voucher->sales_customer_id);
            $discount_main = DiscountMain::create([
                "voucher_id" => $voucher->id,
                "voucher_date" => $voucher->voucher_date,
                "discount_type" => 6,
                "discount_flag" => 2,
                "voucher_code" => $voucher->voucher_code,
                "sale_customer_name" => $sales_customer->name,
                "items" => json_encode($request->discount),
                "total_voucher_amount" => $discount_voucher->voucher_discount,
            ]);
        }


        if($foc != null)
        {
            $discount_main->foc_flag = 1;
            $discount_main->save();
        }




        if($discount_voucher == null)
        {
            foreach($discounts as $discount)
            {
                if($discount->different != 0 || $discount->discount_flag == 1)
                {
                    $counting_unit_id = CountingUnit::find($discount->id);
                    $item = Item::find($counting_unit_id->item_id);
                    $sales_customer = SalesCustomer::find($voucher->sales_customer_id);
                    $discount_table = Discount::create([
                        'discount_main_id' => $discount_main->id,
                        'item_id' => $counting_unit_id->item_id,
                        'counting_unit_id' => $discount->id,
                        'voucher_id' => $voucher->id,
                        'voucher_date' => $voucher->voucher_date,
                        'voucher_code' => $voucher->voucher_code,
                        'discount_item_amount' => $discount->discount,
                        'original_price' => $discount->original_price,
                        'discount_flag' => $discount->discount_flag,
                        'item_name' => $item->item_name,
                        'counting_unit_name' => $counting_unit_id->unit_name,
                        'sale_customer_name' => $sales_customer->name,
                    ]);
                }
            }
        }
        else
        {
            // dd("nono");
            foreach($discounts as $discount)
            {
                // dd($discount->original_price);
                $counting_unit_id = CountingUnit::find($discount->id);
                $item = Item::find($counting_unit_id->item_id);
                $sales_customer = SalesCustomer::find($voucher->sales_customer_id);
                $discount_table = Discount::create([
                    'discount_main_id' => $discount_main->id,
                    'item_id' => $counting_unit_id->item_id,
                    'counting_unit_id' => $discount->id,
                    'voucher_id' => $voucher->id,
                    'voucher_date' => $voucher->voucher_date,
                    'voucher_code' => $voucher->voucher_code,
                    'discount_voucher_amount' => $discount_voucher->voucher_discount,
                    'original_price' => $discount->original_price,
                    'item_name' => $item->item_name,
                    'discount_item_amount' => $discount->discount,
                    'counting_unit_name' => $counting_unit_id->unit_name,
                    'sale_customer_name' => $sales_customer->name,
                    'discount_flag' => $discount->discount_flag,
                ]);

            }
        }
        return response()->json($voucher);

    }

    public function storetestVoucher(Request $request)
    {
        dd($request->all());
    }

    public function getCountingUnitsByItemId(request $request){

        $item_id = $request->item_id;

        $item = Item::where('id', $item_id)->first();

        $units = CountingUnit::where('item_id', $item->id)->where('current_quantity', '!=', 0)->with('item')->get();

        return response()->json($units);

    }

    public function getCountingUnitsByItemCode(Request $request){

        $unit_code = $request->unit_code;

        $units = CountingUnit::where('unit_code', $unit_code)->orWhere('original_code', $unit_code)->with('item')->first();

        return response()->json($units);
    }

    protected function getSaleHistoryPage(Request $request){
        $role= $request->session()->get('user')->role;

        $item_from = 1;

        $voucher_lists =Voucher::orderBy('id','desc')->get();

        $total_sales  = 0;

        foreach ($voucher_lists as $voucher_list){
            if($voucher_list->discount_value > 1 && $voucher_list->discount_type != 'foc'){
                $total_sales += $voucher_list->total_price - $voucher_list->discount_value;
            }
            else if ($voucher_list->discount_value == 0 || $voucher_list->discount_type == ''){
                $total_sales += $voucher_list->total_price;
            }
            else{
                $total_sales += 0;
            }

        }
        $date = new DateTime('Asia/Yangon');

        $current_date = strtotime($date->format('Y-m-d'));
        $to = $date->format('Y-m-d');

        $weekly = date('Y-m-d', strtotime('-1week', $current_date));


        $weekly_data = Voucher::whereBetween('voucher_date', [$weekly,$to])->get();

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

        $current_month = $date->format('m');
        $current_month_year = $date->format('Y');

        $today_date = $date->format('Y-m-d');
        $daily = Voucher::whereDate('created_at', $today_date)->get();


        $daily_sales = 0;
        foreach($daily as $day){
            if($day->discount_value > 1 && $day->discount_type != 'foc'){
                $daily_sales += $day->total_price - $day->discount_value;
            }
            elseif ($day->discount_value == 0 || $day->discount_type == ''){
                $daily_sales += $day->total_price;
            }
            else {
                $daily_sales += 0;
            }
        }

        $monthly = Voucher::whereMonth('created_at',$current_month)->whereYear('created_at',$current_month_year)->get();


        $monthly_sales = 0;

        foreach ($monthly as $month){

            if($month->discount_value > 1 && $month->discount_type != 'foc'){
                $monthly_sales += $month->total_price - $month->discount_value;
            }
            else if ($month->discount_value == 0 || $month->discount_type == ''){
                $monthly_sales += $month->total_price;
            }
            else{
                $monthly_sales += 0;
            }
        }

        $search_sales = 0;
        return view('Sale.sale_history_page',compact('search_sales','voucher_lists','total_sales','daily_sales','monthly_sales','weekly_sales'));
    }
    
    protected function saleHistoryExport(Request $request,$from,$to,$id,$sales,$data_type,$type){
        return $this->excel->download(new SalesHistoryExport($from,$to,$id,$sales,$data_type),'sale_voucher_history.xlsx');
    }
    
    protected function show_discount_list()
    {
        $discounts = Discount::all();
        $discount_main = DiscountMain::all();
        $all = 1;
        return view('Sale.sale_discount_record_list',compact('discount_main','discounts','all'));
    }
    protected function show_discount_type(Request $request)
    {
        // dd($request->discount_type);
        if($request->discount_type == 1)
        {
            $discount_sect = Discount::where('discount_flag',1)->get();

            return response()->json([
                'type' => 1,
                'discount' =>$discount_sect
            ]);
        }
        else if($request->discount_type == 2)
        {
            $discount_sect = Discount::where('discount_flag',0)->where('discount_item_amount','!=',null)->get();
            return response()->json([ 'type' => 2,
                'discount' =>$discount_sect]);
        }
        else if($request->discount_type == 3)
        {
            $discount_sect = Discount::where('discount_flag',0)->where('discount_voucher_amount','!=',null)->get();
            return response()->json([ 'type' => 3,
                'discount' =>$discount_sect]);
        }
    }
    protected function show_discount_date(Request $request)
    {
        // dd($request->voucher_date);
        $discount_date = Discount::where('voucher_date',$request->voucher_date)->get();
        return response()->json($discount_date);
    }
    protected function ajax_get_discount_main(Request $request)
    {
        // dd($request->discount_type);
        if($request->discount_type == 1)
        {
            $discount_main_data = DiscountMain::where('foc_flag',1)->get();
            return response()->json([
                'type' => 1,
                'disco' => $discount_main_data,
            ]);
        }
        elseif($request->discount_type == 2)
        {
            $discount_main_data = DiscountMain::where('discount_flag',0)->orWhere('discount_flag',2)->get();
            return response()->json([
                'type' => 2,
                'disco' => $discount_main_data,
            ]);
        }
        elseif($request->discount_type == 3)
        {
            $discount_main_data = DiscountMain::where('discount_type',4)->orWhere('discount_type',5)->orWhere('discount_type',6)->get();
            return response()->json([
                'type' => 3,
                'disco' => $discount_main_data,
            ]);
        }

    }
    protected function ajax_get_foc(Request $request)
    {
        $discounts = Discount::where('discount_main_id',$request->dismain_id)->get();
        return response()->json($discounts);
    }
    protected function ajax_get_item(Request $request)
    {
        $discounts = Discount::where('discount_main_id',$request->dismain_id)->get();
        return response()->json($discounts);
    }
    protected function ajax_get_vou(Request $request)
    {
        $discounts = Discount::where('discount_main_id',$request->dismain_id)->get();
        return response()->json($discounts);
    }
    protected function search_sale_discount_record(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error('Something Wrong!');

            return redirect()->back();
        }
        $between = DiscountMain::whereBetween('voucher_date', [$request->from, $request->to])->get();
        // dd($between_vou_date);
        $discounts = Discount::all();
        $discount_main = DiscountMain::all();
        $all = 2;

        return view('Sale.sale_discount_record_list',compact('discounts','discount_main','all','between'));

    }
    
    public function validateData($request)
    {
        return  Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required',
        ]);
    }

    protected function searchSaleHistoryv2(Request $request){
        // $validator = $this->validateData($request);
        if ($this->validateData($request)->fails()) {
            alert()->error('Something Wrong!');
            return redirect()->back();
        }
        
        if($request->customer == 0 && $request->sales == 'All'){
            $saleVouchers = Voucher::whereBetween('voucher_date',[$request->from, $request->to])->get();
        }else if($request->customer == 0 && $request->sales != 'All'){
            $saleVouchers = Voucher::whereBetween('voucher_date',[$request->from, $request->to])->where('sale_by',$request->sales)->get();
        }else if($request->customer != 0 && $request->sales == 'All'){
            $saleVouchers = Voucher::whereBetween('voucher_date',[$request->from, $request->to])->where('sales_customer_id',$request->customer)->get();
        }else{
            $saleVouchers = Voucher::whereBetween('voucher_date',[$request->from, $request->to])->where('sales_customer_id',$request->customer)->where('sale_by',$request->sales)->get();
        }
        
        return response()->json($saleVouchers);
    }
    
    protected function searchSaleHistory(Request $request){

        $validator = Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error('Something Wrong!');

            return redirect()->back();
        }

        $role= $request->session()->get('user')->role;

        $from_id = 1;
        if ($request->customer){
            $voucher_lists = Voucher::where('type', 1)->where("from_id",$from_id)->whereBetween('voucher_date', [$request->from, $request->to])->where('sales_customer_id',$request->customer)->get();
        }
        $voucher_lists = Voucher::where('type', 1)->where("from_id",$from_id)->whereBetween('voucher_date', [$request->from, $request->to])->get();

        $search_sales= 0;

        foreach ($voucher_lists as $search_list){

            if($search_list->discount > 1 && is_numeric($search_list->discount)){
                $search_sales += ($search_list->total_price) - ((int) $search_list->discount);
            }
            else if ($search_list->discount == 0){
                $search_sales += $search_list->total_price;
            }
            else{
                $search_sales += 0;
            }

        }

        $voucher_lists_all = Voucher::where('type', 1)->where('from_id',$from_id)->get();

        $total_sales  = 0;

        foreach ($voucher_lists_all as $voucher_list){

            if($voucher_list->discount > 1 && is_numeric($voucher_list->discount)){
                $total_sales += ($voucher_list->total_price) - ((int) $voucher_list->discount);
            }
            else if ($voucher_list->discount == 0){
                $total_sales += $voucher_list->total_price;
            }
            else{
                $total_sales += 0;
            }

        }

        $date = new DateTime('Asia/Yangon');

        $current_date = strtotime($date->format('Y-m-d'));
        $to = $date->format('Y-m-d');


        $weekly = date('Y-m-d', strtotime('-1week', $current_date));

        $weekly_data = Voucher::where('type', 1)->where('from_id',$from_id)->whereBetween('voucher_date', [$weekly,$to])->get();

        $weekly_sales = 0;

        foreach($weekly_data as $weekly){

            if($weekly->discount > 1 && is_numeric($weekly->discount)){
                $weekly_sales += ($weekly->total_price) - ((int) $weekly->discount);
            }
            else if ($weekly->discount == 0){
                $weekly_sales += $weekly->total_price;
            }
            else{
                $weekly_sales += 0;
            }

        }

        $current_month = $date->format('m');
        $current_month_year = $date->format('Y');

        $today_date = $date->format('Y-m-d');

        $daily = Voucher::where('type', 1)->where('from_id',$from_id)->whereDate('created_at', $today_date)->get();

        $daily_sales = 0;

        foreach($daily as $day){

            if($day->discount > 1 && is_numeric($day->discount)){
                $daily_sales += ($day->total_price) - ((int) $day->discount);
            }
            else if ($day->discount == 0){
                $daily_sales += $day->total_price;
            }
            else{
                $daily_sales += 0;
            }
        }

        $monthly = Voucher::where('type', 1)->where('from_id',$from_id)->whereMonth('created_at',$current_month)->whereYear('created_at',$current_month_year)->get();

        $monthly_sales = 0;

        foreach ($monthly as $month){

            if($month->discount > 1 && is_numeric($month->discount)){
                $monthly_sales += ($month->total_price) - ((int) $month->discount);
            }
            else if ($month->discount == 0){
                $monthly_sales += $month->total_price;
            }
            else{
                $monthly_sales += 0;
            }
        }

        return view('Sale.sale_history_page',compact('voucher_lists','total_sales','daily_sales','monthly_sales','weekly_sales','search_sales'));

    }

    protected function searchItemAdjusts(Request $request){

        $validator = Validator::make($request->all(), [
            'from' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error('Something Wrong!');

            return redirect()->back();
        }

        $from = (new Carbon($request->from))->format('Y-m-d');

        $from_id= $request->session()->get('from');

        $item_adjusts = Itemadjust::where("from_id",$from_id)->whereDate('created_at',$from)->get();


        return view('Itemadjust.itemadjust',compact('item_adjusts'));

    }
    protected function getVoucherDetails(request $request, $id){
        $voucher = Voucher::find($id);

        $unit = Voucher::with('counting_unit')->with('counting_unit.stockcount')->find($id);

        return view('Sale.voucher_details', compact('unit','voucher'));
    }

    protected function getVoucherSummaryMain(){
        return view('Sale.voucher_history');
    }


    public function searchItemSalesByDate(Request $request){  // PYin Yan

        $search_date = $request->date;

        $req_date = strtotime($search_date);

        $date = date('d/F/Y', $req_date);

        $vouchers = Voucher::whereDate('created_at', $search_date)->get();

        if(count($vouchers) == 0){

            alert()->error('ယနေ့အတွက် ဘောင်ချာမရှိသေးပါ');

            return redirect()->back();
        }

        $total_sales = 0;

        $total_quantity = 0;

        $item_lists = array();

        foreach($vouchers as $voucher){

            $total_sales += $voucher->total_price;

            $total_quantity += $voucher->total_quantity;

            foreach($voucher->counting_unit as $counting_unit){

                $counting_unit_id = $counting_unit->id;

                $item_id = $counting_unit->item_id;

                $item_name = Item::find($item_id)->item_name;

                $counting_unit_name = $counting_unit->unit_name;

                $quantity = $counting_unit->pivot->quantity;

                $price = $counting_unit->pivot->price;

                $combined = array('item_id' => $item_id, 'item_name' => $item_name, 'counting_unit_id' => $counting_unit_id,'counting_unit_name' => $counting_unit_name, 'quantity' => $quantity, 'price' =>$price );

                array_push($item_lists, $combined);
            }

        }

        $items = array();

        foreach ($item_lists as $item) {

            if (!isset($result[$item['counting_unit_id']])){

                $result[$item['counting_unit_id']] = $item;
            }else{

                $result[$item['counting_unit_id']]['quantity'] += $item['quantity'];
                $result[$item['counting_unit_id']]['price'] += $item['price'];
            }
        }

        $callback = function ($object1,$object2){
            return ($object1['quantity'] > $object2['quantity']) ? 1 : 0;
        };

        $items = array_values($result);
        asort($items);

        return view('Sale.voucher_summary',compact('total_sales','total_quantity','date'));
    }



    public function searchSaleHistoryget()
    {
        return redirect()->route('sale_history');
    }
    public function voucherDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'voucher_id' => 'required',
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
            $voucher = Voucher::findOrfail($request->voucher_id);
            
            foreach($voucher->counting_unit as $unit){
                
                $balanceQty = $unit->current_quantity + $unit->pivot->quantity;
                $unit->current_quantity = $balanceQty ;
                $unit->save();
                $voucher->counting_unit()->detach($unit->id);
            }
            $deleted = DB::table('vouchers')->where('id', $request->voucher_id)->delete();

        } catch (\Exception $e) {

            return response()->json(0);

        }

        return response()->json(1);

    }
    public function subcategorySearch(Request $request){

        $category_id = $request->category_id;
        $subCategories = SubCategory::where('category_id',$category_id)->get();
        return response()->json($subCategories);

    }

    public function unitSearch(Request $request){
        $category_id = $request->category_id;
        $subcategory_id = $request->subcategory_id;
        ini_set('max_execution_time',300);
//        return $request;
        $items = Item::where("category_id",$category_id)->where("sub_category_id",$subcategory_id)->get();
        $item_ids=[];
       
            foreach ($items as $item){
                array_push($item_ids,$item->id);
            }
        
        $counting_units = CountingUnit::whereIn('item_id',$item_ids)->with('design')->with('fabric')->with('colour')->with('size')->get();
        return response()->json($counting_units);
    }

    public function saleCount(Request $reqeust,$from_date,$to_date,$order_type)
    {
        if($order_type == 'sale'){   //item_type -0
            $orderType = 0;
        }else if($order_type == 'order')
        {
            $orderType = 1;
        }

        if($orderType == 0){
        $vouchers = Voucher::whereBetween('voucher_date', [$from_date,$to_date])->get();

        }else if($orderType == 1){
            $vouchers = OrderVoucher::whereBetween('voucher_date', [$from_date,$to_date])->get();
        }

        if($vouchers->isEmpty()){
            $items = [];
            $item_worst_sell_10 = [];
            $item_best_sell_10 = [];
        }else{

        $total_quantity = 0;


        $item_lists = array();

        if($orderType == 0){
        foreach($vouchers as $voucher){

            $total_quantity += $voucher->total_quantity;

            foreach($voucher->counting_unit as $unit){

                $item_id = $unit->id;

                $item_name = $unit->unit_name;

                $item_code = $unit->unit_code;

                $quantity = $unit->pivot->quantity;

                $price = $unit->order_price;



                $combined = array('item_id' => $item_id, 'item_name' => $item_name, 'item_code' => $item_code,'quantity' => $quantity,'price' => $price );

                array_push($item_lists, $combined);
            }

        }
        }

        $items = array();

        foreach ($item_lists as $item) {

            if (!isset($result[$item['item_id']]))

                $result[$item['item_id']] = $item;

            else

                $result[$item['item_id']]['quantity'] += $item['quantity'];
        }

        $items =  array_values($result);

        $price = array_column($result, 'quantity');
        $priceDESCSort = array_multisort($price, SORT_DESC, $result);
        $items = $result;

        $priceASCSort = array_multisort($price, SORT_ASC, $result);
        $itemsASC = $result;

        $item_best_sell_10 =[];
        foreach($items as $key=>$item){
            array_push($item_best_sell_10,$item);
            if($key==9){
               break;
            }
        }

        $item_worst_sell_10 =[];
       foreach($itemsASC as $key=>$item){
           array_push($item_worst_sell_10,$item);
           if($key==9){
              break;
           }
       }
    }


        return view('Sale.total_item_sale',compact('items','item_best_sell_10','item_worst_sell_10','from_date','to_date','order_type'));
    }


//    public function categorySearch(Request $request){
////        return response()->json($request->category_id);
//
//        $category_id = $request->category_id;
//        $froms=From::find(1);
//        $items = $froms->items()->where('category_id',$category_id)->with('category')->with('counting_units')->with("counting_units.stockcount")->with('sub_category')->get();
//        // $items = Item::with('counting_units')->get();
//
//        $categories = Category::where('id',$category_id)->get();
//
//        $sub_categories = SubCategory::all();
//
//        $customers = Customer::all();
//
//        $employees = Employee::all();
//
//        $date = new DateTime('Asia/Yangon');
//
//        $today_date = strtotime($date->format('d-m-Y H:i'));
//        $last_voucher = Voucher::get()->last();
//
//        $voucher_code =  "VOU-".date('dmY')."-".sprintf("%04s", ($last_voucher->id + 1));
//        $salescustomers = SalesCustomer::all();
//        return view('Sale.sale_page',compact('voucher_code','items','categories','customers','employees','today_date','sub_categories','salescustomers'));
//
//
//    }
}
