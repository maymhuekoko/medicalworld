<?php

namespace App\Http\Controllers;

use App\Design;
use App\Exports\DesignsExport;
use App\Imports\DesignsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DesignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }
//    Export
    public function export()
    {
        return Excel::download(new DesignsExport(),'designs.xlsx');
    }
//   Import
    public function import(Request $request)
    {
        $designs = Excel::import(new DesignsImport(),$request->file(('import_file')));
        alert()->success('Excel Import Succeeded');
        return redirect()->back();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//       return $request;
        $request->validate([
            "design_name"=> "required|min:2",
            "design_description"=> "nullable",
        ]);
        $design = new Design();
        $design->design_name = $request->design_name;
        $design->design_description = $request->design_description;
        $design->save();
        alert()->success('Successfully Added');
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function show(Design $design)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Design $design,$id)
    {
        $design = Design::find($id);
        $design->design_name = $request->design_name;
        $design->design_description = $request->design_description;
        $design->save();

        alert()->success('Successfully Updated!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function destroy(Design $design,$id)
    {
        $design= Design::find($id);
        $design->delete();
        alert()->success('Successfully Deleted');
        return redirect()->back();
    }
}
