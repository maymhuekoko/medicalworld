<?php

namespace App\Http\Controllers;

use App\Design;
use App\Imports\FactoryItemImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class FactoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

//   Import
    public function import(Request $request)
    {
        $designs = Excel::import(new FactoryItemImport(),$request->file(('import_file')));
        alert()->success('Excel Import Succeeded');
        return redirect()->back();
    }
 
}
