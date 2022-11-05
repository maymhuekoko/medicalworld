<?php

namespace App\Exports;

use App\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ItemExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Item::all();
    }
    
    public function headings():array{
     
        return [
            'No.',
           'item_code',
            'item_name',
            'created_by',
            'customer_console',
            'photo_path',
            'category_id',
            'sub_category_id',
            'deleted_at',
            'created_at',
            'updated_at',
            'unit_name'
        ];
        
    }
}
