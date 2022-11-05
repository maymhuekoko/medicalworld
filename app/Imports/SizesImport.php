<?php

namespace App\Imports;

use App\Size;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SizesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Size([
            'size_name'=>$row['size_name'],
            'size_description'=>$row['size_description'],
            'gender_id'=>$row['gender_id']
        ]);
    }
}
