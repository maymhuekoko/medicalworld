<?php

namespace App\Imports;

use App\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Category([
            'category_code'=>$row['code'] ?? 'default_code',
            'category_name'=>$row['name'],
            'type_flag'=>1,
            'created_by'=>'MDW-001',
        ]);
    }
}
