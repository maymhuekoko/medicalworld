<?php

namespace App\Exports;

use App\Order;
use App\OrderVoucher;
use App\CustomUnitOrder;
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

class OrderHistoryExport implements FromArray,ShouldAutoSize,WithHeadings
{
    use Exportable;
    
    protected $from_date;
    protected $to_date;
    protected $customer_id;
    protected $data_type;
    
    public function __construct($from,$to,$customer,$data_type){
        $this->from_date = $from;
        $this->to_date = $to;
        $this->customer_id = $customer;
        $this->data_type = $data_type;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     if($this->customer_id == 0){
    //   return OrderVoucher::whereBetween('voucher_date',[$this->from_date, $this->to_date])->get();
    //     }else{
    //         return OrderVoucher::whereBetween('voucher_date',[$this->from_date, $this->to_date])->where('sales_customer_id',$this->customer_id)->get();
    //     }
    //   //return OrderVoucher::all();
        
    // }
    public function array() :array
    {
        if($this->data_type == 1){
        if($this->customer_id == 0){
            $vouchers = OrderVoucher::whereBetween('voucher_date',[$this->from_date, $this->to_date])->get();
            $voucher_lists = array();
            foreach($vouchers as $voucher){
                    $order = Order::where('id',$voucher->order_id)->first();
                    $voucher_number = $voucher->voucher_number;
                    $voucher_date = $voucher->voucher_date;
                    $customer_name = $voucher->sales_customer_name;
                    $customer_phone = $order->phone;
                    $customer_address = $order->address;
                    $order_date = $voucher->order_date;
                    $showroom = $order->showroom;
                    $delivered_date = $voucher->delivered_date;
                    $delivered_remark = $order->delivered_remark;
                    $qty = $voucher->total_quantity;
                    $price = $voucher->total_price;
                    $discount = $voucher->discount_value;
                    $advance = $voucher->advance;
                    $outstanding = $voucher->outstanding;
                    $combined = array('voucher_number' => $voucher_number, 'voucher_date' => $voucher_date, 'customer_name' => $customer_name, 'customer_phone' => $customer_phone, 'customer_address' => $customer_address, 'order_date' => $order_date, 'showroom' => $showroom, 'delivered_date' => $delivered_date, 'delivered_remark' => $delivered_remark, 'quantity' => $qty, 'price' =>$price, 'discount' => $discount, 'advance' => $advance, 'outstanding' => $outstanding );

                    array_push($voucher_lists, $combined);
                
            }
            return $voucher_lists;
        }else{
            $vouchers = OrderVoucher::whereBetween('voucher_date',[$this->from_date, $this->to_date])->where('sales_customer_id',$this->customer_id)->get();
            $voucher_lists = array();
           foreach($vouchers as $voucher){
                    $order = Order::where('id',$voucher->order_id)->first();
                    $voucher_number = $voucher->voucher_number;
                    $voucher_date = $voucher->voucher_date;
                    $customer_name = $voucher->sales_customer_name;
                    $customer_phone = $order->phone;
                    $customer_address = $order->address;
                    $order_date = $voucher->order_date;
                    $showroom = $order->showroom;
                    $delivered_date = $voucher->delivered_date;
                    $delivered_remark = $order->delivered_remark;
                    $qty = $voucher->total_quantity;
                    $price = $voucher->total_price;
                    $discount = $voucher->discount_value;
                    $advance = $voucher->advance;
                    $outstanding = $voucher->outstanding;
                    $combined = array('voucher_number' => $voucher_number, 'voucher_date' => $voucher_date, 'customer_name' => $customer_name, 'customer_phone' => $customer_phone, 'customer_address' => $customer_address, 'order_date' => $order_date, 'showroom' => $showroom, 'delivered_date' => $delivered_date, 'delivered_remark' => $delivered_remark, 'quantity' => $qty, 'price' =>$price, 'discount' => $discount, 'advance' => $advance, 'outstanding' => $outstanding );

                    array_push($voucher_lists, $combined);
                
            }
            return $voucher_lists;
        }
        }else if($this->data_type == 2){
            if($this->customer_id == 0){
            $vouchers = OrderVoucher::whereBetween('voucher_date',[$this->from_date, $this->to_date])->get();
            $item_lists = array();
            foreach($vouchers as $voucher){
                $order = Order::where('id',$voucher->order_id)->first();
                    $custom_units = CustomUnitOrder::where('order_id',$order->id)->get();
                    foreach($custom_units as $unit){
                    $voucher_number = $voucher->voucher_number;
                    $voucher_date = $voucher->voucher_date;
                    $customer_name = $voucher->sales_customer_name;
                    $customer_phone = $order->phone;
                    $unit_name = $unit->design_name . ' ' . $unit->fabric_name;
                    $unit_color = $unit->colour_name;
                    $unit_size = $unit->size_name;
                    $price = $unit->selling_price;
                    $qty = $unit->order_qty;
                    $combined = array( 'unit_name' => $unit_name, 'unit_color' => $unit_color, 'unit_size' => $unit_size, 'price' => $price, 'quantity' => $qty,'voucher_number' => $voucher_number, 'voucher_date' => $voucher_date, 'customer_name' => $customer_name, 'customer_phone' => $customer_phone);

                    array_push($item_lists, $combined);
                }
            }
            
            return $item_lists;
        }else{
            $voucher = OrderVoucher::whereBetween('voucher_date',[$this->from_date, $this->to_date])->where('sales_customer_id',$this->customer_id)->get();
             $item_lists = array();
            foreach($vouchers as $voucher){
                $order = Order::where('id',$voucher->order_id)->first();
                    $custom_units = CustomUnitOrder::where('order_id',$order->id)->get();
                    foreach($custom_units as $unit){
                    $voucher_number = $voucher->voucher_number;
                    $voucher_date = $voucher->voucher_date;
                    $customer_name = $voucher->sales_customer_name;
                    $customer_phone = $order->phone;
                    $unit_name = $unit->design_name . ' ' . $unit->fabric_name;
                    $unit_color = $unit->colour_name;
                    $unit_size = $unit->size_name;
                    $price = $unit->selling_price;
                    $qty = $unit->order_qty;
                    $combined = array('unit_name' => $unit_name, 'unit_color' => $unit_color, 'unit_size' => $unit_size, 'price' => $price, 'quantity' => $qty,'voucher_number' => $voucher_number, 'voucher_date' => $voucher_date, 'customer_name' => $customer_name, 'customer_phone' => $customer_phone);

                    array_push($item_lists, $combined);
                }
            }
            
            return $item_lists;
        }
        }
       //return Voucher::all();
    }
    
    
    public function headings():array{
        if($this->data_type == 1){
        return [
            'Voucher Number',
            'Voucher Date',
            'Customer Name',
            'Customer Phone',
            'Customer Address',
            'Order Date',
            'Showroom',
            'Deliver Date',
            'Deliver Remark',
            'Total Quantity',
            'Total Price',
            'Discount',
            'Advance',
            'Outstanding',
        ];
        }else if($this->data_type == 2){
            return [
            'Unit Name',
            'Unit Color',
            'Unit Size',
            'Selling Price',
            'Order Quantity',
            'Voucher Number',
            'Voucher Date',
            'Customer Name',
            'Customer Phone',
        ];
        }
    }
    
    
}