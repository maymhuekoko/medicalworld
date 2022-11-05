<?php

namespace App\Imports;

use App\Gender;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GenderImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Gender([
            'gender_name'=>$row['gender_name'],
            'gender_description'=>$row['gender_description'],
        ]);
    }
}
