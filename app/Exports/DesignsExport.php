<?php

namespace App\Exports;

use App\Design;
use Maatwebsite\Excel\Concerns\FromCollection;

class DesignsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Design::all();
    }
}
