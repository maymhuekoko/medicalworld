<?php

namespace App\Imports;

use App\Fabric;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FabricsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Fabric([
            'fabric_name'=>$row['fabric_name'],
            'fabric_description'=>$row['fabric_description'],
        ]);
    }
}
