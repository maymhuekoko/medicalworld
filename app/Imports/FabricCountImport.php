<?php

namespace App\Imports;

use App\FabricCount;


use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Collection;


use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FabricCountImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return Model|null
    */
    public function model(array $row)
    {

        return new FabricCount([
             'factory_item_id' =>$row['factory_item_id'], 
            'factory_item_name' =>$row['factory_item_name'], 
            'count_date' =>$row['count_date'],
            'open_stock' =>$row['open_stock'],
            'in_stock' =>$row['in_stock'],
            'out_stock' =>$row['out_stock'],
            'close_stock' =>$row['close_stock'],
            'remark' =>$row['remark'],
        ]);


    }


}
