<?php

namespace App\Imports;

use App\Item;
use App\User;
use App\Stockcount;
use App\CountingUnit;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use function PHPSTORM_META\elementType;

class ItemsImport implements ToCollection,WithHeadingRow
{
    public function collection(Collection $rows)
    {

        foreach($rows as $row){
        if($row->filter()->isNotEmpty()){
        $last_item = Item::get()->last();
        if($last_item){
            $last_id = $last_item->id;
        }
        else{
            $last_id = 1;
        }
        $item_code = sprintf("%04s", ($last_id + 1));
            $itemId= new Item([
              'item_name'=> $row['item_name']?? "default item name",
                'item_code'=> $row['item_code'],
                'created_by'=> "MDW-001" ?? "null",
              'photo_path'=> "default.png" ?? "default photo path",
              'category_id'=> $row['category_id'] ?? "1",
              'sub_category_id'=> $row['sub_category_id'] ?? "1",
              'customer_console'=> 0,
              'unit_name'=>$row['item_unit_name'] ?? "null",
           ]);
           $itemId->save();
           
           if($itemId !=null){
                $itemId->froms()->attach(1);
            }

//            for ($i=1; $i <= (int)$row['size_total']; $i++) {
//                $countingunit_id  = new CountingUnit([
//                    'item_id'             => $itemId->id,
//                    'unit_code'=>$row["size_$i"] ?? "default code",
//                    'unit_name'=>$row["name_$i"] ?? "Default Name",
//                    'current_quantity'=>0 ,
//                    'reorder_quantity'=>$row["reorder_qty_$i"] ?? 1,
//                    'normal_sale_price'=>$row["normal_price_$i"] ?? 1,
//                    'whole_sale_price'=>$row["whole_price_$i"] ?? 1,
//                    'order_price'=>$row["order_price_$i"] ?? 1,
//                    'purchase_price'=>$row["purchase_price_$i"] ?? 1,
//                    'normal_fixed_flash'=>0,
//                    'normal_fixed_percent'=>0,
//                    'whole_fixed_flash'=>0,
//                    'whole_fixed_percent'=>0,
//                    'order_fixed_flash'=>0,
//                    'order_fixed_percent'=>0,
//                ]);
//                $countingunit_id->save();
//            }
        }
        }

    }
}

