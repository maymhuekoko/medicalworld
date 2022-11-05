<?php

namespace App\Exports;

use App\Colour;
use Maatwebsite\Excel\Concerns\FromCollection;

class ColourExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Colour::all();
    }
}
