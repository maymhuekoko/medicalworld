<?php

namespace App\Exports;

use App\SubCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubCategoryExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SubCategory::all();
    }
    
        public function headings():array{
     
        return [
            'No.',
           'subcategory_code',
           'name',
           'category_id',
           'created_at',
           'updated_at',
           'type_flag'
        ];
        
    }
}
