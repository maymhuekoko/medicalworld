<?php

namespace App\Exports;

use App\Voucher;
use App\Order;
use App\OrderCustomer;
use App\Supplier;
use App\SupplierPayCredit;
use App\Purchase;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ReceivePayHistoryExport implements FromArray,ShouldAutoSize,WithHeadings
{
    use Exportable;
    
    protected $from_date;
    protected $to_date;
    protected $customer_id;
    protected $type;
    
    public function __construct($from,$to,$customer_id,$type){
        $this->from_date = $from;
        $this->to_date = $to;
        $this->customer_id = $customer_id;
        $this->type = $type;
    }
    
    
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     if($this->data_type == 1){
    //     if($this->customer_id == 0){
    //     return Voucher::whereBetween('voucher_date',[$this->from_date, $this->to_date])->get();
    //     }else{
    //         return Voucher::whereBetween('voucher_date',[$this->from_date, $this->to_date])->where('sales_customer_id',$this->customer_id)->get();
    //     }
    //     }else if($this->data_type == 2){
    //         if($this->customer_id == 0){
    //         $vouchers = Voucher::whereBetween('voucher_date',[$this->from_date, $this->to_date])->with('counting_unit')->get();
    //         $item_lists = array();
    //         foreach($vouchers as $voucher){
    //             foreach($voucher->counting_unit as $counting_unit){
    //                 $voucher_code = $voucher->voucher_code;
    //                 $voucher_date = $voucher->voucher_date;
    //                 $customer_name = $voucher->sales_customer_name;
    //                 $unit_name = $counting_unit->unit_name;
    //                 $unit_code = $counting_unit->unit_code;
    //                 $qty = $counting_unit->pivot->quantity;
    //                 $price = $counting_unit->pivot->price;
    //                 $combined = array('voucher_code' => $voucher_code, 'voucher_date' => $voucher_date, 'customer_name' => $customer_name,'unit_name' => $unit_name, 'unit_code' => $unit_code, 'quantity' => $qty, 'price' =>$price );

    //                 array_push($item_lists, $combined);
    //             }
    //         }
    //         dd(new Collection($item_lists));
    //         return new Collection($item_lists);
    //     }else{
    //         $voucher = Voucher::whereBetween('voucher_date',[$this->from_date, $this->to_date])->where('sales_customer_id',$this->customer_id)->with('counting_unit')->get();
    //          $item_lists = array();
    //         foreach($vouchers as $voucher){
    //             foreach($voucher->counting_unit as $counting_unit){
    //                 $voucher_code = $voucher->voucher_code;
    //                 $voucher_date = $voucher->voucher_date;
    //                 $customer_name = $voucher->sales_customer_name;
    //                 $unit_name = $counting_unit->unit_name;
    //                 $unit_code = $counting_unit->unit_code;
    //                 $qty = $counting_unit->pivot->quantity;
    //                 $price = $counting_unit->pivot->price;
    //                 $combined = array('voucher_code' => $voucher_code, 'voucher_date' => $voucher_date, 'customer_name' => $customer_name,'unit_name' => $unit_name, 'unit_code' => $unit_code, 'quantity' => $qty, 'price' =>$price );

    //                 array_push($item_lists, $combined);
    //             }
    //         }
    //         dd(new Collection($item_lists));
    //         return new Collection($item_lists);
    //     }
    //     }
    //   //return Voucher::all();
    // }
    
    public function array() :array
    {
        if($this->type == 1){
        if($this->customer_id == 0){
            $orders = Order::whereBetween('order_date',[$this->from_date, $this->to_date])->get();
            $unpaid_orders = [];
            foreach($orders as $order){
                    if($order->advance_pay < $order->est_price){
                        $unpaid_order = [
                        
                        'order_code' => $order->order_number,
                        'order_date' => $order->order_date,
                        'order_status' => $order->status,
                        
                        'customer_name' => $order->name,
                        'customer_phone' => $order->phone,
                         'total_amount' => $order->est_price,
                        'paid_amount' => $order->advance_pay,
                        'outstanding' => $order->est_price - $order->advance_pay
                    ];
                    array_push($unpaid_orders,$unpaid_order);    
                    }
            }
            return $unpaid_orders;
        }else{
            $orders = Order::whereBetween('order_date',[$this->from_date, $this->to_date])->where('customer_id',$this->customer_id)->get();
            $unpaid_orders = [];
            foreach($orders as $order){
                    if($order->advance_pay < $order->est_price){
                        $unpaid_order = [
                        
                        'order_code' => $order->order_number,
                        'order_date' => $order->order_date,
                        'order_status' => $order->status,
                        
                        'customer_name' => $order->name,
                        'customer_phone' => $order->phone,
                         'total_amount' => $order->est_price,
                        'paid_amount' => $order->advance_pay,
                        'outstanding' => $order->est_price - $order->advance_pay
                    ];
                    array_push($unpaid_orders,$unpaid_order);    
                    }
            }
            return $unpaid_orders;
        }
        }else if($this->type == 2){
            if($this->customer_id == 0){
            $purchases = Purchase::whereBetween('purchase_date',[$this->from_date, $this->to_date])->get();
            $credit_purchases = [];
            foreach($purchases as $purchase){
                if($purchase->credit_amount > 0){
                    $repayments = SupplierPayCredit::where('purchase_id',$purchase->id)->get();
                 $total_repay_amount = 0;
                 foreach($repayments as $repayment){
                     $total_repay_amount += $repayment->pay_amount;
                 }
                 $remain_amount = $purchase->credit_amount - $total_repay_amount;
                    $credit_purchase = [
                    
                    'purchase_code' => $purchase->purchase_number,
                    'purchase_date' => $purchase->purchase_date,
                    'purchase_type' => $purchase->purchase_type,
                    
                    'supplier_name' => $purchase->supplier_name,
                    'total_amount' => $purchase->total_price,
                    'credit_amount' => $purchase->credit_amount,
                    'total_repay_amount' => $total_repay_amount,
                    'remain_amount' => $remain_amount
                    ];
                    array_push($credit_purchases,$credit_purchase);
                }
            }
            return $credit_purchases;
        }else{
            $purchases = Purchase::whereBetween('purchase_date',[$this->from_date, $this->to_date])->where('supplier_id',$this->customer_id)->get();
             $credit_purchases = [];
            foreach($purchases as $purchase){
                if($purchase->credit_amount > 0){
                    $repayments = SupplierPayCredit::where('purchase_id',$purchase->id)->get();
                 $total_repay_amount = 0;
                 foreach($repayments as $repayment){
                     $total_repay_amount += $repayment->pay_amount;
                 }
                 $remain_amount = $purchase->credit_amount - $total_repay_amount;
                    $credit_purchase = [
                    
                    'purchase_code' => $purchase->purchase_number,
                    'purchase_date' => $purchase->purchase_date,
                    'purchase_type' => $purchase->purchase_type,
                    
                    'supplier_name' => $purchase->supplier_name,
                    'total_amount' => $purchase->total_price,
                    'credit_amount' => $purchase->credit_amount,
                    'total_repay_amount' => $total_repay_amount,
                    'remain_amount' => $remain_amount
                    ];
                    array_push($credit_purchases,$credit_purchase);
                }
            }
            return $credit_purchases;
        }
        }
       //return Voucher::all();
    }
    
    // public function query(){
    //     return CountingUnit::query()->with('items');
    // }
    
    // public function map($unit):array{
    //     if($this->data_type ==1){
    //     return [
    //       $unit->voucher_code,
    //         $unit->voucher_date,
    //         $unit->sales_customer_name,
    //         $unit->total_quantity,
    //         $unit->total_price,
    //         $unit->discount,
    //     ];        
            
    //     }elseif($this->data_type == 2){
    //         return[
    //             $unit->voucher_code,
    //             $unit->voucher_date,
    //             $unit->customer_name,
    //             $unit->unit_name,
    //             $unit->unit_code,
    //             $unit->quantity,
    //             $unit->price,
    //         ];
    //     }
    // }
    
    
    
    public function headings():array{
        if($this->type == 1){
        return [
           'Order No.',
            'Order Date',
            'Order Status',
            'Customer Name',
            'Customer Phone',
            'Order Amount',
            'Advance Pay',
            'Outstanding'
        ];
        }else if($this->type == 2){
          return [
            'Purchase No.',
            'Purchase Date',
            'Purchase Type',
            'Supplier Name',
            'Purchase Amount',
            'Credit Amount',
            'Repay Amount',
            'Remain Amount'
            
        ];  
        }
    }
    
    
}