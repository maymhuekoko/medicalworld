<?php

namespace App\Imports;

use App\FactoryItem;


use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Collection;


use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FactoryItemImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return Model|null
    */
    public function model(array $row)
    {

        return new FactoryItem([
             'item_code' =>$row['item_code'], 
            'item_name' =>$row['item_name'], 
            'created_by' =>$row['created_by'],
            'category_id' =>$row['category_id'],
             'subcategory_id' =>$row['subcategory_id'],
            'purchase_price' =>$row['purchase_price'],
            'instock_qty' =>$row['instock_qty'],
            'reserved_qty' =>$row['reserved_qty'],
        ]);


    }


}
