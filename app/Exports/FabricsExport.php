<?php

namespace App\Exports;

use App\Fabric;
use Maatwebsite\Excel\Concerns\FromCollection;

class FabricsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Fabric::all();
    }
}
