<?php

namespace App\Imports;

use App\CountingUnit;
use App\Stockcount;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Collection;


use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CountingUnitImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return Model|null
    */
    // public function model(array $row)
    // {

    //     return new CountingUnit([
    //         'unit_code'=>$row['code'],
    //         'unit_name'=>$row['name'],
    //         'current_quantity'=>$row['instock_qty'],
    //         'reorder_quantity'=>$row['reorder_qty'],
    //         'order_price'=>$row['normal_price'],
    //         'purchase_price'=>$row['purchase_price'],
    //         'item_id'=>$row['item_id'],
    //         'design_id'=>$row['design_id'],
    //         'fabric_id'=>$row['fabric_id'],
    //         'colour_id'=>$row['color_id'],
    //         'size_id'=>$row['size_id'],
    //         'gender_id'=>$row['gender_id'],
    //     ]);


    // }
    
     public function collection(Collection $rows)
    {
        foreach($rows as $row){
            
            if($row->filter()->isNotEmpty()){
            $units = CountingUnit::where('unit_code',$row['code'])->orWhere('unit_name',$row['name'])->get();
            if($units){
                foreach($units as $unit){
                $unit->order_price = $row['normal_price'];
                $unit->purchase_price = $row['purchase_price'];
                $unit->item_id = $row['item_id'];
                $unit->design_id = $row['design_id'];
                $unit->fabric_id = $row['fabric_id'];
                $unit->colour_id = $row['color_id'];
                $unit->size_id = $row['size_id'];
                $unit->gender_id = $row['gender_id'];
                $unit->reorder_quantity = $row['reorder_qty'];
                $unit->save();
                }
            }else{
                $unit = new CountingUnit([
            'unit_code'=>$row['code'] ?? '',
            'unit_name'=>$row['name'] ?? '',
            'current_quantity'=>$row['instock_qty'],
            'reorder_quantity'=>$row['reorder_qty'],
            'order_price'=>$row['normal_price'],
            'purchase_price'=>$row['purchase_price'],
            'item_id'=>$row['item_id'],
            'design_id'=>$row['design_id'],
            'fabric_id'=>$row['fabric_id'],
            'colour_id'=>$row['color_id'],
            'size_id'=>$row['size_id'],
            'gender_id'=>$row['gender_id'],
                ]);
                $unit->save();
            }
            }
            
        }   
    }


}
