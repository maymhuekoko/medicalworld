<?php

namespace App\Imports;

use App\Colour;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ColourImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Colour([
            'colour_name'=>$row['colour_name'],
            'colour_description'=>$row['colour_description'],
            'fabric_id'=>$row['fabric_id'],
        ]);
    }
}
