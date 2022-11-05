<?php

namespace App\Imports;

use App\Design;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DesignsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Design([
            'design_name'=>$row['design_name'],
            'design_description'=>$row['design_description'],
        ]);
    }
}
