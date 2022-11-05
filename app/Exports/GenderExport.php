<?php

namespace App\Exports;

use App\Gender;
use Maatwebsite\Excel\Concerns\FromCollection;

class GenderExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Gender::all();
    }
}
