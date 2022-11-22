<?php

namespace App\Http\Controllers\Web;

use App\From;
use App\BankAccount;
use App\Transaction;
use App\Item;
use App\Income;
use App\User;
use DateTime;
use App\Order;

use App\Expense;
use App\Voucher;
use App\OrderVoucher;
use App\Category;
use App\SubCategory;
use App\FactoryItem;
use App\FactoryPo;
use App\Customer;
use App\Employee;
use App\Purchase;
use App\Supplier;
use App\PayCredit;
use Carbon\Carbon;
use App\FixedAsset;
use App\Stockcount;
use App\Itemrequest;
use App\CountingUnit;
use App\SalesCustomer;
use App\OrderCustomer;
use App\ShareholderList;
use App\SupplierPayCredit;
use App\Capitaltransaction;
use App\GeneralInformation;
use App\SupplierCreditList;
use App\Imports\ItemsImport;
use Illuminate\Http\Request;
use App\SaleCustomerCreditlist;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
//use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\SaleCustomerList;
use Exception;
use PhpParser\Node\Stmt\TryCatch;
use Maatwebsite\Excel\Excel;
use App\Exports\ReceivePayHistoryExport;
use App\Exports\ExpenseHistoryExport;

class AdminController extends Controller {
    
    private $excel;


    public function __construct(Excel $excel){
        $this->excel = $excel;
    }

    protected function getAdminDashboard(){

	   return view('Admin.admin_panel');
	}

    public function viewWebsiteUser() {
        $website_users = DB::table('website_user')->get();
        
        return view('Admin.website_users',compact('website_users'));

    }

    public function viewOrderDetailList($id) {

        $instock_orders = DB::table('ecommerce_orders')->where('customer_id', $id)->where('order_type', 1)->get();
        $preorder_orders = DB::table('ecommerce_orders')->where('customer_id', $id)->where('order_type', 2)->get();
        
        return view('Admin.order_detail_list',compact('instock_orders', 'preorder_orders'));

    }

	protected function expenseList(request $request){

	    $expenses = Expense::all();

	    return view('Admin.expense', compact('expenses'));
	}

	protected function storeExpense(request $request){

	       $validator = Validator::make($request->all(), [
            "type" => "required",
            "title" => "required",
            "description" => "required",
            "amount" => "required",
            "profit_loss_flag" => "required",

        ]);

        if($validator->fails()){

            alert()->error('အချက်အလက် များ မှားယွင်း နေပါသည်။');

            return redirect()->back();
        }

        $item = Expense::create([
                'type' => $request->type,
                'period' => $request->period,
                'date' => $request->date,
                'title' => $request->title,
                'description' => $request->description,
                'amount' => $request->amount,
                'profit_loss_flag' => $request->profit_loss_flag,
        ]);

        return redirect()->back();
	}
	
	protected function updateExpense($id, Request $request)
	{
		try {

        	$expense = Expense::findOrFail($id);

   		} catch (\Exception $e) {

        	alert()->error("Expense Not Found!")->persistent("Close!");

            return redirect()->back();

    	}

        $expense->type = $request->type;

        $expense->period = $request->period;
        
        $expense->date = $request->date;

        $expense->title = $request->title;
        
        $expense->description = $request->description;
        
        $expense->amount = $request->amount;
        
        $expense->profit_loss_flag = $request->profit_loss_flag;
        
        $expense->save();

        alert()->success('Successfully Updated!');

        return redirect()->route('expenses');
	}

	protected function deleteExpense(Request $request)
	{
		

        $expense = Expense::find($request->expense_id);
        
        $expense->delete();

        alert()->success('Successfully Deleted!');

        return redirect()->route('expenses');
	}
	
	protected function expenseHistoryExport(Request $request,$from,$to){
        return $this->excel->download(new ExpenseHistoryExport($from,$to),'expense_history.xlsx');
    }
    
    protected function searchExpenseHistory(Request $request){
        // $validator = $this->validateData($request);
        // if ($this->validateData($request)->fails()) {
        //     alert()->error('Something Wrong!');
        //     return redirect()->back();
        // }
        
        
        $expenses = Expense::whereBetween('date',[$request->from, $request->to])->get();
       
        
        return response()->json($expenses);
    }
	
	protected function incomeList(request $request){

	    $incomes = Income::all();

	    return view('Admin.income', compact('incomes'));
	}
	
	protected function storeIncome(request $request){

        $validator = Validator::make($request->all(), [
         "type" => "required",
         "title" => "required",
         "description" => "required",
         "amount" => "required",
         "profit_loss_flag" => "required",

     ]);

     if($validator->fails()){

         alert()->error('အချက်အလက် များ မှားယွင်း နေပါသည်။');

         return redirect()->back();
     }

     $item = Income::create([
             'type' => $request->type,
             'period' => $request->period,
             'date' => $request->date,
             'title' => $request->title,
             'description' => $request->description,
             'amount' => $request->amount,
             'profit_loss_flag' => $request->profit_loss_flag,
     ]);

     return redirect()->back();
 }
 
 protected function updateIncome($id, Request $request)
	{
		try {

        	$income = Income::findOrFail($id);

   		} catch (\Exception $e) {

        	alert()->error("Income Not Found!")->persistent("Close!");

            return redirect()->back();

    	}

        $income->type = $request->type;

        $income->period = $request->period;
        
        $income->date = $request->date;

        $income->title = $request->title;
        
        $income->description = $request->description;
        
        $income->amount = $request->amount;
        
        $income->profit_loss_flag = $request->profit_loss_flag;
        
        $income->save();

        alert()->success('Successfully Updated!');

        return redirect()->route('incomes');
	}

	protected function deleteIncome(Request $request)
	{
		

        $income = Income::find($request->income_id);
        
        $income->delete();

        alert()->success('Successfully Deleted!');

        return redirect()->route('incomes');
	}
 
 protected function getReceivablePayable(Request $request){
     $date = new DateTime('Asia/Yangon');
        $current_Date = $date->format('Y-m-d');
        
        $name = $request->session()->get('user')->name;
     $orders = Order::whereBetween('order_date',[$current_Date,$current_Date])->whereNotIn('customer_id',[53,54,100,141,173,174,196,213,218,248])->get();
     
     $unpaid_orders = [];
     if($orders != null){
         foreach($orders as $order){
             if($order->advance_pay < $order->est_price){
                 $unpaid_order = [
                    'order_id' =>$order->id,
                    'order_code' => $order->order_number,
                    'order_date' => $order->order_date,
                    'order_status' => $order->status,
                    'customer_id' => $order->customer_id,
                    'customer_name' => $order->name,
                    'customer_phone' => $order->phone,
                    'total_amount' => $order->est_price,
                    'paid_amount' => $order->advance_pay,
                    'discount_amount' => $order->total_discount_value,
                ];
                array_push($unpaid_orders,$unpaid_order);
             }
         }
     }
     
     $purchases = Purchase::whereBetween('purchase_date',[$current_Date,$current_Date])->get();
     
     $credit_purchases = [];
     if($purchases != null){
         foreach($purchases as $purchase){
             if($purchase->credit_amount > 0){
                 $repayments = SupplierPayCredit::where('purchase_id',$purchase->id)->get();
                 $total_repay_amount = 0;
                 foreach($repayments as $repayment){
                     $total_repay_amount += $repayment->pay_amount;
                 }
                 $credit_purchase = [
                    'purchase_id' =>$purchase->id,
                    'purchase_code' => $purchase->purchase_number,
                    'purchase_date' => $purchase->purchase_date,
                    'purchase_type' => $purchase->purchase_type,
                    'supplier_id' => $purchase->supplier_id,
                    'supplier_name' => $purchase->supplier_name,
                    'total_amount' => $purchase->total_price,
                    'credit_amount' => $purchase->credit_amount,
                    'total_repay_amount' => $total_repay_amount
                ];
                array_push($credit_purchases,$credit_purchase);
             }
         }
     }
     
     $customers = OrderCustomer::all();
     $suppliers = Supplier::all();
     
     return view('Admin.receivable_payable',compact('unpaid_orders','credit_purchases','current_Date','customers','suppliers','name'));
 }
 
 protected function getTransactionVouchersv2(Request $request){

        $date = new DateTime('Asia/Yangon');
        
        $current_Date = $date->format('Y-m-d');

        $name = $request->session()->get('user')->name;
        
            $bank_Ids= BankAccount::get()->pluck('id')->toArray();

            $transactions_lists=[];
            $transactions = Transaction::whereIn('bank_acc_id',$bank_Ids)->whereBetween('tran_date', [$current_Date,$current_Date])->get();
            if($transactions != null){
                foreach($transactions as $transaction){
                    $bank_acc = BankAccount::findOrFail($transaction->bank_acc_id);
                    $order= Order::findOrFail($transaction->order_id);
                    $transaction_final = [
                        'order_id' => $transaction->order_id,
                        'order_code' => $order->order_number,
                        'order_date' => $order->order_date,
                        'customer_name' => $order->name,
                        'customer_phone' => $order->phone,
                        'bank_acc_id' => $transaction->bank_acc_id,
                        'bank_name' => $bank_acc->bank_name,
                        'account_number' => $bank_acc->account_number,
                        'account_holder_name' => $bank_acc->account_holder_name,
                        'tran_date' => $transaction->tran_date,
                        'pay_amount'=> $transaction->pay_amount,
                        'remark' => $transaction->remark,
                    ];
                    array_push($transactions_lists,$transaction_final);
                }
                
            }
            // $voucher_lists =Voucher::where('order_date',$current_Date)->orderBy('id','desc')->with('items')->with('items.purchases')->get();
            // dd($voucher_lists);
   

        $order_lists = [];
        $transactions = Transaction::where('tran_date',$current_Date)->get();
        foreach($transactions as $transaction){
            array_push($order_lists,$transaction->order);
        }

        //    dd($transactions_lists[0]['voucher_code']);
        $bank_accs = BankAccount::all();
        
        return view('Admin.transaction_listv2',compact('order_lists','transactions_lists','current_Date','bank_accs','name'));
    }
    
    protected function search_transactions_bydatev2(Request $request){

        
        $transactions_lists=[];
    
        
        
            if($request->value==0){
                $bank_Id= BankAccount::get()->pluck('id')->toArray();
            }else{
                $bank_Id= array($request->value);
            }
                $transactions = Transaction::whereIn('bank_acc_id',$bank_Id)->whereBetween('tran_date', [$request->from,$request->to])->get();
                 if($transactions != null){
                     
                         foreach($transactions as $transaction){
                             $bank_acc = BankAccount::findOrFail($transaction->bank_acc_id);
                             $order= Order::findOrFail($transaction->order_id);
                             
                             $transaction_final = [
                                 "order_id" => $transaction->order_id,
                                 "order_code" => $order->order_number,
                                 "order_date" => $order->order_date,
                                "customer_name" => $order->name,
                                "customer_phone" => $order->phone,
                                "bank_acc_id" => $transaction->bank_acc_id,
                                 "bank_name" => $bank_acc->bank_name,
                                 "account_number" => $bank_acc->account_number,
                                 "account_holder_name" => $bank_acc->account_holder_name,
                                 "tran_date" => $transaction->tran_date,
                                
                                 "pay_amount"=> $transaction->pay_amount,
                                 "remark" => $transaction->remark
                             ];
                            array_push($transactions_lists,$transaction_final);
                        }
                    }
            

        return response()->json($transactions_lists);
    }
    
    protected function search_receivable_bydate(Request $request){

        $unpaid_orders=[];
    
        if($request->value==0){
            $customer_id= OrderCustomer::get()->pluck('id')->toArray();
        }else{
            $customer_id= array($request->value);
        }
         $orders = Order::whereIn('customer_id',$customer_id)->whereBetween('order_date', [$request->from,$request->to])->whereNotIn('customer_id',[53,54,100,141,173,174,196,213,218,248])->get();
                 
                     
        if($orders != null){
            foreach($orders as $order){
                if($order->advance_pay < $order->est_price){
                    $unpaid_order = [
                        'order_id' =>$order->id,
                        'order_code' => $order->order_number,
                        'order_date' => $order->order_date,
                        'order_status' => $order->status,
                        'customer_id' => $order->customer_id,
                        'customer_name' => $order->name,
                        'customer_phone' => $order->phone,
                         'total_amount' => $order->est_price,
                        'paid_amount' => $order->advance_pay,
                        'discount_amount' => $order->total_discount_value,
                    ];
                    array_push($unpaid_orders,$unpaid_order);
                }
            }
        }
        return response()->json($unpaid_orders);
    }
    
    protected function search_payable_bydate(Request $request){

        
        $credit_purchases=[];
    
        if($request->value==0){
            $supplier_id= Supplier::get()->pluck('id')->toArray();
        }else{
            $supplier_id= array($request->value);
        }
        
        $purchases = Purchase::whereIn('supplier_id',$supplier_id)->whereBetween('purchase_date', [$request->from,$request->to])->get();
        if($purchases != null){
            foreach($purchases as $purchase){
                if($purchase->credit_amount > 0){
                    $repayments = SupplierPayCredit::where('purchase_id',$purchase->id)->get();
                 $total_repay_amount = 0;
                 foreach($repayments as $repayment){
                     $total_repay_amount += $repayment->pay_amount;
                 }
                    $credit_purchase = [
                    'purchase_id' =>$purchase->id,
                    'purchase_code' => $purchase->purchase_number,
                    'purchase_date' => $purchase->purchase_date,
                    'purchase_type' => $purchase->purchase_type,
                    'supplier_id' => $purchase->supplier_id,
                    'supplier_name' => $purchase->supplier_name,
                    'total_amount' => $purchase->total_price,
                    'credit_amount' => $purchase->credit_amount,
                    'total_repay_amount' => $total_repay_amount
                    ];
                    array_push($credit_purchases,$credit_purchase);
                }
            }
        }
        return response()->json($credit_purchases);
    }
    
    protected function receivableHistoryExport(Request $request,$from,$to,$id){
        return $this->excel->download(new ReceivePayHistoryExport($from,$to,$id,1),'receivable_history.xlsx');
    }
    
    protected function payableHistoryExport(Request $request,$from,$to,$id){
        return $this->excel->download(new ReceivePayHistoryExport($from,$to,$id,2),'payable_history.xlsx');
    }
 
 protected function getTotalSaleReport(Request $request){

        $type = $request->type;

        $from_date = $request->from_date;

        $to_date = $request->to_date;

        $total_sales = 0;
        
        $total_order = 0;

        $total_profit = 0;

        $other_income = 0;

        $other_expense = 0;
        
        $total_purchase = 0;
        
        $total_transaction = 0;

        if($type == 1){

            $daily = date('Y-m-d', strtotime($request->value));

            $voucher_lists = Voucher::whereDate('voucher_date', $daily)->get();
            
            $order_lists = Order::whereDate('order_date',$daily)->get();
            
            $other_incomes = Income::whereDate('date',$daily)->orWhere('type', 1)->get();

            foreach($other_incomes as $other){
                if($other->type == 1 && $other->period == 1){
                    $other_income += $other->amount;
                }
                else if($other->type == 1 && $other->period == 2){
                    $other_income += (int)($other->amount/7);
                }
                else if($other->type == 1 && $other->period == 3){
                    $other_income += (int)($other->amount/30);
                }
                else{
                    $other_income += $other->amount;
                }
            }

            $other_expenses = Expense::whereDate('date',$daily)
                                        ->orWhere('type', 1)->get();

            foreach($other_expenses as $other){
                if($other->type == 1 && $other->period == 1){
                    $other_expense += $other->amount;
                }
                else if($other->type == 1 && $other->period == 2){
                    $other_expense += (int)($other->amount/7);
                }
                else if($other->type == 1 && $other->period == 3){
                    $other_expense += (int)($other->amount/30);
                }
                else{
                    $other_expense += $other->amount;
                }
            }
            
            
            $purchase_lists = Purchase::whereDate('purchase_date',$daily)->where('purchase_type',2)->get();
            
            foreach($purchase_lists as $purchae){
                $total_purchase += $purchae->total_price;
            }
            
            $transaction_lists = Transaction::whereDate('tran_date',$daily)->get();
            
            foreach($transaction_lists as $transaction){
                $total_transaction += $transaction->pay_amount;
            }

            $date_fil_lists = Voucher::whereBetween('voucher_date',[$from_date,$to_date])->get();

        }
        elseif($type == 2){

            $week_count = $request->value;

            $start_month = date('Y-m-d',strtotime('first day of this month'));

            if ($week_count == 1) {

                $end_date = date('Y-m-d', strtotime("+1 week" , strtotime($start_month)));

                $voucher_lists = Voucher::whereBetween('voucher_date', [$start_month, $end_date])->get();
                
                $order_lists = Order::whereBetween('order_date', [$start_month, $end_date])->get();

                $other_incomes = Income::whereBetween('date', [$start_month, $end_date])->orWhere('type', 1)->get();

                $other_expenses = Expense::whereBetween('date', [$start_month, $end_date])
                                            ->orWhere('type', 1)->get();
                                            
                $purchase_lists = Purchase::whereBetween('purchase_date', [$start_month, $end_date])->where('purchase_type',2)->get();
            
            
            $transaction_lists = Transaction::whereBetween('tran_date', [$start_month, $end_date])->get();
            
           

                $date_fil_lists = Voucher::whereBetween('voucher_date', [$start_month, $end_date])
                                        ->whereBetween('voucher_date',[$from_date,$to_date])->get();
                // $date_fil_lists = Voucher::whereBetween('voucher_date', [$from_date,$to_date])->get();

            } elseif ($week_count == 2) {

                $start_date = date('Y-m-d', strtotime("+1 week" , strtotime($start_month)));

                $end_date = date('Y-m-d', strtotime("+2 week" , strtotime($start_month)));

                $voucher_lists = Voucher::whereBetween('voucher_date', [$start_date, $end_date])->get();
                
                $order_lists = Order::whereBetween('order_date', [$start_date, $end_date])->get();

                $other_incomes = Income::whereBetween('date', [$start_date, $end_date])->orWhere('type', 1)->get();

                $other_expenses = Expense::whereBetween('date', [$start_date, $end_date])
                                            ->orWhere('type', 1)->get();
                                            
                $purchase_lists = Purchase::whereBetween('purchase_date', [$start_date, $end_date])->where('purchase_type',2)->get();
            
            
            $transaction_lists = Transaction::whereBetween('tran_date', [$start_date, $end_date])->get();
            

                $date_fil_lists = Voucher::whereBetween('voucher_date', [$start_date, $end_date])
                                           ->whereBetween('voucher_date',[$from_date,$to_date])->get();

            } elseif ($week_count == 3) {

                $start_date = date('Y-m-d', strtotime("+2 week" , strtotime($start_month)));

                $end_date = date('Y-m-d', strtotime("+3 week" , strtotime($start_month)));

                $voucher_lists = Voucher::whereBetween('voucher_date', [$start_date, $end_date])->get();
                
                 $order_lists = Order::whereBetween('order_date', [$start_date, $end_date])->get();

                $other_incomes = Income::whereBetween('date', [$start_date, $end_date])->orWhere('type', 1)->get();

                $other_expenses = Expense::whereBetween('date', [$start_date, $end_date])
                                            ->orWhere('type', 1)->get();
                                            
                $purchase_lists = Purchase::whereBetween('purchase_date', [$start_date, $end_date])->where('purchase_type',2)->get();
            
            
            $transaction_lists = Transaction::whereBetween('tran_date', [$start_date, $end_date])->get();
            

                $date_fil_lists = Voucher::whereBetween('voucher_date', [$start_month, $end_date])
                                           ->whereBetween('voucher_date',[$from_date,$to_date])->get();

            } else {

                $start_date = date('Y-m-d', strtotime("+3 week" , strtotime($start_month)));

                $end_date = date('Y-m-d',strtotime('last day of this month'));

                $voucher_lists = Voucher::whereBetween('voucher_date', [$start_date, $end_date])->get();
                
                 $order_lists = Order::whereBetween('order_date', [$start_date, $end_date])->get();

                $other_incomes = Income::whereBetween('date', [$start_date, $end_date])->orWhere('type', 1)->get();

                $other_expenses = Expense::whereBetween('date', [$start_date, $end_date])
                                            ->orWhere('type', 1)->get();
                                            
                $purchase_lists = Purchase::whereBetween('purchase_date', [$start_date, $end_date])->where('purchase_type',2)->get();
            
            
            $transaction_lists = Transaction::whereBetween('tran_date', [$start_date, $end_date])->get();
            

                $date_fil_lists = Voucher::whereBetween('voucher_date', [$start_month, $end_date])
                                           ->whereBetween('voucher_date',[$from_date,$to_date])->get();
            }

            foreach($other_incomes as $other){
                if($other->type == 1 && $other->period == 1){
                    $other_income += $other->amount * 7;
                }
                else if($other->type == 1 && $other->period == 2){
                    $other_income += $other->amount;
                }
                else if($other->type == 1 && $other->period == 3){
                    $other_income += (int)($other->amount/4);
                }
                else{
                    $other_income += $other->amount;
                }
            }

            foreach($other_expenses as $other){
                if($other->type == 1 && $other->period == 1){
                    $other_expense += $other->amount * 7;
                }
                else if($other->type == 1 && $other->period == 2){
                    $other_expense += $other->amount;
                }
                else if($other->type == 1 && $other->period == 3){
                    $other_expense += (int)($other->amount/4);
                }
                else{
                    $other_expense += $other->amount;
                }
            }
            
            foreach($purchase_lists as $purchae){
                $total_purchase += $purchae->total_price;
            }
            
            
            foreach($transaction_lists as $transaction){
                $total_transaction += $transaction->pay_amount;
            }

        }
        else{

            $monthly = $request->value;

            $voucher_lists = Voucher::whereMonth('voucher_date', $monthly)->get();
            
             $order_lists = Order::whereMonth('order_date', $monthly)->get();

            $other_incomes = Income::whereMonth('date', $monthly)->orWhere('type', 1)->get();

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

            $other_expenses = Expense::whereMonth('date', $monthly)
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
            
             $purchase_lists = Purchase::whereMonth('purchase_date', $monthly)->where('purchase_type',2)->get();
            
            foreach($purchase_lists as $purchae){
                $total_purchase += $purchae->total_price;
            }
            
            $transaction_lists = Transaction::whereMonth('tran_date', $monthly)->get();
            
            foreach($transaction_lists as $transaction){
                $total_transaction += $transaction->pay_amount;
            }

            $date_fil_lists = Voucher::whereBetween('voucher_date',[$from_date,$to_date])->get();
        }


        if($from_date == null){
            foreach ($voucher_lists as $lists) {

                $total_sales += $lists->total_price;

                foreach ($lists->counting_unit as $unit) {

                    $total_profit += ($unit->pivot->price * $unit->pivot->quantity) - ($unit->purchase_price * $unit->pivot->quantity);
                }

            }


        }else{
            foreach ($date_fil_lists as $lists) {

                $total_sales += $lists->total_price;

                foreach ($lists->counting_unit as $unit) {

                    $total_profit += ($unit->pivot->price * $unit->pivot->quantity) - ($unit->purchase_price * $unit->pivot->quantity);
                }

            }

        }
        
        foreach($order_lists as $order){
            $total_order += $order->est_price;
        }


        return response()->json([
            "total_sales" => $total_sales,
            "total_order" => $total_order,
            "total_profit" => $total_profit,
            "total_purchase" => $total_purchase,
            "total_transaction" => $total_transaction,
            "voucher_lists" => $voucher_lists,
            "order_lists" => $order_lists,
            "purchase_lists" => $purchase_lists,
            "transaction_lists" => $transaction_lists,
            "other_incomes" => $other_income,
            "other_expenses" => $other_expense,
            "date_fil_lists" => $date_fil_lists,
        ]);
    }
    
    protected function getTotalMonth(Request $request)
	{
		
		$date =$request->receive_month . '-01';
		
           $firstdate = Carbon::parse($date)->firstOfMonth()->format('Y-m-d');
		
        $first_week = Carbon::parse($firstdate)->addDays(6)->format('Y-m-d');
		$second_week = Carbon::parse($first_week)->addDays(6)->format('Y-m-d');
		$third_week = Carbon::parse($second_week)->addDays(6)->format('Y-m-d');
		$last_week = Carbon::parse($third_week)->endOfMonth()->format('Y-m-d');
		
		
		$first_week_salevouchers = Voucher::whereBetween('voucher_date', [$firstdate, $first_week])->get();
 		$second_week_salevouchers = Voucher::whereBetween('voucher_date', [$first_week, $second_week])->get();
 		$third_week_salevouchers = Voucher::whereBetween('voucher_date', [$second_week, $third_week])->get();
 		$fourth_week_salevouchers = Voucher::whereBetween('voucher_date', [$third_week, $last_week])->get();
		
		$first_week_orders = Order::whereBetween('order_date', [$firstdate, $first_week])->get();
 		$second_week_orders = Order::whereBetween('order_date', [$first_week, $second_week])->get();
 		$third_week_orders = Order::whereBetween('order_date', [$second_week, $third_week])->get();
 		$fourth_week_orders = Order::whereBetween('order_date', [$third_week, $last_week])->get();
		
		$first_week_salesamt = 0;
 		$second_week_salesamt = 0;
 		$third_week_salesamt = 0;
 		$fourth_week_salesamt = 0;
		
		$first_week_ordersamt = 0;
 		$second_week_ordersamt = 0;
 		$third_week_ordersamt = 0;
 		$fourth_week_ordersamt = 0;
		
		
		foreach($first_week_salevouchers as $voucher){
		    $first_week_salesamt += $voucher->total_price;
		}
		
		foreach($first_week_orders as $order){
		    $first_week_ordersamt += $order->est_price;
		}
		
		
		foreach($second_week_salevouchers as $voucher){
		    $second_week_salesamt += $voucher->total_price;
		}
		
		foreach($second_week_orders as $order){
		    $second_week_ordersamt += $order->est_price;
		}
// 		//Third Week
	    foreach($third_week_salevouchers as $voucher){
		    $third_week_salesamt += $voucher->total_price;
		}
		
		foreach($third_week_orders as $order){
		    $third_week_ordersamt += $order->est_price;
		}
// 		//last Week
		foreach($fourth_week_salevouchers as $voucher){
		    $fourth_week_salesamt += $voucher->total_price;
		}
		
		foreach($fourth_week_orders as $order){
		    $fourth_week_ordersamt += $order->est_price;
		}
		
		// dd($firstdate."--->".$first_week."-->".$second_week."-->".$third_week);
		return response()->json([
			"first_week_salesamt" => $first_week_salesamt,
			"first_week_ordersamt" => $first_week_ordersamt,
			"second_week_salesamt" => $second_week_salesamt,
			"second_week_ordersamt" => $second_week_ordersamt,
 			"third_week_salesamt" => $third_week_salesamt,
 			"third_week_ordersamt" => $third_week_ordersamt,
 			"fourth_week_salesamt" => $fourth_week_salesamt,
 			"fourth_week_ordersamt" => $fourth_week_ordersamt,
		]);
		
	}
	
	 protected function getTotalWeek(Request $request)
	{
	    $week = $request->receive_week;
		$weekStartDate = Carbon::parse($request->receive_week)->startOfWeek()->format('Y-m-d');
		$weekEndDate = Carbon::parse($request->receive_week)->endOfWeek()->format('Y-m-d');

		$two_day = Carbon::parse($weekStartDate)->addDays(1)->format('Y-m-d');
		$three_day = Carbon::parse($two_day)->addDays(1)->format('Y-m-d');
		$four_day = Carbon::parse($three_day)->addDays(1)->format('Y-m-d');
		$five_day = Carbon::parse($four_day)->addDays(1)->format('Y-m-d');
		$six_day = Carbon::parse($five_day)->addDays(1)->format('Y-m-d');
		$seven_day = Carbon::parse($six_day)->addDays(1)->format('Y-m-d');
		
		$firstday_sales = Voucher::where('voucher_date',$weekStartDate)->get();
		$secondday_sales = Voucher::where('voucher_date',$two_day)->get();
		$thirdday_sales = Voucher::where('voucher_date',$three_day)->get();
		$fourthday_sales = Voucher::where('voucher_date',$four_day)->get();
		$fifthday_sales = Voucher::where('voucher_date',$five_day)->get();
		$sixthday_sales = Voucher::where('voucher_date',$six_day)->get();
		$seventhday_sales = Voucher::where('voucher_date',$seven_day)->get();
		
		$firstday_orders = Order::where('order_date',$weekStartDate)->get();
		$secondday_orders = Order::where('order_date',$two_day)->get();
		$thirdday_orders = Order::where('order_date',$three_day)->get();
		$fourthday_orders = Order::where('order_date',$four_day)->get();
		$fifthday_orders = Order::where('order_date',$five_day)->get();
		$sixthday_orders = Order::where('order_date',$six_day)->get();
		$seventhday_orders = Order::where('order_date',$seven_day)->get();
		
		$firstday_sales_amt = 0;
		$secondday_sales_amt = 0;
		$thirdday_sales_amt = 0;
		$fourthday_sales_amt = 0;
		$fifthday_sales_amt = 0;
		$sixthday_sales_amt = 0;
		$seventhday_sales_amt = 0;
		
			$firstday_orders_amt = 0;
		$secondday_orders_amt = 0;
		$thirdday_orders_amt = 0;
		$fourthday_orders_amt = 0;
		$fifthday_orders_amt = 0;
		$sixthday_orders_amt = 0;
		$seventhday_orders_amt = 0;
		
		foreach($firstday_sales as $voucher){
		    $firstday_sales_amt += $voucher->total_price;
		}
		
		foreach($firstday_orders as $order){
		    $firstday_orders_amt += $order->est_price;
		}
		
		foreach($secondday_sales as $voucher){
		    $secondday_sales_amt += $voucher->total_price;
		}
		
		foreach($secondday_orders as $order){
		    $secondday_orders_amt += $order->est_price;
		}
		
		foreach($thirdday_sales as $voucher){
		    $thirdday_sales_amt += $voucher->total_price;
		}
		
		foreach($thirdday_orders as $order){
		    $thirdday_orders_amt += $order->est_price;
		}
		
		foreach($fourthday_sales as $voucher){
		    $fourthday_sales_amt += $voucher->total_price;
		}
		
		foreach($fourthday_orders as $order){
		    $fourthday_orders_amt += $order->est_price;
		}
		
		foreach($fifthday_sales as $voucher){
		    $fifthday_sales_amt += $voucher->total_price;
		}
		
		foreach($fifthday_orders as $order){
		    $fifthday_orders_amt += $order->est_price;
		}
		
		foreach($sixthday_sales as $voucher){
		    $sixthday_sales_amt += $voucher->total_price;
		}
		
		foreach($sixthday_orders as $order){
		    $sixthday_orders_amt += $order->est_price;
		}
		
		foreach($seventhday_sales as $voucher){
		    $seventhday_sales_amt += $voucher->total_price;
		}
		
		foreach($seventhday_orders as $order){
		    $seventhday_orders_amt += $order->est_price;
		}
		
		return response()->json([
		    "first_day" => $weekStartDate,
		    "second_day" => $two_day,
		    "third_day" => $three_day,
		    "fourth_day" => $four_day,
		    "fifth_day" => $five_day,
		    "sixth_day" => $six_day,
		    "seventh_day" => $seven_day,
		    "firstday_sales_amt" => $firstday_sales_amt,
		    "firstday_orders_amt" => $firstday_orders_amt,
		    "secondday_sales_amt" => $secondday_sales_amt,
		    "secondday_orders_amt" => $secondday_orders_amt,
		    "thirdday_sales_amt" => $thirdday_sales_amt,
		    "thirdday_orders_amt" => $thirdday_orders_amt,
		    "fourthday_sales_amt" => $fourthday_sales_amt,
		    "fourthday_orders_amt" => $fourthday_orders_amt,
		    "fifthday_sales_amt" => $fifthday_sales_amt,
		    "fifthday_orders_amt" => $fifthday_orders_amt,
		    "sixthday_sales_amt" => $sixthday_sales_amt,
		    "sixthday_orders_amt" => $sixthday_orders_amt,
		    "seventhday_sales_amt" => $seventhday_sales_amt,
		    "seventhday_orders_amt" => $seventhday_orders_amt,
		    ]);
	}
	
	protected function getTotalOrderFulfill(Request $request)
	{
		
		
		$jan_income = Order::whereMonth('order_date', '01')->where('status',1)->get();
		$jan_deliver = Order::whereMonth('order_date', '01')->where('status',4)->get();
		
			$feb_income = Order::whereMonth('order_date', '02')->where('status',1)->get();
		$feb_deliver = Order::whereMonth('order_date', '02')->where('status',4)->get();
		
			$mar_income = Order::whereMonth('order_date', '03')->where('status',1)->get();
		$mar_deliver = Order::whereMonth('order_date', '03')->where('status',4)->get();
		
			$apr_income = Order::whereMonth('order_date', '04')->where('status',1)->get();
		$apr_deliver = Order::whereMonth('order_date', '04')->where('status',4)->get();
		
			$may_income = Order::whereMonth('order_date', '05')->where('status',1)->get();
		$may_deliver = Order::whereMonth('order_date', '05')->where('status',4)->get();
		
			$jun_income = Order::whereMonth('order_date', '06')->where('status',1)->get();
		$jun_deliver = Order::whereMonth('order_date', '06')->where('status',4)->get();
		
		$jul_income = Order::whereMonth('order_date', '07')->where('status',1)->get();
		$jul_deliver = Order::whereMonth('order_date', '07')->where('status',4)->get();
		
			$aug_income = Order::whereMonth('order_date', '08')->where('status',1)->get();
		$aug_deliver = Order::whereMonth('order_date', '08')->where('status',4)->get();
		
			$sep_income = Order::whereMonth('order_date', '09')->where('status',1)->get();
		$sep_deliver = Order::whereMonth('order_date', '09')->where('status',4)->get();
		
			$oct_income = Order::whereMonth('order_date', '10')->where('status',1)->get();
		$oct_deliver = Order::whereMonth('order_date', '10')->where('status',4)->get();
		
			$nov_income = Order::whereMonth('order_date', '11')->where('status',1)->get();
		$nov_deliver = Order::whereMonth('order_date', '11')->where('status',4)->get();
		
			$dec_income = Order::whereMonth('order_date', '12')->where('status',1)->get();
		$dec_deliver = Order::whereMonth('order_date', '12')->where('status',4)->get();
 		
		
		
		// dd($firstdate."--->".$first_week."-->".$second_week."-->".$third_week);
		return response()->json([
			"jan_income" => count($jan_income->toArray()),
			"jan_deliver" => count($jan_deliver->toArray()),
			"feb_income" => count($feb_income->toArray()),
			"feb_deliver" => count($feb_deliver->toArray()),
			"mar_income" => count($mar_income->toArray()),
			"mar_deliver" => count($mar_deliver->toArray()),
			"apr_income" => count($apr_income->toArray()),
			"apr_deliver" => count($apr_deliver->toArray()),
			"may_income" => count($may_income->toArray()),
			"may_deliver" => count($may_deliver->toArray()),
			"jun_income" => count($jun_income->toArray()),
			"jun_deliver" => count($jun_deliver->toArray()),
			"jul_income" => count($jul_income->toArray()),
			"jul_deliver" => count($jul_deliver->toArray()),
			"aug_income" => count($aug_income->toArray()),
			"aug_deliver" => count($aug_deliver->toArray()),
			"sep_income" => count($sep_income->toArray()),
			"sep_deliver" => count($sep_deliver->toArray()),
			"oct_income" => count($oct_income->toArray()),
			"oct_deliver" => count($oct_deliver->toArray()),
			"nov_income" => count($nov_income->toArray()),
			"nov_deliver" => count($nov_deliver->toArray()),
			"dec_income" => count($dec_income->toArray()),
			"dec_deliver" => count($dec_deliver->toArray()),
		]);
		
	}
	
	protected function getTotalCashCollect(Request $request)
	{
		
		
		$jan_order = Order::whereMonth('order_date', '01')->get();
		$jan_tran = Transaction::whereMonth('tran_date', '01')->get();
		
			$feb_order = Order::whereMonth('order_date', '02')->get();
		$feb_tran = Transaction::whereMonth('tran_date', '02')->get();
		
			$mar_order = Order::whereMonth('order_date', '03')->get();
		$mar_tran = Transaction::whereMonth('tran_date', '03')->get();
		
			$apr_order = Order::whereMonth('order_date', '04')->get();
		$apr_tran = Transaction::whereMonth('tran_date', '04')->get();
		
			$may_order = Order::whereMonth('order_date', '05')->get();
		$may_tran = Transaction::whereMonth('tran_date', '05')->get();
		
			$jun_order = Order::whereMonth('order_date', '06')->get();
		$jun_tran = Transaction::whereMonth('tran_date', '06')->get();
		
			$jul_order = Order::whereMonth('order_date', '07')->get();
		$jul_tran = Transaction::whereMonth('tran_date', '07')->get();
		
			$aug_order = Order::whereMonth('order_date', '08')->get();
		$aug_tran = Transaction::whereMonth('tran_date', '08')->get();
		
			$sep_order = Order::whereMonth('order_date', '09')->get();
		$sep_tran = Transaction::whereMonth('tran_date', '09')->get();
		
			$oct_order = Order::whereMonth('order_date', '10')->get();
		$oct_tran = Transaction::whereMonth('tran_date', '10')->get();
		
			$nov_order = Order::whereMonth('order_date', '11')->get();
		$nov_tran = Transaction::whereMonth('tran_date', '11')->get();
		
			$dec_order = Order::whereMonth('order_date', '12')->get();
		$dec_tran = Transaction::whereMonth('tran_date', '12')->get();
		
			$jan_order_cash = 0;
			$jan_tran_amt = 0;
			$feb_order_cash = 0;
			$feb_tran_amt = 0;
			$mar_order_cash = 0;
			$mar_tran_amt = 0;
			$apr_order_cash = 0;
			$apr_tran_amt = 0;
			$may_order_cash = 0;
			$may_tran_amt = 0;
			$jun_order_cash = 0;
			$jun_tran_amt = 0;
			$jul_order_cash = 0;
			$jul_tran_amt = 0;
			$aug_order_cash = 0;
			$aug_tran_amt = 0;
			$sep_order_cash = 0;
			$sep_tran_amt = 0;
			$oct_order_cash = 0;
			$oct_tran_amt = 0;
			$nov_order_cash = 0;
			$nov_tran_amt = 0;
			$dec_order_cash = 0;
			$dec_tran_amt = 0;
		
		    foreach($jan_order as $order){
		        $jan_order_cash += $order->est_price;
		    }
		    
		    foreach($jan_tran as $tran){
		        $jan_tran_amt += $tran->pay_amount;
		    }
		    
		    foreach($feb_order as $order){
		        $feb_order_cash += $order->est_price;
		    }
		    
		    foreach($feb_tran as $tran){
		        $feb_tran_amt += $tran->pay_amount;
		    }
		    
		    foreach($mar_order as $order){
		        $mar_order_cash += $order->est_price;
		    }
		    
		    foreach($mar_tran as $tran){
		        $mar_tran_amt += $tran->pay_amount;
		    }
		    
		    foreach($apr_order as $order){
		        $apr_order_cash += $order->est_price;
		    }
		    
		    foreach($apr_tran as $tran){
		        $apr_tran_amt += $tran->pay_amount;
		    }
		    
		    foreach($may_order as $order){
		        $may_order_cash += $order->est_price;
		    }
		    
		    foreach($may_tran as $tran){
		        $may_tran_amt += $tran->pay_amount;
		    }
		    
		    foreach($jun_order as $order){
		        $jun_order_cash += $order->est_price;
		    }
		    
		    foreach($jun_tran as $tran){
		        $jun_tran_amt += $tran->pay_amount;
		    }
		    
		    foreach($jul_order as $order){
		        $jul_order_cash += $order->est_price;
		    }
		    
		    foreach($jul_tran as $tran){
		        $jul_tran_amt += $tran->pay_amount;
		    }
		    
		    foreach($aug_order as $order){
		        $aug_order_cash += $order->est_price;
		    }
		    
		    foreach($aug_tran as $tran){
		        $aug_tran_amt += $tran->pay_amount;
		    }
		    
		    foreach($sep_order as $order){
		        $sep_order_cash += $order->est_price;
		    }
		    
		    foreach($sep_tran as $tran){
		        $sep_tran_amt += $tran->pay_amount;
		    }
		    
		    foreach($oct_order as $order){
		        $oct_order_cash += $order->est_price;
		    }
		    
		    foreach($oct_tran as $tran){
		        $oct_tran_amt += $tran->pay_amount;
		    }
		    
		    foreach($nov_order as $order){
		        $nov_order_cash += $order->est_price;
		    }
		    
		    foreach($nov_tran as $tran){
		        $nov_tran_amt += $tran->pay_amount;
		    }
		    
		    foreach($dec_order as $order){
		        $dec_order_cash += $order->est_price;
		    }
		    
		    foreach($dec_tran as $tran){
		        $dec_tran_amt += $tran->pay_amount;
		    }
		    
		    
 		
		
		
		// dd($firstdate."--->".$first_week."-->".$second_week."-->".$third_week);
		return response()->json([
			"jan_order_cash" => $jan_order_cash,
			"jan_tran_amt" => $jan_tran_amt,
			"feb_order_cash" => $feb_order_cash,
			"feb_tran_amt" => $feb_tran_amt,
			"mar_order_cash" => $mar_order_cash,
			"mar_tran_amt" => $mar_tran_amt,
			"apr_order_cash" => $apr_order_cash,
			"apr_tran_amt" => $apr_tran_amt,
			"may_order_cash" => $may_order_cash,
			"may_tran_amt" => $may_tran_amt,
			"jun_order_cash" => $jun_order_cash,
			"jun_tran_amt" => $jun_tran_amt,
			"jul_order_cash" => $jul_order_cash,
			"jul_tran_amt" => $jul_tran_amt,
			"aug_order_cash" => $aug_order_cash,
			"aug_tran_amt" => $aug_tran_amt,
			"sep_order_cash" => $sep_order_cash,
			"sep_tran_amt" => $sep_tran_amt,
			"oct_order_cash" => $oct_order_cash,
			"oct_tran_amt" => $oct_tran_amt,
			"nov_order_cash" => $nov_order_cash,
			"nov_tran_amt" => $nov_tran_amt,
			"dec_order_cash" => $dec_order_cash,
			"dec_tran_amt" => $dec_tran_amt,
		]);
		
	}
	
	protected function getTotalSupplierRepayment(Request $request)
	{
		
		
		$jan_purchase = Purchase::whereMonth('purchase_date', '01')->get();
		$jan_paycredit = SupplierPayCredit::whereMonth('pay_date', '01')->get();
		
		$feb_purchase = Purchase::whereMonth('purchase_date', '02')->get();
		$feb_paycredit = SupplierPayCredit::whereMonth('pay_date', '02')->get();
		
		$mar_purchase = Purchase::whereMonth('purchase_date', '03')->get();
		$mar_paycredit = SupplierPayCredit::whereMonth('pay_date', '03')->get();
		
		$apr_purchase = Purchase::whereMonth('purchase_date', '04')->get();
		$apr_paycredit = SupplierPayCredit::whereMonth('pay_date', '04')->get();
		
		$may_purchase = Purchase::whereMonth('purchase_date', '05')->get();
		$may_paycredit = SupplierPayCredit::whereMonth('pay_date', '05')->get();
		
		$jun_purchase = Purchase::whereMonth('purchase_date', '06')->get();
		$jun_paycredit = SupplierPayCredit::whereMonth('pay_date', '06')->get();
		
		$jul_purchase = Purchase::whereMonth('purchase_date', '07')->get();
		$jul_paycredit = SupplierPayCredit::whereMonth('pay_date', '07')->get();
		
		$aug_purchase = Purchase::whereMonth('purchase_date', '08')->get();
		$aug_paycredit = SupplierPayCredit::whereMonth('pay_date', '08')->get();
		
		$sep_purchase = Purchase::whereMonth('purchase_date', '09')->get();
		$sep_paycredit = SupplierPayCredit::whereMonth('pay_date', '09')->get();
		
		$oct_purchase = Purchase::whereMonth('purchase_date', '10')->get();
		$oct_paycredit = SupplierPayCredit::whereMonth('pay_date', '10')->get();
		
		$nov_purchase = Purchase::whereMonth('purchase_date', '11')->get();
		$nov_paycredit = SupplierPayCredit::whereMonth('pay_date', '11')->get();
		
		$dec_purchase = Purchase::whereMonth('purchase_date', '12')->get();
		$dec_paycredit = SupplierPayCredit::whereMonth('pay_date', '12')->get();
		
			$jan_purchase_amt = 0;
			$jan_paycredit_amt = 0;
				$feb_purchase_amt = 0;
			$feb_paycredit_amt = 0;
				$mar_purchase_amt = 0;
			$mar_paycredit_amt = 0;
				$apr_purchase_amt = 0;
			$apr_paycredit_amt = 0;
				$may_purchase_amt = 0;
			$may_paycredit_amt = 0;
				$jun_purchase_amt = 0;
			$jun_paycredit_amt = 0;
				$jul_purchase_amt = 0;
			$jul_paycredit_amt = 0;
				$aug_purchase_amt = 0;
			$aug_paycredit_amt = 0;
				$sep_purchase_amt = 0;
			$sep_paycredit_amt = 0;
				$oct_purchase_amt = 0;
			$oct_paycredit_amt = 0;
				$nov_purchase_amt = 0;
			$nov_paycredit_amt = 0;
				$dec_purchase_amt = 0;
			$dec_paycredit_amt = 0;
			
		
		    foreach($jan_purchase as $purchase){
		        $jan_purchase_amt += $purchase->total_price;
		    }
		    
		    foreach($jan_paycredit as $paycredit){
		        $jan_paycredit_amt += $paycredit->pay_amount;
		    }
		    
		   foreach($feb_purchase as $purchase){
		        $feb_purchase_amt += $purchase->total_price;
		    }
		    
		    foreach($feb_paycredit as $paycredit){
		        $feb_paycredit_amt += $paycredit->pay_amount;
		    }
		    
		    foreach($mar_purchase as $purchase){
		        $mar_purchase_amt += $purchase->total_price;
		    }
		    
		    foreach($mar_paycredit as $paycredit){
		        $mar_paycredit_amt += $paycredit->pay_amount;
		    }
		    
		    foreach($apr_purchase as $purchase){
		        $apr_purchase_amt += $purchase->total_price;
		    }
		    
		    foreach($apr_paycredit as $paycredit){
		        $apr_paycredit_amt += $paycredit->pay_amount;
		    }
		    
		    foreach($may_purchase as $purchase){
		        $may_purchase_amt += $purchase->total_price;
		    }
		    
		    foreach($may_paycredit as $paycredit){
		        $may_paycredit_amt += $paycredit->pay_amount;
		    }
		    
		    foreach($jun_purchase as $purchase){
		        $jun_purchase_amt += $purchase->total_price;
		    }
		    
		    foreach($jun_paycredit as $paycredit){
		        $jun_paycredit_amt += $paycredit->pay_amount;
		    }
		    
		    foreach($jul_purchase as $purchase){
		        $jul_purchase_amt += $purchase->total_price;
		    }
		    
		    foreach($jul_paycredit as $paycredit){
		        $jul_paycredit_amt += $paycredit->pay_amount;
		    }
		    
		    foreach($aug_purchase as $purchase){
		        $aug_purchase_amt += $purchase->total_price;
		    }
		    
		    foreach($aug_paycredit as $paycredit){
		        $aug_paycredit_amt += $paycredit->pay_amount;
		    }
		    
		    foreach($sep_purchase as $purchase){
		        $sep_purchase_amt += $purchase->total_price;
		    }
		    
		    foreach($sep_paycredit as $paycredit){
		        $sep_paycredit_amt += $paycredit->pay_amount;
		    }
		    
		    foreach($oct_purchase as $purchase){
		        $oct_purchase_amt += $purchase->total_price;
		    }
		    
		    foreach($oct_paycredit as $paycredit){
		        $oct_paycredit_amt += $paycredit->pay_amount;
		    }
		    
		    foreach($nov_purchase as $purchase){
		        $nov_purchase_amt += $purchase->total_price;
		    }
		    
		    foreach($nov_paycredit as $paycredit){
		        $nov_paycredit_amt += $paycredit->pay_amount;
		    }
		    
		   foreach($dec_purchase as $purchase){
		        $dec_purchase_amt += $purchase->total_price;
		    }
		    
		    foreach($dec_paycredit as $paycredit){
		        $dec_paycredit_amt += $paycredit->pay_amount;
		    } 
		   
		    
		    
 		
		
		
		// dd($firstdate."--->".$first_week."-->".$second_week."-->".$third_week);
		return response()->json([
			"jan_purchase_amt" => $jan_purchase_amt,
			"jan_paycredit_amt" => $jan_paycredit_amt,
			"feb_purchase_amt" => $feb_purchase_amt,
			"feb_paycredit_amt" => $feb_paycredit_amt,
			"mar_purchase_amt" => $mar_purchase_amt,
			"mar_paycredit_amt" => $mar_paycredit_amt,
			"apr_purchase_amt" => $apr_purchase_amt,
			"apr_paycredit_amt" => $apr_paycredit_amt,
			"may_purchase_amt" => $may_purchase_amt,
			"may_paycredit_amt" => $may_paycredit_amt,
			"jun_purchase_amt" => $jun_purchase_amt,
			"jun_paycredit_amt" => $jun_paycredit_amt,
			"jul_purchase_amt" => $jul_purchase_amt,
			"jul_paycredit_amt" => $jul_paycredit_amt,
			"aug_purchase_amt" => $aug_purchase_amt,
			"aug_paycredit_amt" => $aug_paycredit_amt,
			"sep_purchase_amt" => $sep_purchase_amt,
			"sep_paycredit_amt" => $sep_paycredit_amt,
			"oct_purchase_amt" => $oct_purchase_amt,
			"oct_paycredit_amt" => $oct_paycredit_amt,
			"nov_purchase_amt" => $nov_purchase_amt,
			"nov_paycredit_amt" => $nov_paycredit_amt,
			"dec_purchase_amt" => $dec_purchase_amt,
			"dec_paycredit_amt" => $dec_paycredit_amt
			
		]);
		
	}

    protected function getTotalIncome(Request $request){
        $type = $request->type;
        if($type == 1){

            $daily = date('Y-m-d', strtotime($request->value));

            $income_lists = Income::whereDate('date',$daily)->orWhere('type', 1)->get();

            $expense_lists = Expense::whereDate('date',$daily)
                                    ->orWhere('type', 1)->get();
            $time = 1;
        }
        else if($type == 2){

            $week_count = $request->value;

            $start_month = date('Y-m-d',strtotime('first day of this month'));

            $time = 2;

            if ($week_count == 1) {
                $end_date = date('Y-m-d', strtotime("+1 week" , strtotime($start_month)));

                $income_lists = Income::whereBetween('date', [$start_month, $end_date])->orWhere('type', 1)->get();

                $expense_lists = Expense::whereBetween('date', [$start_month, $end_date])
                                            ->orWhere('type', 1)->get();
            }
            elseif ($week_count == 2) {

                $start_date = date('Y-m-d', strtotime("+1 week" , strtotime($start_month)));

                $end_date = date('Y-m-d', strtotime("+2 week" , strtotime($start_month)));

                $income_lists = Income::whereBetween('date', [$start_date, $end_date])->orWhere('type', 1)->get();

                $expense_lists = Expense::whereBetween('date', [$start_date, $end_date])
                                            ->orWhere('type', 1)->get();
            }
            elseif ($week_count == 3) {

                $start_date = date('Y-m-d', strtotime("+2 week" , strtotime($start_month)));

                $end_date = date('Y-m-d', strtotime("+3 week" , strtotime($start_month)));

                $income_lists = Income::whereBetween('date', [$start_date, $end_date])->orWhere('type', 1)->get();

                $expense_lists = Expense::whereBetween('date', [$start_date, $end_date])
                                            ->orWhere('type', 1)->get();
            } else {

                $start_date = date('Y-m-d', strtotime("+3 week" , strtotime($start_month)));

                $end_date = date('Y-m-d',strtotime('last day of this month'));

                $income_lists = Income::whereBetween('date', [$start_date, $end_date])->orWhere('type', 1)->get();

                $expense_lists = Expense::whereBetween('date', [$start_date, $end_date])
                                            ->orWhere('type', 1)->get();
            }

        }
        else{

            $monthly = $request->value;

            $time = 3;

            $income_lists = Income::whereMonth('date', $monthly)->orWhere('type', 1)->get();

            $expense_lists = Expense::whereMonth('date', $monthly)
                                        ->orWhere('type', 1)->get();
        }

        return response()->json([
            "income_lists" => $income_lists,
            "expense_lists" => $expense_lists,
            "time"  => $time,
        ]);
    }
    
    protected function getTotalPurchase(Request $request){
        $type = $request->type;
        if($type == 1){

            $daily = date('Y-m-d', strtotime($request->value));

            $purchase_lists = Purchase::whereDate('purchase_date',$daily)->where('purchase_type', 2)->with('supplier')->get();

            
            $time = 1;
        }
        else if($type == 2){

            $week_count = $request->value;

            $start_month = date('Y-m-d',strtotime('first day of this month'));

            $time = 2;

            if ($week_count == 1) {
                $end_date = date('Y-m-d', strtotime("+1 week" , strtotime($start_month)));

                $purchase_lists = Purchase::whereBetween('purchase_date', [$start_month, $end_date])->where('purchase_type', 2)->with('supplier')->get();

            }
            elseif ($week_count == 2) {

                $start_date = date('Y-m-d', strtotime("+1 week" , strtotime($start_month)));

                $end_date = date('Y-m-d', strtotime("+2 week" , strtotime($start_month)));

                $purchase_lists = Purchase::whereBetween('purchase_date', [$start_date, $end_date])->where('purchase_type', 2)->with('supplier')->get();

               
            }
            elseif ($week_count == 3) {

                $start_date = date('Y-m-d', strtotime("+2 week" , strtotime($start_month)));

                $end_date = date('Y-m-d', strtotime("+3 week" , strtotime($start_month)));

                $purchase_lists = Purchase::whereBetween('purchase_date', [$start_date, $end_date])->where('purchase_type', 2)->with('supplier')->get();

            } else {

                $start_date = date('Y-m-d', strtotime("+3 week" , strtotime($start_month)));

                $end_date = date('Y-m-d',strtotime('last day of this month'));

                $purchase_lists = Purchase::whereBetween('purchase_date', [$start_date, $end_date])->where('purchase_type', 2)->with('supplier')->get();

            }

        }
        else{

            $monthly = $request->value;

            $time = 3;

            $purchase_lists = Purchase::whereMonth('purchase_date', $monthly)->where('purchase_type', 2)->with('supplier')->get();

        }

        return response()->json([
            "purchase_lists" => $purchase_lists,
            "time"  => $time,
        ]);
    }
    
    protected function getTotalTransaction(Request $request){
        $type = $request->type;
        if($type == 1){

            $daily = date('Y-m-d', strtotime($request->value));

            $transaction_lists = Transaction::whereDate('tran_date',$daily)->with('order')->with('bank_account')->get();

            
            $time = 1;
        }
        else if($type == 2){

            $week_count = $request->value;

            $start_month = date('Y-m-d',strtotime('first day of this month'));

            $time = 2;

            if ($week_count == 1) {
                $end_date = date('Y-m-d', strtotime("+1 week" , strtotime($start_month)));

                $transaction_lists = Transaction::whereBetween('tran_date', [$start_month, $end_date])->with('order')->with('bank_account')->get();

            }
            elseif ($week_count == 2) {

                $start_date = date('Y-m-d', strtotime("+1 week" , strtotime($start_month)));

                $end_date = date('Y-m-d', strtotime("+2 week" , strtotime($start_month)));

                $transaction_lists = Transaction::whereBetween('tran_date', [$start_date, $end_date])->with('order')->with('bank_account')->get();

               
            }
            elseif ($week_count == 3) {

                $start_date = date('Y-m-d', strtotime("+2 week" , strtotime($start_month)));

                $end_date = date('Y-m-d', strtotime("+3 week" , strtotime($start_month)));

                $transaction_lists = Transaction::whereBetween('tran_date', [$start_date, $end_date])->with('order')->with('bank_account')->get();

            } else {

                $start_date = date('Y-m-d', strtotime("+3 week" , strtotime($start_month)));

                $end_date = date('Y-m-d',strtotime('last day of this month'));

                $transaction_lists = Transaction::whereBetween('tran_date', [$start_date, $end_date])->with('order')->with('bank_account')->get();

            }

        }
        else{

            $monthly = $request->value;

            $time = 3;

            $transaction_lists = Transaction::whereMonth('tran_date', $monthly)->with('order')->with('bank_account')->get();

        }

        return response()->json([
            "transaction_lists" => $transaction_lists,
            "time"  => $time,
        ]);
    }

	protected function getEmployeeList(){

        $employee = Employee::all();

        $froms = From::all();
		return view('Admin.employee_list', compact('employee','froms'));
	}


    protected function storeSalesCustomer(Request $request){
            $sales_customer = SalesCustomer::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'credit_amount' => $request->credit_amount,

                ]);
                $last_row= DB::table('sales_customers')->orderBy('id', 'DESC')->first();
              // $last_row=SalesCustomer::last();
              //dd($last_row);
                Session::flash('data',$last_row);




        return response()->json([
                "success" => 1,
                "message" => "Customer is successfully added",
                "last_row"=>$last_row,

            ]);


    }
    
     protected function storeOrderCustomer(Request $request){
            $order_customer = OrderCustomer::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,

                ]);
                $last_row= DB::table('order_customers')->orderBy('id', 'DESC')->first();
              // $last_row=SalesCustomer::last();
              //dd($last_row);
                Session::flash('data',$last_row);




        return response()->json([
                "success" => 1,
                "message" => "Customer is successfully added",
                "last_row"=>$last_row,

            ]);


    }

    public function shopnameEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shopID' => 'required',
            'shopname' =>'required'
        ]);

        if ($validator->fails()) {

            alert()->error("Something Wrong! Validation Error");

            return redirect()->back();
        }
        try {
            $from = From::findOrfail($request->shopID);
        } catch (\Exception $e) {
            alert()->error("Cannot Find shop");

            return redirect()->back();
        }

            $from->name = $request->shopname;
            $from->save();

            alert()->success("Successfully Update");

            return redirect()->back();
        dd($request->all());
    }
    protected function getSalesCustomerList(){
        $salescustomer = SalesCustomer::all();
        return response()->json($salescustomer);
    }

    protected function getSalesCustomerWithID(Request $request){

        $salescustomerwID = SalesCustomer::findOrFail($request->customer_id);

        $cust_credit = SaleCustomerCreditlist::where('sales_customer_id',$request->customer_id)->first();
      
        return response()->json([
            'sale_credit' => $cust_credit,
            
            'sale_cust' => $salescustomerwID]);
        }
        
    protected function getOrderCustomerWithID(Request $request){

        $ordercustomerwID = OrderCustomer::findOrFail($request->customer_id);

        
      
        return response()->json([
            'order_cust' => $ordercustomerwID]);
        }
        
        
    public function deleteOrderCustomer(Request $request){
      $id=$request->ordercustomer_id;
     $deleted_customer= OrderCustomer::findOrFail($id)->delete();
     
     //$result=SalesCustomer::all();

    // return response()->json($result);
    
    return response()->json($deleted_customer);

      //dd($id);
    }
    
    public function employeeupdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'employee_code'=> 'required'
        ]);

        if ($validator->fails()) {

            alert()->error("Something Wrong! Validation Error");

            return redirect()->back();
        }
        
        try {
            $employee = Employee::findOrfail($request->employee_id);
            $employee->phone = $request->phone;
            $employee->save();

            $employee->user->user_code = $request->employee_code;
            $employee->user->email = $request->email;
            $employee->user->name = $request->name;
            if($request->enable_access){
            $give_access = 1;
            $employee->user->enable_access = $give_access;
            }
            if($request->password){
               
                $employee->user->password = bcrypt($request->password);
            }
            $employee->user->save();

        } catch (\Exception $e) {
            
            alert()->error("Fail when updating the employee");

            return redirect()->back();
        }

        alert()->success("Successfully Update");

        return redirect()->back();
    }

    public function purchaseDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error("Something Wrong! Validation Error");

            return redirect()->back();
        }


        // try {

        $purchase =Purchase::findOrfail($request->purchase_id);
       
        $purchase_units= $purchase->counting_unit;
        
        foreach($purchase_units as $unit){

            $current_stock= Stockcount::where("counting_unit_id",$unit->id)->where('from_id',1)->first();
            
            $balance_qty = $current_stock->stock_qty - $unit->pivot->quantity;
            if($balance_qty <0) {

            alert()->error("Stock ပြန်နုတ်ရန် မလုံလောက်ပါ..");

            return redirect()->back();
        }
            $current_stock->stock_qty = $balance_qty;
        
            $current_stock->save();

            $counting_units_delete= DB::table('counting_unit_purchase')->where('counting_unit_id', $unit->id)->where('purchase_id',$purchase->id)->delete();




        }
            // $purchase->counting_unit()->delete();


            $delete_credit = SupplierCreditList::where('purchase_id',$purchase->id)->first();
            $delete_credit->delete();
            $purchase->delete();
        // } catch (Exception $e) {

            // alert()->error("ဖျက်မရပါ..");

            // return redirect()->back();
        // }

        alert()->success("Successfully Deleted");

        return redirect()->route('purchase_list');
       
    }
  protected function storeEmployee(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:App\User,email',
            'password' => 'required',
            'phone' => 'required',
            'role' => 'required',
            'from_id' =>'required'
        ]);

        if ($validator->fails()) {

            alert()->error("Something Wrong! Validation Error");

            return redirect()->back();
        }

        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Hash::make($request->password),
                'role' => $request->role,
                'prohibition_flag' => 1,
                'photo_path' => "user.jpg",
                'from_id'=> $request->from_id
            ]);

            $user->user_code = "SHW-".sprintf('%03s', $user->id);

            $user->save();

            $employee = Employee::create([
                'phone' => $request->phone,
                'user_id' => $user->id,
            ]);

        } catch (\Exception $e) {

            alert()->error('Something Wrong! When Creating Emplyee.');

            return redirect()->back();
        }

        alert()->success('Successfully Added');

        return redirect()->route('employee_list');
    }

    protected function getEmployeeDetails($id){

        try {

            $employee = Employee::findOrFail($id);

        } catch (\Exception $e) {

            alert()->error("Employee Not Found!")->persistent("Close!");

            return redirect()->back();

        }

        return view('Admin.employee_details', compact('employee'));
    }

	protected function getCustomerList(){

        $customer_lists = Customer::all();


		return view('Admin.customer_list', compact('customer_lists'));
    }

    // public function getSalesCustomerCreditList($id){
    //     $sale_customer_lists = SalesCustomer::all();
    //     return view('Sale.sale_customer_lists',compact('sale_customer_lists'));
    // }


    public function show_sale_customer_credit_list(){
        $sale_customer = SalesCustomer::all();
        $credit_list = SaleCustomerCreditList::all();
        // dd($credit_list);
        return view('Sale.sale_customer_lists',compact('sale_customer','credit_list'));

    }
    
    public function collect_salescustomer_data(){
        $vouchers = Voucher::all();
        foreach($vouchers as $voucher){
            $sale_customer = SalesCustomer::find($voucher->sales_customer_id);
            if($sale_customer != null){
                $sale_customer->total_purchase_amount += $voucher->total_price;
                $sale_customer->total_purchase_quantity += $voucher->total_quantity;
                $sale_customer->total_purchase_times += 1;
                $sale_customer->last_purchase_date = $voucher->voucher_date;
            }
        }
        return response()->json(1);
    }
    
    public function show_order_customer_list(){
        $order_customer = OrderCustomer::all();
        
        return view('Order.order_customer_lists',compact('order_customer'));

    }
    
     public function collect_ordercustomer_data(){
        $orders = Order::all();
        foreach($orders as $order){
            $order_customer = OrderCustomer::find($order->customer_id);
            if($order_customer != null){
                $order_customer->total_purchase_amount += $order->est_price;
                $order_customer->total_purchase_quantity += $order->total_quantity;
                $order_customer->total_purchase_times += 1;
                $order_customer->last_purchase_date = $order->order_date;
            }
        }
        return response()->json(1);
    }

    public function show_supplier_credit_lists()
    {

        $supplier_credit_list = Supplier::all();
        return view('Admin.supplier_credit_list',compact('supplier_credit_list'));
    }

    public function add_supplier(Request $request){
        $suppliers = Supplier::all();
        return view('Admin.add_supplier',compact('suppliers'));
    }

    public function store_supplier(Request $request){
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone_number' => 'required',
            ]);

            $suppliers = Supplier::create([
                 'name' => $request->name,
                 'phone_number' => $request->phone_number,
            ]);

        alert()->success('successfully stored Supplier Data');
        return back();
    }

    public function supplier_credit($id)
    {

        $supplier = Supplier::find($id);
        $creditlist = SupplierCreditList::all();
        $credit = SupplierCreditList::where('supplier_id',$id)->get();
       $paypay = SupplierPayCredit::where('supplier_id',$id)->get();
    //    dd($credit);
       return view('Admin.supplier_credit_detail',compact('credit','supplier','paypay','creditlist'));
    }

    public function store_eachPaidSupplier(Request $request)
    {
        // dd($request->all());
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'email' => 'required|unique:App\User,email',
        //     'password' => 'required',
        //     'phone' => 'required',
        //     'role' => 'required',
        // ]);

        // if ($validator->fails()) {

        //     alert()->error("Something Wrong! Validation Error");

        //     return redirect()->back();
        // }
        $sale_customer = Supplier::find($request->supid);

        $credit_list = SupplierCreditlist::where('purchase_id',$request->purchase_id)->where('supplier_id',$request->supid)->first();

        $pay = $credit_list->credit_amount - $request->payamt;
        $credit_list->credit_amount = $pay;
        $sale_customer->credit_amount = $pay;
        $sale_customer->save();
        $credit_list->paid_status = 0;
        $credit_list->save();
        if($pay == 0)
        {
            $credit_list->paid_status =1;
            $credit_list->save();
            $pay_credit = SupplierPayCredit::create([
                'supplier_id' => $request->supid,
                'purchase_id' => $request->purchase_id,
                'left_amount' => $pay,
                'description' => $request->dest,
                'voucher_id'=>$request->vou_id,
                'pay_amount' => $request->payamt,
                'pay_date' => $request->paydate,
                'paid_status' => 1,
            ]);
        }
        elseif($pay != 0)
        {
            $credit_list->paid_status =0;
            $credit_list->save();
            $pay_credit = SupplierPayCredit::create([
                'supplier_id' => $request->supid,
                'purchase_id' => $request->purchase_id,
                'left_amount' => $pay,
                'description' => $request->dest,
                'voucher_id'=>$request->vou_id,
                'pay_amount' => $request->payamt,
                'pay_date' => $request->paydate,
                'paid_status' => 0,
            ]);
        }
        // dd($pay);
        if($pay == 0){
            $paycre = SupplierPayCredit::where('purchase_id',$request->purchase_id)->get();

            foreach($paycre as $paycree)
            {
            $paycree->paid_status = 1;

            $paycree->save();
            }
        }

        $supplier = SalesCustomer::find($request->supid);
        $creditlist = SupplierCreditlist::all();
        $credit = SupplierCreditlist::where('supplier_id',$request->supid)->get();
        $paypay = SupplierPayCredit::where('supplier_id',$request->supid)->get();

        return back()->with(compact('paypay','supplier','creditlist','credit'));

    }

    public function store_allSupplierPaid(Request $request,$id)
    {
        $SID = Supplier::find($id);

        if($SID->credit_amount == 0){
            $SID->status = 1;
            $SID->save();
        }
        $purchase = SupplierCreditlist::where('supplier_id',$id)->where('paid_status',0)->get();
        $pay_amount = $request->repay;
        $supplier = Supplier::find($id);
        if($supplier->credit_amount == 0)
        {
            $supplier->status = 1;
            $supplier->save();
        }
        $saletotal = $supplier->credit_amount - $pay_amount;
        $supplier->credit_amount = $saletotal;
        $supplier->save();
        $variable = 0;
        foreach($purchase as $purchases)
        {
         $repaycreditvoucher = SupplierPayCredit::where('purchase_id',$purchases->purchase_id)->first();
        $paypay = PayCredit::where('sale_customer_id',$id)->first();
        $last = $purchases->credit_amount - $pay_amount;

        if($last > 0)
        {
            $last = $last;
        }
        else{
            $last = $last * -1;
        }
        if($purchases->credit_amount <= $pay_amount)
        {


            if($repaycreditvoucher == null)
            {
                // dd("hello");
                if($purchases->credit_amount <= $request->repay)
                {
                    $begin_amt = $purchases->credit_amount;
                }
                else{
                    $begin_amt = $pay_amount;
                }
                $purchases->credit_amount = 0;
                $purchases->paid_status = 1;
                $purchases->save();

                    $paycredit = SupplierPayCredit::create([
                        'supplier_id' => $id,
                        'left_amount' => 0,
                        'description' => $request->remark,
                        'purchase_id'=>$purchases->purchase_id,

                        'pay_amount' => $begin_amt,
                        'pay_date' => $request->repaydate,
                        'paid_status' => 1,

                         ]);



            }
            else{
                // dd("hello2");
                if($purchases->credit_amount <= $request->repay)
                {
                    $begin_amout = $purchases->credit_amount;
                }
                else{
                    $begin_amtout = $pay_amount;
                }
                $purchases->credit_amount = 0;
                $purchases->paid_status = 1;
                $purchases->save();
                $paycredit = SupplierPayCredit::create([
                    'supplier_id' => $id,
                    'left_amount' => 0,
                    'description' => $request->remark,
                    'purchase_id'=>$purchases->purchase_id,

                    'pay_amount' => $begin_amout,
                    'pay_date' => $request->repaydate,
                    'paid_status' => 1,

                     ]);
        $change_status = SupplierCreditlist::where('purchase_id',$purchases->purchase_id)->first();
        if($change_status->credit_amount == 0)
        {
            // dd("hello0000");
        $paycredd = SupplierPayCredit::where('purchase_id',$change_status->purchase_id)->get();

        foreach($paycredd as $paycreedd)
        {
        $insertone = 1;
        $paycreedd->paid_status = 1;
            // dd($paycreedd->voucher_status);
        $paycreedd->save();
        // dd($paycreedd->voucher_status);

        }
        }

            }



        $pay_amount = $last;

        }


        else
        {
            // dd($purchases->purchase_id);

                $purchases->credit_amount = $last;
            $purchases->paid_status = 0;
            $purchases->save();


            $paycredit = SupplierPayCredit::create([
                'supplier_id' => $id,
                'left_amount' => $last,
                'description' => $request->remark,
                'purchase_id'=>$purchases->purchase_id,
                'pay_amount' => $pay_amount,
                'pay_date' => $request->repaydate,
                'paid_status' => 0,

        ]);

        // dd("end");


        $pay_amount = 0;
        }


        }
        // end foreach
        // $change_status = SaleCustomerCreditlist::where('voucher_id',$voucher->voucher_id)->first();
        // if($change_status->credit_amount == 0)
        // {

        // $paycredd = PayCredit::where('voucher_id',$change_status->voucher_id)->get();

        // foreach($paycredd as $paycreedd)

        // $paycreedd->voucher_status = 1;

        // $paycreedd->save();


        // }


        return back();
    }

    public function getPurchase_Info(Request $request)
    {
        // dd($request->credit_list_id);
        $credit_list = SupplierCreditList::find($request->credit_list_id);
        $purchase = Purchase::find($credit_list->purchase_id);
        // dd($purchase);
        return response()->json([$purchase]);
    }

    public function getsell_end_info(Request $request)
    {
        $asset = FixedAsset::find($request->asset_id);
        if($asset != null)
        {
            $has_asset = 1;
        }
        else
        {
            $has_asset = 2;
        }
        // dd($has_asset);
        return response()->json([
            'flag' => $asset->sell_or_end_flag,
            'has_asset' => $has_asset,
            'asset' => $asset,
        ]);
    }

    public function showFixasset(){
        $fixed_asset = FixedAsset::all();
        $nowdate = new DateTime('Asia/Yangon');
        $realdate = $nowdate->format('Y-m-d');
        $fillyear = [];
        $filldate =[];

        foreach($fixed_asset as $fday)
        {
            // dd($realdate."-------".$fday->future_day);
            if($realdate == $fday->future_day)
            {
                array_push($filldate,$fday->id);
            }
        }
        // dd($filldate);
        foreach($fixed_asset as $fyear)
        {
            if($realdate == $fyear->future_date)
            {
                array_push($fillyear,$fyear->id);
            }
        }


// dd($fillyear);
foreach($filldate as $fdate)
{
    $change_date = FixedAsset::find($fdate);
    $change_date->depriciation_total = $change_date->daily_depriciation +  $change_date->depriciation_total;
    $change_date->current_value = $change_date->current_value - $change_date->daily_depriciation;
    $futureDay=date('Y-m-d', strtotime('+1 day', strtotime($change_date->start_date)));
    $change_date->future_day = $futureDay;
    $change_date->save();
}
foreach($fillyear as $fyear)
{
    $change_all = FixedAsset::find($fyear);
    $change_all->depriciation_total = $change_all->yearly_depriciation +  $change_all->depriciation_total;
    $change_all->current_value = $change_all->current_value - $change_all->yearly_depriciation;
    $change_all->used_years +=1;
    $futureDate=date('Y-m-d', strtotime('+1 year', strtotime($change_all->start_date)));
    $change_all->future_date = $futureDate;
    $change_all->save();
}
$done = FixedAsset::all();
// dd($done);
// dd($change_all);
return view('Admin.fixasset',compact('fixed_asset','done'));
    }

    public function show_capitalPanel()
    {
        $fix_arr =[];
        $sale_credit_arr = [];
        $supp_credit_arr = [];
        $fixed = FixedAsset::all();
        $sale_credit = SalesCustomer::all();
        $supplier_credit = Supplier::all();
        foreach($supplier_credit as $sup)
        {
            array_push($supp_credit_arr,$sup->credit_amount);
        }
        $total_sup_credit = array_sum($supp_credit_arr);
        foreach($sale_credit as $sale_credits)
        {
            array_push($sale_credit_arr,$sale_credits->credit_amount);
        }
        $total_sale_credit = array_sum($sale_credit_arr);
        foreach($fixed as $asset)
        {
            array_push($fix_arr,$asset->current_value);
        }
        $current_asset = array_sum($fix_arr);
        // dd($current_asset);
        $general_info = GeneralInformation::all();
        // dd($general_info);
        $nowdate = new DateTime('Asia/Yangon');
        $realdate = $nowdate->format('Y-m-d');

        foreach($general_info as $general)
        {
            // dd($realdate."-----".$general->future_year);
            if($realdate == $general->future_year)
            {
                // dd($general->start_capital);
                $total_capital = ($general->current_capital) + (($general->reinvest)/100);
                $general->current_capital = $total_capital;
                // dd($general->current_capital);
                $fut_year=date('Y-m-d', strtotime('+1 year', strtotime($general->future_year)));
                $general->future_year = $fut_year;
                $general->save();
            }
        }
// dd("s");
        $general_information = GeneralInformation::all();
        $share_holder = ShareholderList::all();
        $transition = Capitaltransaction::all();
        return view('Admin.capital_panel',compact('transition','share_holder','general_information','current_asset','total_sale_credit','total_sup_credit'));
    }

    public function store_capitalInfo(Request $request)
    {
        // dd($request->name[0]);
        // dd($request->all());
        
            $current_equity =  ($request->start_capital + $request->cashin + $request->currentasset +$request->sale_credit) - ($request->sup_credit);
            // dd($current_equity);
            // dd(count($request->amount));
        if($request->general_id == null)
        {
            $general_info = GeneralInformation::create([
                'bussiness_name' => $request->buss_name,
                'business_type' => $request->buss_type,
                'total_starting_capital' => $request->start_capital,
                'number_shareholder' => $request->sharer,
                'old_holder' =>  $request->sharer,
                'current_capital' => $request->start_capital,
                'current_fixedasset' => $request->currentasset ,
                'current_cash' => $request->cashin,
                'current_equity' => $current_equity,
                'reinvest_percent' => $request->reinvest,
            ]);

            $future_year=date('Y-m-d', strtotime('+1 year', strtotime($general_info->created_at)));
            $general_info->future_year = $future_year;
            $general_info->save();

            // dd($request->name[0]);
            $length = count($request->name);
            // $i = 0;
                for($i = 0;$i<$length;$i++)
                {

                    $shareholder_store = ShareholderList::create([
                        'general_information_id' => $general_info->id,
                        'name' =>  $request->name[$i],
                        'nrc_passport' =>  $request->nrc[$i],
                        'position' => $request->position[$i],
                        'share_percent' =>  $request->amount[$i],
                        'devident_percent' => $request->divid[$i],
                        'capital_amount' => $request->start_capital,
                    ]);
                }
            
           
            // dd("stop");
            alert()->success("Successfully Stored Capital's General Information!");
            return back();
        }
        else if($request->general_id != null)
        {
            
            $general = GeneralInformation::find($request->general_id);
            $future_year=date('Y-m-d', strtotime('+1 year', strtotime($general->created_at)));
            $general->bussiness_name =  $request->buss_name;
            $general->business_type = $request->buss_type;
            $general->total_starting_capital = $request->start_capital;
            $general->number_shareholder = $request->sharer;
            // $general->old_holder = 2;
            $general->current_capital = $request->start_capital;
            $general->current_fixedasset = $request->currentasset;
            $general->current_cash = $request->cashin;
            $general->current_equity = $current_equity;
            $general->reinvest_percent = $request->reinvest;
            $general->future_year = $future_year;
            $general->save();
           
            $length = count($request->name);
            
            if($request->number_shareholder == $general->old_holder)
            {
                // dd("equal");
                for($i = 0;$i<$length;$i++)
                {
                    $shareHolder = ShareholderList::where('id',$request->sharer_id[$i])->first();
                    $shareHolder->general_information_id = $request->general_id;
                    $shareHolder->name = $request->name[$i];
                    $shareHolder->nrc_passport =  $request->nrc[$i];
                    $shareHolder->position = $request->position[$i];
                    $shareHolder->share_percent = $request->amount[$i];
                    $shareHolder->devident_percent = $request->divid[$i];
                    $shareHolder->capital_amount = $request->start_capital;
                    $shareHolder->save();
                    
                
                }
            }
            elseif($request->number_shareholder != $general->old_holder)
            {
                for($k = 0;$k<count($request->name);$k++)
                {
                    
                    $holder = ShareholderList::find($request->sharer_id[$k]);
                    if($holder != null)
                    {
                        $holder->general_information = $request->general_id;
                        $holder->name = $request->name[$k];
                        $holder->nrc_passport = $request->nrc[$k];
                        $holder->position = $request->position[$k];
                        $holder->share_percent = $request->amount[$k];
                        $holder->devident_percent = $request->divid[$k];
                        $holder->capital_amount = $request->start_capital;
                    }
                    else
                    {
                        $shareholder_store = ShareholderList::create([
                            'general_information_id' => $request->general_id,
                            'name' =>  $request->name[$k],
                            'nrc_passport' =>  $request->nrc[$k],
                            'position' => $request->position[$k],
                            'share_percent' =>  $request->amount[$k],
                            'devident_percent' => $request->divid[$k],
                            'capital_amount' => $request->start_capital,
                        ]);
                    }
                }
                
                // for($k = 0;$k<count($request->name)-1;$k++)
                // {
                    
                //     $holder = ShareholderList::find($request->sharer_id[$k]);
                //     $holder->delete();
                // }
                // for($k = 0;$k<count($request->name);$k++)
                // {
                   
                //     $shareholder_store = ShareholderList::create([
                //         'general_information_id' => $request->general_id,
                //         'name' =>  $request->name[$k],
                //         'nrc_passport' =>  $request->nrc[$k],
                //         'position' => $request->position[$k],
                //         'share_percent' =>  $request->amount[$k],
                //         'devident_percent' => $request->divid[$k],
                //         'capital_amount' => $request->start_capital,
                //     ]);
                // }
            }
            
            alert()->success("Successfully Updated Capital's General Information!");
            return back();
        }
        
    }

    public function addasset(){
        return view('Admin.addasset');
    }

    public function storeAsset(Request $request){
        //  dd($request->all());
         if($request->exist_asset == 1){
             $used_year = $request->used_year;
             $total_dep = $request->depriciation_total;
         }
         elseif($request->exist_asset == 2){
            $used_year = 0;
            $total_dep = 0;
        }


            $futureDate=date('Y-m-d', strtotime('+1 year', strtotime($request->start_date)));
            $futureDay=date('Y-m-d', strtotime('+1 day', strtotime($request->start_date)));
            $daily_dep = $request->year_depriciation/365;


        // if($request->sell)

        // dd( $used_year );
        $asset = FixedAsset::create([
            'name' => $request->asset_name ,
            'type' => $request->type ,
            'description' => $request->asset_description  ,
            'initial_purchase_price' => $request->purchase_initial_price ,
            'salvage_value' => $request->salvage_value ,
            'use_life' => $request->use_life ,
            'yearly_depriciation' => $request->year_depriciation ,
            'existing_flag' => $request->exist_asset ,
            'used_years' => $used_year,
            'depriciation_total' => $total_dep ,
            'current_value' => $request->current_value ,
            'start_date' => $request->start_date ,
            'future_date'=> $futureDate,
            'daily_depriciation' => $daily_dep,
            'future_day' => $futureDay
        ]);
        alert()->success('successfully stored Asset Data');
        return redirect()->route('fixasset');
    }

    public function storeSellEnd(Request $request){
        //  dd($request->all());
        // $request->
        $fixed_asset = FixedAsset::find($request->id);
        // dd($fixed_asset->profit_loss_status);
        if($request->sell_price > $request->current_value){
            $fixed_asset->profit_loss_status = 1;
        }
        elseif($request->sell_price < $request->current_value){
            $fixed_asset->profit_loss_status = 2;
        }
        if($request->exist_asset == 1){
            $fixed_asset->sell_or_end_flag = 1;
        }
        if($request->exist_asset == 2){
            $fixed_asset->sell_or_end_flag = 2;
        }

            $fixed_asset->sell_price = $request->sell_price;
            $fixed_asset->sell_date = $request->sell_date;
            $fixed_asset->profit_loss_value = $request->profit_loss;
            $fixed_asset->end_remark = $request->remark;
            $fixed_asset->end_date = $request->end_date;
            $fixed_asset->save();


            return redirect()->route('fixasset');


    }

    public function store_reinvest_info(Request $request){
        // dd($request->all());
        $general = GeneralInformation::find($request->general_id);
        if($request->reinvest_type == 1 && $request->proof == 3)
        {
            
            $general->current_capital +=$request->reinvest_amount;
            $general->current_cash -=$request->reinvest_amount;
            $general->save();
            $trans = Capitaltransaction::create([
                'type' => 1,
                'amount' => $request->reinvest_amount,
                'date' => $request->reinvest_date,
                'source' => $request->reinvest_type,
                
            ]);

            // dd($real_amt);
            alert()->success("Successfully Reinvest Cash Transition !!");
            return back();
        }
        elseif($request->reinvest_type == 2 && $request->proof == 3)
        {
            
            
            $general->current_capital +=$request->reinvest_amount;
            
            $general->save();
            $trans = Capitaltransaction::create([
                'type' => 1,
                'amount' => $request->reinvest_amount,
                'date' => $request->reinvest_date,
                'source' => $request->reinvest_type,
                'remark' => $request->reinvest_remark,
            ]);

            // dd($real_amt);
            alert()->success("Successfully Reinvest Other Transition !!");
            return back();
        }
        
        
        

    }

    public function store_withdraw_info(Request $request){
        // dd($request->all());
        $general = GeneralInformation::find($request->general_id);
        if($request->withdraw_type == 1 && $request->proof == 4)
        {
           
            $general->current_cash +=$request->withdraw_amount;
            $general->current_capital -=$request->withdraw_amount;
            $general->save();
            $trans = Capitaltransaction::create([
                'type' => 2,
                'amount' => $request->withdraw_amount,
                'date' => $request->withdraw_date,
                'source' => $request->withdraw_type,
                'remark' => $request->withdraw_remark,
            ]);
            alert()->success("Successfully Withdraw Cash Transition !!");
            return back();

        }
        elseif($request->withdraw_type == 2 && $request->proof == 4)
        {
            
            $general->current_capital -=$request->withdraw_amount;
            $general->save();
            $trans = Capitaltransaction::create([
                'type' => 2,
                'amount' => $request->withdraw_amount,
                'date' => $request->withdraw_date,
                'source' => $request->withdraw_type,
                'remark' => $request->withdraw_remark,
            ]);
            alert()->success("Successfully Withdraw Other Transition !!");
            return back();
        }
    }

    // public function history(){
    //     $voucher_id = SaleCustomerCreditlist::
    //     dd($voucher_id);
    //     return view('Sale.voucher_details',compact('voucher_id'));

    // }
           // public function history(){
               // $voucher_id = SaleCustomerLists::select('voucher_id')->get();
               // dd($voucher_id);
            //    $id=$request->all();
            //    dd($id);
               // return view('Sale.voucher_details',compact('voucher_id'));
               // }

    // function index(){
    //     $sale_customer_lists = SalesCustomer::all();
    //     // dd($sale_customer_lists);

    //     return view('Sale.sale_customer_lists',compact('sale_customer_lists'));
    // }
    public function credit($id){

       // $str = json_encode($sale_customer_id);

       //$credit_id = SalesCustomer::
       $salecustomer = SalesCustomer::find($id);
       $creditlist = SaleCustomerCreditlist::all();
       $credit = SaleCustomerCreditlist::where('sales_customer_id',$id)->get();

    //    dd($credit);
      $paypay = PayCredit::where('sale_customer_id',$id)->get();
        return view('Sale.credit_detail',compact('creditlist','credit','salecustomer','paypay'));



    }

    protected function store_eachPaid(Request $request)
    {
        // dd($request->all());
        $sale_customer = SalesCustomer::find($request->scid);

        $credit_list = SaleCustomerCreditlist::where('voucher_id',$request->vou_id)->where('sales_customer_id',$request->scid)->first();

        $pay = $credit_list->credit_amount - $request->payamt;
        $credit_list->credit_amount = $pay;
        $sale_customer->credit_amount = $pay;
        $sale_customer->save();
        $credit_list->paid_status = 0;
        $credit_list->save();
        if($pay == 0)
        {
            $credit_list->paid_status =1;
            $credit_list->save();
            $pay_credit = PayCredit::create([
                'sale_customer_id' => $request->scid,
                'left_amount' => $pay,
                'description' => $request->dest,
                'voucher_id'=>$request->vou_id,
                'pay_amount' => $request->payamt,
                'pay_date' => $request->paydate,
                'paid_status' => 1,
            ]);
        }
        elseif($pay != 0)
        {
            $credit_list->paid_status =0;
            $credit_list->save();
            $pay_credit = PayCredit::create([
                'sale_customer_id' => $request->scid,
                'left_amount' => $pay,
                'description' => $request->dest,
                'voucher_id'=>$request->vou_id,
                'pay_amount' => $request->payamt,
                'pay_date' => $request->paydate,
                'paid_status' => 0,
            ]);
        }
        // dd($pay);
        if($pay == 0){
            $paycre = PayCredit::where('voucher_id',$request->vou_id)->get();

            foreach($paycre as $paycree)
            {
            $paycree->paid_status = 1;

            $paycree->save();
            }
        }

        $salecustomer = SalesCustomer::find($request->scid);
        $creditlist = SaleCustomerCreditlist::all();
        $credit = SaleCustomerCreditlist::where('sales_customer_id',$request->scid)->get();
        $paypay = PayCredit::where('sale_customer_id',$request->scid)->get();

        return back()->with(compact('paypay','salecustomer','creditlist','credit'));
    }

    protected function store_allPaid(Request $request,$id)
    {
        // dd($request->all());
        $SID = SalesCustomer::find($id);

        if($SID->credit_amount == 0){
            $SID->status = 1;
            $SID->save();
        }
        $vouchers = SaleCustomerCreditlist::where('sales_customer_id',$id)->where('paid_status',0)->get();
        $pay_amount = $request->repay;
        $saleCustomer = SalesCustomer::find($id);
        if($saleCustomer->credit_amount == 0)
        {
            $saleCustomer->status = 1;
            $saleCustomer->save();
        }
        $saletotal = $saleCustomer->credit_amount - $pay_amount;
        $saleCustomer->credit_amount = $saletotal;
        $saleCustomer->save();
        $variable = 0;
        foreach($vouchers as $voucher)
        {
         $repaycreditvoucher = PayCredit::where('voucher_id',$voucher->voucher_id)->first();
        $paypay = PayCredit::where('sale_customer_id',$id)->first();
        $last = $voucher->credit_amount - $pay_amount;

        if($last > 0)
        {
            $last = $last;
        }
        else{
            $last = $last * -1;
        }
        if($voucher->credit_amount <= $pay_amount)
        {


            if($repaycreditvoucher == null)
            {
                // dd("hello");
                if($voucher->credit_amount <= $request->repay)
                {
                    $begin_amt = $voucher->credit_amount;
                }
                else{
                    $begin_amt = $pay_amount;
                }
                $voucher->credit_amount = 0;
                $voucher->paid_status = 1;
                $voucher->save();

                    $paycredit = PayCredit::create([
                        'sale_customer_id' => $id,
                        'left_amount' => 0,
                        'description' => $request->remark,
                        'voucher_id'=>$voucher->voucher_id,

                        'pay_amount' => $begin_amt,
                        'pay_date' => $request->repaydate,
                        'paid_status' => 1,

                         ]);



            }
            else{
                // dd("hello2");
                if($voucher->credit_amount <= $request->repay)
                {
                    $begin_amout = $voucher->credit_amount;
                }
                else{
                    $begin_amtout = $pay_amount;
                }
                $voucher->credit_amount = 0;
                $voucher->paid_status = 1;
                $voucher->save();
                $paycredit = PayCredit::create([
                    'sale_customer_id' => $id,
                    'left_amount' => 0,
                    'description' => $request->remark,
                    'voucher_id'=>$voucher->voucher_id,

                    'pay_amount' => $begin_amout,
                    'pay_date' => $request->repaydate,
                    'paid_status' => 1,

                     ]);
        $change_status = SaleCustomerCreditlist::where('voucher_id',$voucher->voucher_id)->first();
        if($change_status->credit_amount == 0)
        {
            // dd("hello0000");
        $paycredd = PayCredit::where('voucher_id',$change_status->voucher_id)->get();

        foreach($paycredd as $paycreedd)
        {
        $insertone = 1;
        $paycreedd->paid_status = 1;
            // dd($paycreedd->voucher_status);
        $paycreedd->save();
        // dd($paycreedd->voucher_status);

        }
        }

            }



        $pay_amount = $last;

        }


        else
        {
            // dd("djfd");

                $voucher->credit_amount = $last;
            $voucher->paid_status = 0;
            $voucher->save();


            $paycredit = PayCredit::create([
                'sale_customer_id' => $id,
                'left_amount' => $last,
                'description' => $request->remark,
                'voucher_id'=>$voucher->voucher_id,
                'pay_amount' => $pay_amount,
                'pay_date' => $request->repaydate,
                'paid_status' => 0,

        ]);




        $pay_amount = 0;
        }


        }
        // end foreach
        // $change_status = SaleCustomerCreditlist::where('voucher_id',$voucher->voucher_id)->first();
        // if($change_status->credit_amount == 0)
        // {

        // $paycredd = PayCredit::where('voucher_id',$change_status->voucher_id)->get();

        // foreach($paycredd as $paycreedd)

        // $paycreedd->voucher_status = 1;

        // $paycreedd->save();


        // }


        return back();
    }

	protected function storeCustomer(Request $request){

		$validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'level' => 'required',
        ]);

        if ($validator->fails()) {

        	alert()->error("Something Wrong! Validation Error");

            return redirect()->back();
        }

        $count_cus = count(Customer::all());



        if ($count_cus == 40) {

            alert()->error("Your Customer Count is full!");

            return redirect()->back();

        } else {


                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => \Hash::make($request->password),
                    'role' => "Customer",
                    'prohibition_flag' => 1,
                    'photo_path' => "user.jpg",
                ]);

                $user->user_code = "SHW-CUS-".sprintf('%03s', $user->id);

                $user->save();

                $customer = Customer::create([
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'allow_credit' => $request->allow_credit = "on"?1:0,
                    'customer_level' => $request->level,
                    'user_id' => $user->id,
                ]);



            alert()->success('Successfully Added');

            return redirect()->route('customer_list');
        }
	}

    protected function getCustomerDetails($id){

        try {

            $customer = Customer::findOrFail($id);

        } catch (\Exception $e) {

            alert()->error("Customer Not Found!")->persistent("Close!");

            return redirect()->back();

        }

        $order_lists = Order::where('customer_id', $customer->id)->get();

       return view('Admin.customer_details', compact('customer','order_lists'));
    }

    protected function updateCustomer(Request $request, $id){

        $validator = Validator::make($request->all(), [
			'name' => 'required',
			'email' => 'required',
			'phone' => 'required',
			'address' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Something Wrong! Validation Error.", "400");
		}

        try {

            $customer = Customer::findOrFail($id);

            $user = User::findOrFail($customer->user_id);

        } catch (\Exception $e) {

            alert()->error("Customer Not Found!")->persistent("Close!");

            return redirect()->back();

        }

        $user->name = $request->name;

        $user->email = $request->email;

        $user->save();

        $customer->phone = $request->phone;

		$customer->address = $request->address;

		$customer->save();

		alert()->success("Successfully Updated Customer!");

		return redirect()->route('customer_list');
    }

    protected function changeCustomerLevel(Request $request){

        try {

            $customer = Customer::findOrFail($request->customer_id);

            $customer->customer_level = $request->level;

            $customer->save();

            alert()->success('Successfully Updated');

            return redirect()->back();

        } catch (\Exception $e) {

            alert()->error("Customer Not Found!")->persistent("Close!");

            return redirect()->back();

        }
    }

    protected function getCustomerInfo(Request $request){

        $customer = Customer::where('id',$request->customer_id)->with('user')->first();

        return response()->json($customer);
    }

    protected function getPurchaseHistory(Request $request){

        $purchase_lists = Purchase::all();

        return view('Purchase.purchase_lists', compact('purchase_lists'));
    }

    protected function createPurchaseHistory(){

        $froms=From::find(1);
        // $items = $froms->items()->with('counting_units')->with("counting_units.stockcount")->get();
        //$items = Item::with('counting_units')->with("counting_units.stockcount")->get();
        
        $items = Item::where("category_id",1)->where("sub_category_id",2)->get();
        $item_ids=[];
        //$counting_units=[];
        foreach ($items as $item){
            array_push($item_ids,$item->id);
        }
        $counting_units = CountingUnit::whereIn('item_id',$item_ids)->get();
        $categories = Category::where('type_flag',1)->get();

        $sub_categories = SubCategory::where('type_flag',1)->get();
        
        $supplier = Supplier::all();
        
         $last_voucher = Purchase::count();
        if($last_voucher != null){
            $purchase_number =  "PRN-" .date('y') . sprintf("%02s", (intval(date('m')) + 1)) . sprintf("%02s", ($last_voucher+ 1));
        }else{
            $purchase_number =  "PRN-" .date('y') . sprintf("%02s", (intval(date('m')) + 1)) .sprintf("%02s", 1);
        }
        
        return view('Purchase.create_purchase', compact('categories','sub_categories','counting_units','supplier','purchase_number'));
    }

    protected function getPurchaseHistoryDetails($id){

        try {

            $purchase = Purchase::findOrFail($id);

        } catch (\Exception $e) {

            alert()->error('Something Wrong! Purchase Cannot be Found.');

            return redirect()->back();
        }

        return view('Purchase.purchase_details', compact('purchase'));

    }

    protected function storePurchaseHistory(Request $request){
        $validator = Validator::make($request->all(), [
            'purchase_number' => 'required',
            'purchase_date' => 'required',
            'purchase_remark' => 'required',
            'supp_name' => 'required',
            'unit' => 'required',
            'price' => 'required',
            'qty' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error("Something Wrong! Validation Error");

            return redirect()->back();
        }

        $user_code = $request->session()->get('user')->id;

        $unit = $request->unit;

        $price = $request->price;

        $qty = $request->qty;
        
        $type = $request->type;

        $total_qty = 0;

        $total_price = 0;

        $psub_total = 0;

        // foreach($price as $p){
        //     foreach($qty as $q){
        //         $psub_total = $p * $q;
        //         $total_price += $psub_total;
        //     }
        // }
        
        for($count = 0; $count < count($unit); $count++){
            $psub_total = $price[$count] * $qty[$count];
            $total_price += $psub_total;
        }

        foreach ($qty as $q) {

            $total_qty += $q;
        }
        $supplier = Supplier::find($request->supp_name);
        if($request->pay_method == 1)
        {

        $supplier->credit_amount +=  $request->credit_amount;
        $supplier->save();
        }
        try {

            $purchase = Purchase::create([
                'purchase_number' => $request->purchase_number,
                'supplier_name' => $supplier->name,
                'supplier_id' => $request->supp_name,
                'total_quantity' => $total_qty,
                'total_price' => $total_price,
                'purchase_date' => $request->purchase_date,
                'purchase_remark' => $request->purchase_remark,
                'purchase_type' => $type,
                'purchase_by' => $user_code,
                'credit_amount' => $request->credit_amount,
            ]);

            if($request->pay_method == 1)
            {

                $supplier_credit = SupplierCreditList::create([
                    'supplier_id' => $request->supp_name,
                    'purchase_id' => $purchase->id,
                    'credit_amount' => $request->credit_amount,
                    'repay_date' => $request->repay_date,
                ]);
            }


            for($count = 0; $count < count($unit); $count++){

                if($type == 1){
                $purchase->counting_unit()->attach($unit[$count], ['quantity' => $qty[$count], 'price' => $price[$count]]);

                 $counting_unit = CountingUnit::find($unit[$count]);
                 
                //$stockcount = Stockcount::where('from_id',1)->where('counting_unit_id',$unit[$count])->first();

                $balance_qty = ($counting_unit->current_quantity + $qty[$count]);

                // $stockcount->stock_qty = $balance_qty;

                // $stockcount->save();
                 $counting_unit->current_quantity = $balance_qty;

                 $counting_unit->save();
                }else if($type == 2){
                     $purchase->factory_item()->attach($unit[$count], ['quantity' => $qty[$count], 'price' => $price[$count]]);

                 $factory_item = FactoryItem::find($unit[$count]);
                 
                //$stockcount = Stockcount::where('from_id',1)->where('counting_unit_id',$unit[$count])->first();

                $balance_qty = ($factory_item->instock_qty + $qty[$count]);

                // $stockcount->stock_qty = $balance_qty;

                // $stockcount->save();
                 $factory_item->instock_qty = $balance_qty;

                 $factory_item->save();
                }

            }

        } catch (\Exception $e) {

            alert()->error('Something Wrong! When Purchase Store.');

            return redirect()->back();
        }

        alert()->success("Success");

        return redirect()->route('purchase_list');
    }
    
    public function purchaseCategorySearch(Request $request){

        
        $type = $request->type;
        $categories = Category::where('type_flag',$type)->get();
        return response()->json($categories);

    }
    
     public function purchaseSubcategorySearch(Request $request){

        $category_id = $request->category_id;
        $type = $request->type;
        $subCategories = SubCategory::where('category_id',$category_id)->where('type_flag',$type)->get();
        return response()->json($subCategories);

    }
    
    public function purchaseUnitSearch(Request $request){
        $category_id = $request->category_id;
        $subcategory_id = $request->subcategory_id;
        $type = $request->type;
        ini_set('max_execution_time',300);
//        return $request;

        if($type == 1){
        $items = Item::where("category_id",$category_id)->where("sub_category_id",$subcategory_id)->get();
        $item_ids=[];
       
            foreach ($items as $item){
                array_push($item_ids,$item->id);
            }
        
        $counting_units = CountingUnit::whereIn('item_id',$item_ids)->get();
        }else if ($type == 2){
            $counting_units = FactoryItem::where("category_id",$category_id)->where("subcategory_id",$subcategory_id)->get();
        }
        return response()->json($counting_units);
    }

    protected function getTotalSalenAndProfit(Request $request){

        return view('Admin.financial_panel');
    }

    // protected function getTotalSaleReport(Request $request){

    //     $type = $request->type;

    //     $total_sales = 0;

    //     $total_profit = 0;

    //     if($type == 1){

    //         $daily = date('Y-m-d', strtotime($request->value));

    //         $voucher_lists = Voucher::whereDate('voucher_date', $daily)->get();

    //     }
    //     elseif($type == 2){

    //         $week_count = $request->value;

    //         $start_month = date('Y-m-d',strtotime('first day of this month'));

    //         if ($week_count == 1) {

    //             $end_date = date('Y-m-d', strtotime("+1 week" , strtotime($start_month)));

    //             $voucher_lists = Voucher::whereBetween('voucher_date', [$start_month, $end_date])->get();

    //         } elseif ($week_count == 2) {

    //             $start_date = date('Y-m-d', strtotime("+1 week" , strtotime($start_month)));

    //             $end_date = date('Y-m-d', strtotime("+2 week" , strtotime($start_month)));

    //             $voucher_lists = Voucher::whereBetween('voucher_date', [$start_date, $end_date])->get();

    //         } elseif ($week_count == 3) {

    //             $start_date = date('Y-m-d', strtotime("+2 week" , strtotime($start_month)));

    //             $end_date = date('Y-m-d', strtotime("+3 week" , strtotime($start_month)));

    //             $voucher_lists = Voucher::whereBetween('voucher_date', [$start_date, $end_date])->get();

    //         } else {

    //             $start_date = date('Y-m-d', strtotime("+3 week" , strtotime($start_month)));

    //             $end_date = date('Y-m-d',strtotime('last day of this month'));

    //             $voucher_lists = Voucher::whereBetween('voucher_date', [$start_date, $end_date])->get();
    //         }

    //     }
    //     else{

    //         $monthly = $request->value;

    //         $voucher_lists = Voucher::whereMonth('voucher_date', $monthly)->get();
    //     }

    //     foreach ($voucher_lists as $lists) {

    //         $total_sales += $lists->total_price;

    //         foreach ($lists->counting_unit as $unit) {

    //             $total_profit += ($unit->pivot->price * $unit->pivot->quantity) - ($unit->purchase_price * $unit->pivot->quantity);
    //         }

    //     }

    //     return response()->json([
    //         "total_sales" => $total_sales,
    //         "total_profit" => $total_profit,
    //         "voucher_lists" => $voucher_lists,
    //     ]);
    // }

    protected function changeCustomerPassword(Request $request){

    	$validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'new_password' => 'required',
        ]);

        if ($validator->fails()) {

        	return $this->sendFailResponse("Something Wrong! Validation Error.", "400");
        }

        $user = User::find($request->user_id);

        // $current_pw = $request->current_password;

        // if(!\Hash::check($current_pw, $user->password)){

        //     return $this->sendFailResponse("Something Wrong! Password doesn't match.", "400");
        // }

        $has_new_pw = \Hash::make($request->new_password);

        $user->password = $has_new_pw;

        $user->save();

        return response()->json([
                "user_code"=> $user->user_code,
            ]);
    }
    public function getFixedAssets(Request $request)
    {

        return view('Admin.fixedassetlists');
    }

    public function getnewAsset()
    {
        return view('Admin.newasset');
    }
    public function mobileprint(Request $request)
    {
            $mobile_print = Voucher::where('from_id',$request->from_id)->where('is_mobile',1)->where("is_print",1)->with('counting_unit')->with('counting_unit.item')->with('user')->orderBy('id','desc')->first();
            if($mobile_print){
                return response()->json($mobile_print);
            }else{
                return response()->json(null);
            }
    }
    protected function itemrequestlists(Request $request){
       $role= $request->session()->get('user')->role;
       if($role=="Owner"){
        $request_lists = Itemrequest::orderBy('id','desc')->get();
       }
       else{
        $from_id = $request->session()->get('from');
        $request_lists = Itemrequest::where("from_id",$from_id)->orderBy('id','desc')->get();
       }

        return view('Itemrequest.itemrequestlists', compact('request_lists'));
    }
    protected function getRequestHistoryDetails($id){

        try {

            $itemrequest = Itemrequest::findOrFail($id);

            $froms=From::find(1);
            $items = $froms->items()->with('counting_units')->with("counting_units.stockcount")->get();
        } catch (\Exception $e) {

            alert()->error('Something Wrong! Item Request Cannot be Found.');

            return redirect()->back();
        }

        return view('Itemrequest.requestdetail', compact('itemrequest','items'));

    }
    public function create_itemrequest(Request $request)
    {

        $from_id = $request->session()->get('from');
        $froms=From::find($from_id);
        $items = $froms->items()->with('counting_units')->with("counting_units.stockcount")->get();
        return view('Itemrequest.create_itemrequest', compact('items'));

    }


    protected function newcreate_itemrequest(Request $request){
        $role= $request->session()->get('user')->role;
        if($role=='Sale_Person'){
            $item_from= $request->session()->get('user')->from_id;
        }
        else {
            $item_from= $request->session()->get('from');
        }
       // $froms=From::find($item_from);
        //$items = $froms->items()->with('category')->with('counting_units')->with("counting_units.stockcount")->with('sub_category')->get();
        // $items = Item::with('counting_units')->get();
        $categories = Category::where('type_flag',2)->get();
        $sub_categories = SubCategory::where('type_flag',2)->get();
        $items = FactoryItem::where('category_id',9)->where('subcategory_id',19)->get();

        $customers = Customer::all();

        $employees = Employee::all();

        $date = new DateTime('Asia/Yangon');

        $today_date = strtotime($date->format('d-m-Y H:i'));
        
        $salescustomers = SalesCustomer::all();
        
        $last_po = FactoryPo::count();

        if($last_po != null){
            $po_code =  "FPR-" .date('y') . sprintf("%02s", (intval(date('m')))) .sprintf("%02s", ($last_po + 1));
        }else{
            $po_code =  "FPR-" .date('y') . sprintf("%02s", (intval(date('m')))) .sprintf("%02s", 1);
        }
        
        
    	// dd($salescustomers);
    	return view('Itemrequest.newcreate_itemrequest',compact('po_code','items','categories','customers','employees','today_date','sub_categories','salescustomers'));
    }

    protected function store_itemrequest(Request $request){

        $validator = Validator::make($request->all(), [
            'itemrequest_date' => 'required',
            'unit' => 'required',
            'qty' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error("Something Wrong! Validation Error");

            return redirect()->back();
        }

        $user_code = $request->session()->get('user')->id;

        $unit = $request->unit;

        $qty = $request->qty;

        $total_qty = 0;

        foreach ($qty as $q) {

            $total_qty += $q;
        }

        try {
            $itemrequest = itemrequest::create([
                'request_by' => $request->session()->get('user')->id,
                'total_quantity' => $total_qty,
                'date' => $request->itemrequest_date,
                'from_id' => $request->session()->get('from'),
            ]);


            for($count = 0; $count < count($unit); $count++){

                $itemrequest->counting_units()->attach($unit[$count], ['quantity' => $qty[$count]]);

                // $counting_unit = CountingUnit::find($unit[$count]);

                // $balance_qty = ($counting_unit->current_quantity + $qty[$count]);

                // $counting_unit->current_quantity = $balance_qty;

                // $counting_unit->itemrequest_price = $price[$count];

                // $counting_unit->save();

            }

        } catch (\Exception $e) {

            alert()->error('Something Wrong! When itemrequest Store.');

            return redirect()->back();
        }

        alert()->success("Success");

        return redirect()->route('itemrequestlists');
    }
    public function requestitemssend(Request $request)
    {
        $sentqty= $request->sentqty;
        $counting_units= $request->counting_units;
        $itemrequest = Itemrequest::findOrfail($request->itemrequest_id);


        try {
    
        foreach($itemrequest->counting_units as $unit){
        $key = array_search ($unit->pivot->counting_unit_id, $counting_units);

        $shop_origin = Stockcount::where('counting_unit_id',$unit->pivot->counting_unit_id)->where('from_id',1)->whereNull('deleted_at')->first();
        
        if($sentqty[$key]<=$shop_origin->stock_qty){
            $itemrequest->counting_units()->updateExistingPivot($unit->pivot->counting_unit_id,['send_quantity'=>$sentqty[$key]]);
            //update origin stock
            // $shop_origin= DB::table('stockcounts')->where('counting_unit_id',$unit->pivot->counting_unit_id)->where('from_id',1)->whereNull('deleted_at')->first();
            // $balance_qty = $shop_origin->stock_qty-$sentqty[$key];
    
    
            $balance_qty = $shop_origin->stock_qty-$sentqty[$key];
            $shop_origin->stock_qty = $balance_qty;
            $shop_origin->save();
    
            //update request shop's stock
    
            $requestshop= Stockcount::where('counting_unit_id',$unit->pivot->counting_unit_id)->where('from_id',$request->shop_id)->whereNull('deleted_at')->first();
            $balance_qty = $requestshop->stock_qty+$sentqty[$key];
            $requestshop->stock_qty = $balance_qty;
            $requestshop->save();
        }
      
        }
        } catch (Exception $e) {
            alert()->error("No Instocks");
            return back();
        }


        $itemrequest->status=1;
        $itemrequest->save();
        alert()->success("Successfull send");
        return back();

    }
    public function purchasepriceUpdate(Request $request)
    {
        try{
            $counting_unit = CountingUnit::findOrfail($request->unit_id);
        } catch (\Exception $e) {
            return response()->json(0);
        }
        $counting_unit->update([
            'purchase_price' => $request->purchase_price,
            'order_price' => $request->normal_price,
         ]);

         return response()->json($counting_unit);

    }
    public function execelImport(Request $request)
    {
        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx'
         ]);
        //  try{

         Excel::import(new ItemsImport,request()->file('select_file'));

        // } catch (\Exception $e) {
        // alert()->error("Something Went Wrong!");
        //  return back();

        // }
        alert()->success("Success");
        return back();
    }
    public function delete_units(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "unit_ids" => "required",
            "multi_delete" => "required",
        ]);

        if($validator->fails()){
            return response()->json(0);
        }
    
        if($request->multi_delete ==1){
            foreach($request->unit_ids as $unit_id){
            $unit = CountingUnit::find($unit_id);
            $unit->delete();
            }
        }
        else{
            $unit = CountingUnit::find($request->unit_ids);
            $unit->delete();
        }
           
        $unit->delete();
        
        return response()->json(1);

    }
    
     protected function bankAccList()
    {
        $bank = BankAccount::all();
        return view('Admin.bank_acc_list',compact('bank'));
    }
    public function editAccount(request $request, $id){

        $account = BankAccount::find($id);

        $account->account_number = $request->acc_number;

        $account->opening_date = $request->opening_date;

        $account->account_holder_name = $request->holder_name;

        $account->bank_name = $request->bank_name;

        $account->bank_address = $request->bank_address;

        $account->bank_contact = $request->bank_contact;

        $account->balance = $request->balance;

        $account->save();

        return redirect()->route('bank_list');
     }
    protected function store_bank_account(Request $request)
    {
        // dd($request->all());

            $validator = Validator::make($request->all(), [
                 'bank_name' => 'required',
                 'bank_address' => 'required',
                 'bank_contact' => 'required',
                 'acc_number' => 'required',
                 'holder_name' => 'required',
                 'opening_date' => 'required',

             ]);


             if ($validator->fails()){

                 return redirect()->back();
             }

             $account = BankAccount::create([

                 'account_number' => $request->acc_number,
                 'opening_date' => $request->opening_date,
                 'account_holder_name' => $request->holder_name,
                 'balance' => $request->current_balance,
                 'bank_name' => $request->bank_name,
                 'bank_address' => $request->bank_address,
                 'bank_contact' => $request->bank_contact,

             ]);

             return redirect()->back();



    }
    
    protected function TransactionList($id)
    {
        // dd("dd");
        $orders = Order::with('customUnitOrder')->find($id);
        // dd($unit);
        $bank = BankAccount::all();
        $transaction = Transaction::where('order_id',$id)->get();
        // dd($transaction);
        return view('Admin.transaction_list', compact('orders','bank','transaction'));
    }
    protected function store_transaction_now(Request $request)
    {
       
        // dd($time);
        $validator = Validator::make($request->all(), [
            'pay_date' => 'required',
            //'pay_time' => 'required',
            'pay_amt' => 'required',
            'remark' => 'required',
        ]);
        

        if ($validator->fails()){
            alert()->error('Fill all the basic fields');
            return redirect()->back();
        }
        //$time = date('h:i a', strtotime($request->pay_time));
        // dd($request->all());
        $order = Order::find($request->ord_id);
        $order->advance_pay +=$request->pay_amt;
        // dd($voucher->prepaid_amount);
        
        // dd($voucher->total_charges);
        $order->collect_amount = $request->collect_amt;
        $order->last_payment_date = $request->pay_date;
        $order->save();
        $transaction = Transaction::create([
            'bank_acc_id' => $request->bank_info,
            'tran_date' => $request->pay_date,
            //'tran_time' => $time,
            'remark' => $request->remark,
            'pay_amount' => $request->pay_amt,
            'order_id' => $request->ord_id,
        ]);
        // dd("done");
        $bank = BankAccount::find($request->bank_info);
        $bank->balance += $request->pay_amt;
        $bank->save();
        if($order->payment_type == 1 && $order->est_price <= $order->advance_pay &&  $order->payment_clear_flag = 1)
        {
            $order->payment_clear_flag = 0;
            $order->save();
        }
        alert()->success("Successfully Stored Transaction!!");
        return back();

    }
}
