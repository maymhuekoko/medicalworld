<?php

namespace App\Exports;

use App\Voucher;
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

class SalesHistoryExport implements FromArray,ShouldAutoSize,WithHeadings
{
    use Exportable;
    
    protected $from_date;
    protected $to_date;
    protected $customer_id;
    protected $sales;
    protected $data_type;
    
    public function __construct($from,$to,$customer,$sales,$data_type){
        $this->from_date = $from;
        $this->to_date = $to;
        $this->customer_id = $customer;
        $this->sales = $sales;
        $this->data_type = $data_type;
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
        if($this->data_type == 1){
        if($this->customer_id == 0 && $this->sales == 'All'){
            $vouchers = Voucher::whereBetween('voucher_date',[$this->from_date, $this->to_date])->get();
            $voucher_lists = array();
            foreach($vouchers as $voucher){
                
                    $voucher_code = $voucher->voucher_code;
                    $voucher_date = $voucher->voucher_date;
                    $customer_name = $voucher->sales_customer_name;
                    $qty = $voucher->total_quantity;
                    $price = $voucher->total_price;
                    $discount = $voucher->discount_value;
                    $sale_by = $voucher->sale_by;
                    $combined = array('voucher_code' => $voucher_code, 'voucher_date' => $voucher_date, 'customer_name' => $customer_name, 'quantity' => $qty, 'price' =>$price, 'discount' => $discount, 'sale_by' => $sale_by);

                    array_push($voucher_lists, $combined);
                
            }
            return $voucher_lists;
        }else if($this->customer_id == 0 && $this->sales != 'All'){
            $vouchers = Voucher::whereBetween('voucher_date',[$this->from_date, $this->to_date])->where('sale_by',$this->sales)->get();
            $voucher_lists = array();
            foreach($vouchers as $voucher){
                
                    $voucher_code = $voucher->voucher_code;
                    $voucher_date = $voucher->voucher_date;
                    $customer_name = $voucher->sales_customer_name;
                    $qty = $voucher->total_quantity;
                    $price = $voucher->total_price;
                    $discount = $voucher->discount_value;
                    $sale_by = $voucher->sale_by;
                    $combined = array('voucher_code' => $voucher_code, 'voucher_date' => $voucher_date, 'customer_name' => $customer_name, 'quantity' => $qty, 'price' =>$price, 'discount' => $discount, 'sale_by' => $sale_by);

                    array_push($voucher_lists, $combined);
                
            }
            return $voucher_lists;
        }else if($this->customer_id != 0 && $this->sales == 'All'){
            $vouchers = Voucher::whereBetween('voucher_date',[$this->from_date, $this->to_date])->where('sales_customer_id',$this->customer_id)->get();
            $voucher_lists = array();
            foreach($vouchers as $voucher){
                
                    $voucher_code = $voucher->voucher_code;
                    $voucher_date = $voucher->voucher_date;
                    $customer_name = $voucher->sales_customer_name;
                    $qty = $voucher->total_quantity;
                    $price = $voucher->total_price;
                    $discount = $voucher->discount_value;
                    $sale_by = $voucher->sale_by;
                    $combined = array('voucher_code' => $voucher_code, 'voucher_date' => $voucher_date, 'customer_name' => $customer_name, 'quantity' => $qty, 'price' =>$price, 'discount' => $discount, 'sale_by' => $sale_by );

                    array_push($voucher_lists, $combined);
                
            }
            return $voucher_lists;
        }else{
            $vouchers = Voucher::whereBetween('voucher_date',[$this->from_date, $this->to_date])->where('sales_customer_id',$this->customer_id)->where('sale_by',$this->sales)->get();
            $voucher_lists = array();
            foreach($vouchers as $voucher){
                
                    $voucher_code = $voucher->voucher_code;
                    $voucher_date = $voucher->voucher_date;
                    $customer_name = $voucher->sales_customer_name;
                    $qty = $voucher->total_quantity;
                    $price = $voucher->total_price;
                    $discount = $voucher->discount_value;
                    $sale_by = $voucher->sale_by;
                    $combined = array('voucher_code' => $voucher_code, 'voucher_date' => $voucher_date, 'customer_name' => $customer_name, 'quantity' => $qty, 'price' =>$price, 'discount' => $discount, 'sale_by' => $sale_by );

                    array_push($voucher_lists, $combined);
                
            }
            return $voucher_lists;
        }
        }else if($this->data_type == 2){
            if($this->customer_id == 0 && $this->sales == 'All'){
            $vouchers = Voucher::whereBetween('voucher_date',[$this->from_date, $this->to_date])->with('counting_unit')->get();
            $item_lists = array();
            foreach($vouchers as $voucher){
                foreach($voucher->counting_unit as $counting_unit){
                    $voucher_code = $voucher->voucher_code;
                    $voucher_date = $voucher->voucher_date;
                    $customer_name = $voucher->sales_customer_name;
                    $sale_by = $voucher->sale_by;
                    $unit_name = $counting_unit->unit_name;
                    $unit_code = $counting_unit->unit_code;
                    $qty = $counting_unit->pivot->quantity;
                    $sale_price = $counting_unit->pivot->price;
                    $order_price = $counting_unit->order_price;
                    $combined = array('unit_name' => $unit_name, 'unit_code' => $unit_code, 'quantity' => $qty, 'order_price' =>$order_price,'sale_price' => $sale_price, 'voucher_code' => $voucher_code, 'voucher_date' => $voucher_date, 'customer_name' => $customer_name, 'sale_by' => $sale_by );

                    array_push($item_lists, $combined);
                }
            }
            return $item_lists;
        }else if($this->customer_id == 0 && $this->sales != 'All'){
            $vouchers = Voucher::whereBetween('voucher_date',[$this->from_date, $this->to_date])->where('sale_by',$this->sales)->with('counting_unit')->get();
            $item_lists = array();
            foreach($vouchers as $voucher){
                foreach($voucher->counting_unit as $counting_unit){
                    $voucher_code = $voucher->voucher_code;
                    $voucher_date = $voucher->voucher_date;
                    $customer_name = $voucher->sales_customer_name;
                    $sale_by = $voucher->sale_by;
                    $unit_name = $counting_unit->unit_name;
                    $unit_code = $counting_unit->unit_code;
                    $qty = $counting_unit->pivot->quantity;
                    $sale_price = $counting_unit->pivot->price;
                    $order_price = $counting_unit->order_price;
                    $combined = array('unit_name' => $unit_name, 'unit_code' => $unit_code, 'quantity' => $qty, 'order_price' =>$order_price,'sale_price' => $sale_price, 'voucher_code' => $voucher_code, 'voucher_date' => $voucher_date, 'customer_name' => $customer_name, 'sale_by' => $sale_by);

                    array_push($item_lists, $combined);
                }
            }
            
            return $item_lists;
        }else if($this->customer_id != 0 && $this->sales == 'All'){
            $vouchers = Voucher::whereBetween('voucher_date',[$this->from_date, $this->to_date])->where('sales_customer_id',$this->customer_id)->with('counting_unit')->get();
             $item_lists = array();
            foreach($vouchers as $voucher){
                foreach($voucher->counting_unit as $counting_unit){
                    $voucher_code = $voucher->voucher_code;
                    $voucher_date = $voucher->voucher_date;
                    $customer_name = $voucher->sales_customer_name;
                    $sale_by = $voucher->sale_by;
                    $unit_name = $counting_unit->unit_name;
                    $unit_code = $counting_unit->unit_code;
                    $qty = $counting_unit->pivot->quantity;
                    $sale_price = $counting_unit->pivot->price;
                    $order_price = $counting_unit->order_price;
                    $combined = array('unit_name' => $unit_name, 'unit_code' => $unit_code, 'quantity' => $qty, 'order_price' =>$order_price,'sale_price' => $sale_price, 'voucher_code' => $voucher_code, 'voucher_date' => $voucher_date, 'customer_name' => $customer_name, 'sale_by' => $sale_by);

                    array_push($item_lists, $combined);
                }
            }
            
            return $item_lists;
        }else{
            $vouchers = Voucher::whereBetween('voucher_date',[$this->from_date, $this->to_date])->where('sales_customer_id',$this->customer_id)->where('sale_by',$this->sales)->with('counting_unit')->get();
             $item_lists = array();
            foreach($vouchers as $voucher){
                foreach($voucher->counting_unit as $counting_unit){
                    $voucher_code = $voucher->voucher_code;
                    $voucher_date = $voucher->voucher_date;
                    $customer_name = $voucher->sales_customer_name;
                    $sale_by = $voucher->sale_by;
                    $unit_name = $counting_unit->unit_name;
                    $unit_code = $counting_unit->unit_code;
                    $qty = $counting_unit->pivot->quantity;
                    $sale_price = $counting_unit->pivot->price;
                    $order_price = $counting_unit->order_price;
                    $combined = array('unit_name' => $unit_name, 'unit_code' => $unit_code, 'quantity' => $qty, 'order_price' =>$order_price,'sale_price' => $sale_price, 'voucher_code' => $voucher_code, 'voucher_date' => $voucher_date, 'customer_name' => $customer_name, 'sale_by' => $sale_by);

                    array_push($item_lists, $combined);
                }
            }
            
            return $item_lists;
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
        if($this->data_type == 1){
        return [
           'Voucher Number',
            'Voucher Date',
            'Customer Name',
            'Total Quantity',
            'Total Price',
            'Discount',
            'Sale By'
        ];
        }else if($this->data_type == 2){
          return [
            'Unit Name',
            'Unit Code',
            'Quantity',
            'Normal Price',
            'Sale Price',
            'Voucher Number',
            'Voucher Date',
            'Customer Name',
            'Sale By'
        ];  
        }
    }
    
    
}