<?php

namespace App\Imports;

use App\FabricEntryItem;


use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Collection;


use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FabricEntryImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return Model|null
    */
    public function model(array $row)
    {

        return new FabricEntryItem([
             'factory_item_id' =>$row['factory_item_id'], 
            'factory_item_name' =>$row['factory_item_name'], 
            'instock_qty' =>$row['instock_qty'],
            
        ]);


    }


}
