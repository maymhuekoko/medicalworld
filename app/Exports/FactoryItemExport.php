<?php

namespace App\Exports;

use App\FactoryItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FactoryItemExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return FactoryItem::all();
    }
    
    public function headings():array{
     
        return [
            'id',
            'item_name', 
            'category_id',
            'subcategory_id',
            'purchase_price',
            'instock_qty',
            'reserved_qty',
            'created_at',
            'updated_at',
            'item_code',
            'created_by',
        ];
        
    }
}
