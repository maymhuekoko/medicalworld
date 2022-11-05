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

class TotalOrderHistoryExport implements FromArray,ShouldAutoSize,WithHeadings
{
    use Exportable;
    
    protected $from_date;
    protected $to_date;
    protected $customer_id;
    protected $order_by;
    protected $order_type;
    protected $data_type;
    
    public function __construct($from,$to,$customer,$order_by,$order_type,$data_type){
        $this->from_date = $from;
        $this->to_date = $to;
        $this->customer_id = $customer;
        $this->order_by = $order_by;
        $this->order_type = $order_type;
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
        if($this->customer_id == 0 && $this->order_by == 'All'){
            $orders = Order::whereBetween('order_date',[$this->from_date, $this->to_date])->where('status',$this->order_type)->get();
            $order_lists = array();
            foreach($orders as $order){
                    $order_number = $order->order_number;
                    $order_date = $order->order_date;
                    $order_by = $order->order_by ?? '';
                    $customer_name = $order->name;
                    $customer_phone = $order->phone;
                    $customer_address = $order->address;
                    $showroom = $order->showroom;
                    $qty = $order->total_quantity;
                    $price = $order->est_price;
                    $discount = $order->total_discount_value;
                    $advance = $order->advance_pay;
                    $outstanding = $order->collect_amount;
                    $combined = array('order_number' => $order_number, 'order_date' => $order_date, 'order_by' => $order_by, 'customer_name' => $customer_name, 'customer_phone' => $customer_phone, 'customer_address' => $customer_address, 'showroom' => $showroom, 'quantity' => $qty, 'price' =>$price, 'discount' => $discount, 'advance' => $advance, 'outstanding' => $outstanding );

                    array_push($order_lists, $combined);
                
            }
            return $order_lists;
        }else if($this->customer_id == 0 && $this->order_by != 'All'){
            $orders = Order::whereBetween('order_date',[$this->from_date, $this->to_date])->where('status',$this->order_type)->where('order_by',$this->order_by)->get();
            $order_lists = array();
            foreach($orders as $order){
                    $order_number = $order->order_number;
                    $order_date = $order->order_date;
                    $order_by = $order->order_by ?? '';
                    $customer_name = $order->name;
                    $customer_phone = $order->phone;
                    $customer_address = $order->address;
                    $showroom = $order->showroom;
                    $qty = $order->total_quantity;
                    $price = $order->est_price;
                    $discount = $order->total_discount_value;
                    $advance = $order->advance_pay;
                    $outstanding = $order->collect_amount;
                    $combined = array('order_number' => $order_number, 'order_date' => $order_date, 'order_by' => $order_by, 'customer_name' => $customer_name, 'customer_phone' => $customer_phone, 'customer_address' => $customer_address, 'showroom' => $showroom, 'quantity' => $qty, 'price' =>$price, 'discount' => $discount, 'advance' => $advance, 'outstanding' => $outstanding );

                    array_push($order_lists, $combined);
                
            }
            return $order_lists;
        }else if($this->customer_id != 0 && $this->order_by == 'All'){
            $orders = Order::whereBetween('order_date',[$this->from_date, $this->to_date])->where('status',$this->order_type)->where('customer_id',$this->customer_id)->get();
            $order_lists = array();
            foreach($orders as $order){
                    $order_number = $order->order_number;
                    $order_date = $order->order_date;
                    $order_by = $order->order_by ?? '';
                    $customer_name = $order->name;
                    $customer_phone = $order->phone;
                    $customer_address = $order->address;
                    $showroom = $order->showroom;
                    $qty = $order->total_quantity;
                    $price = $order->est_price;
                    $discount = $order->total_discount_value;
                    $advance = $order->advance_pay;
                    $outstanding = $order->collect_amount;
                    $combined = array('order_number' => $order_number, 'order_date' => $order_date, 'order_by' => $order_by, 'customer_name' => $customer_name, 'customer_phone' => $customer_phone, 'customer_address' => $customer_address, 'showroom' => $showroom, 'quantity' => $qty, 'price' =>$price, 'discount' => $discount, 'advance' => $advance, 'outstanding' => $outstanding );

                    array_push($order_lists, $combined);
                
            }
            return $order_lists;
        }
        else{
            $orders = Order::whereBetween('order_date',[$this->from_date, $this->to_date])->where('status',$this->order_type)->where('order_by',$this->order_by)->where('customer_id',$this->customer_id)->get();
            $order_lists = array();
            foreach($orders as $order){
                    $order_number = $order->order_number;
                    $order_date = $order->order_date;
                    $order_by = $order->order_by ?? '';
                    $customer_name = $order->name;
                    $customer_phone = $order->phone;
                    $customer_address = $order->address;
                    $showroom = $order->showroom;
                    $qty = $order->total_quantity;
                    $price = $order->est_price;
                    $discount = $order->total_discount_value;
                    $advance = $order->advance_pay;
                    $outstanding = $order->collect_amount;
                    $combined = array('order_number' => $order_number, 'order_date' => $order_date, 'order_by' => $order_by, 'customer_name' => $customer_name, 'customer_phone' => $customer_phone, 'customer_address' => $customer_address, 'showroom' => $showroom, 'quantity' => $qty, 'price' =>$price, 'discount' => $discount, 'advance' => $advance, 'outstanding' => $outstanding );

                    array_push($order_lists, $combined);
                
            }
            return $order_lists;
        }
        }else if($this->data_type == 2){
            if($this->customer_id == 0 && $this->order_by == 'All'){
            $orders = Order::whereBetween('order_date',[$this->from_date, $this->to_date])->where('status',$this->order_type)->get();
            $item_lists = array();
            foreach($orders as $order){
                    $custom_units = CustomUnitOrder::where('order_id',$order->id)->get();
                    foreach($custom_units as $unit){
                    $order_number = $order->order_number;
                    $order_date = $order->order_date;
                    $order_by = $order->order_by ?? '';
                    $customer_name = $order->name;
                    $customer_phone = $order->phone;
                    $unit_name = $unit->design_name . ' ' . $unit->fabric_name;
                    $unit_color = $unit->colour_name;
                    $unit_size = $unit->size_name;
                    $price = $unit->selling_price;
                    $qty = $unit->order_qty;
                    $combined = array( 'unit_name' => $unit_name, 'unit_color' => $unit_color, 'unit_size' => $unit_size, 'price' => $price, 'quantity' => $qty,'order_number' => $order_number, 'order_date' => $order_date, 'order_by' => $order_by, 'customer_name' => $customer_name, 'customer_phone' => $customer_phone);

                    array_push($item_lists, $combined);
                }
            }
            
            return $item_lists;
        }else if($this->customer_id == 0 && $this->order_by != 'All'){
            $orders = Order::whereBetween('order_date',[$this->from_date, $this->to_date])->where('status',$this->order_type)->where('order_by',$this->order_by)->get();
            
            $item_lists = array();
            foreach($orders as $order){
                    $custom_units = CustomUnitOrder::where('order_id',$order->id)->get();
                    foreach($custom_units as $unit){
                    $order_number = $order->order_number;
                    $order_date = $order->order_date;
                    $order_by = $order->order_by ?? '';
                    $customer_name = $order->name;
                    $customer_phone = $order->phone;
                    $unit_name = $unit->design_name . ' ' . $unit->fabric_name;
                    $unit_color = $unit->colour_name;
                    $unit_size = $unit->size_name;
                    $price = $unit->selling_price;
                    $qty = $unit->order_qty;
                    $combined = array( 'unit_name' => $unit_name, 'unit_color' => $unit_color, 'unit_size' => $unit_size, 'price' => $price, 'quantity' => $qty,'order_number' => $order_number, 'order_date' => $order_date, 'order_by' => $order_by, 'customer_name' => $customer_name, 'customer_phone' => $customer_phone);

                    array_push($item_lists, $combined);
                }
            }
            
            return $item_lists;
        }else if($this->customer_id != 0 && $this->order_by == 'All'){
            $orders = Order::whereBetween('order_date',[$this->from_date, $this->to_date])->where('status',$this->order_type)->where('customer_id',$this->customer_id)->get();
        
            $item_lists = array();
            foreach($orders as $order){
                    $custom_units = CustomUnitOrder::where('order_id',$order->id)->get();
                    foreach($custom_units as $unit){
                    $order_number = $order->order_number;
                    $order_date = $order->order_date;
                    $order_by = $order->order_by ?? '';
                    $customer_name = $order->name;
                    $customer_phone = $order->phone;
                    $unit_name = $unit->design_name . ' ' . $unit->fabric_name;
                    $unit_color = $unit->colour_name;
                    $unit_size = $unit->size_name;
                    $price = $unit->selling_price;
                    $qty = $unit->order_qty;
                    $combined = array( 'unit_name' => $unit_name, 'unit_color' => $unit_color, 'unit_size' => $unit_size, 'price' => $price, 'quantity' => $qty,'order_number' => $order_number, 'order_date' => $order_date, 'order_by' => $order_by, 'customer_name' => $customer_name, 'customer_phone' => $customer_phone);

                    array_push($item_lists, $combined);
                }
            }
            
            return $item_lists;
        }else{
            $orders = Order::whereBetween('order_date',[$this->from_date, $this->to_date])->where('status',$this->order_type)->where('order_by',$this->order_by)->where('customer_id',$this->customer_id)->get();
             $item_lists = array();
            foreach($orders as $order){
                    $custom_units = CustomUnitOrder::where('order_id',$order->id)->get();
                    foreach($custom_units as $unit){
                    $order_number = $order->order_number;
                    $order_date = $order->order_date;
                    $order_by = $order->order_by ?? '';
                    $customer_name = $order->name;
                    $customer_phone = $order->phone;
                    $unit_name = $unit->design_name . ' ' . $unit->fabric_name;
                    $unit_color = $unit->colour_name;
                    $unit_size = $unit->size_name;
                    $price = $unit->selling_price;
                    $qty = $unit->order_qty;
                    $combined = array( 'unit_name' => $unit_name, 'unit_color' => $unit_color, 'unit_size' => $unit_size, 'price' => $price, 'quantity' => $qty,'order_number' => $order_number, 'order_date' => $order_date, 'order_by' => $order_by, 'customer_name' => $customer_name, 'customer_phone' => $customer_phone);

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
            'Order Number',
            'Order Date',
            'Order By',
            'Customer Name',
            'Customer Phone',
            'Customer Address',
            'Showroom',
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
            'Order Number',
            'Order Date',
            'Order By',
            'Customer Name',
            'Customer Phone',
        ];
        }
    }
    
    
}