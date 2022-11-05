<?php

namespace App\Exports;

use App\Size;
use Maatwebsite\Excel\Concerns\FromCollection;

class SizesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Size::all();
    }
}
