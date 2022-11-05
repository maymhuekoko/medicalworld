<?php

namespace App\Imports;

use App\SubCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubcategoryImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SubCategory([
            'subcategory_code'=>$row['code'] ?? 'default_code',
            'name'=>$row['name'],
            'category_id'=>$row['cat_id']??1,
            'type_flag'=>$row['type_flag'],
        ]);
    }
}
