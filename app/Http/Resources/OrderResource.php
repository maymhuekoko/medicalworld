<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        $employee = $this->employee;

        if ($this->status == 1) {
            
            return [
                'id' => $this->id,
                'order_number' => $this->order_number,
                'name' => $this->name,
                'phone' => $this->phone,
                'order_date' => $this->order_date,
                'total_quantity' => $this->total_quantity,
                'status' => "Un-cofirm Order",
                'order_address' => $this->address,
                'est_price' => $this->est_price,
                'delivery_date' => "",
                'accepted_date' => "",
                'employee' => "",
                'employee_phone' => "",
            ];

        }elseif ($this->status == 2) {
            
            return [
                'id' => $this->id,
                'order_number' => $this->order_number,
                'name' => $this->name,
                'phone' => $this->phone,
                'order_date' => $this->order_date,
                'total_quantity' => $this->total_quantity,
                'status' => "Cofirm Order",
                'order_address' => $this->address,
                'est_price' => $this->est_price,
                'delivery_date' => $this->delivered_date,
                'accepted_date' => "",
                'employee' => "",
                'employee_phone' => "",
            ];
        
        }elseif ($this->status == 3) {
           
            return [
                'id' => $this->id,
                'order_number' => $this->order_number,
                'name' => $this->name,
                'phone' => $this->phone,
                'order_date' => $this->order_date,
                'total_quantity' => $this->total_quantity,
                'status' => "Changes Order",
                'order_address' => $this->address,
                'est_price' => $this->est_price,
                'delivery_date' => $this->delivered_date,
                'accepted_date' => "",
                'employee' => "",
                'employee_phone' => "",
            ];
        
        }elseif ($this->status == 4) {
           
            return [
                'id' => $this->id,
                'order_number' => $this->order_number,
                'name' => $this->name,
                'phone' => $this->phone,
                'order_date' => $this->order_date,
                'total_quantity' => $this->total_quantity,
                'status' => "Delivered Order",
                'order_address' => $this->address,
                'est_price' => $this->est_price,
                'delivery_date' => $this->delivered_date,
                'accepted_date' => "",
                'employee' => $employee->user->name,
                'employee_phone' => $employee->phone,
            ];
        
        }else{

            return [
                'id' => $this->id,
                'order_number' => $this->order_number,
                'name' => $this->name,
                'phone' => $this->phone,
                'order_date' => $this->order_date,
                'total_quantity' => $this->total_quantity,
                'status' => "Accepted Order",
                'order_address' => $this->address,
                'est_price' => $this->est_price,
                'delivery_date' => $this->delivered_date,
                'accepted_date' => $this->accepted_date,
                'employee' => $employee->user->name,
                'employee_phone' => $employee->phone,
            ];
        }
        
    }
}
