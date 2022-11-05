<?php

namespace App\Http\Controllers;

use App\Exports\FabricsExport;
use App\Fabric;
use App\Imports\FabricsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FabricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function export()
    {
        return Excel::download(new FabricsExport(),'fabric.xlsx' );
    }

    //   Import
    public function import(Request $request)
    {
        $fabrics = Excel::import(new FabricsImport(),$request->file('import_file'));
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
        $request->validate([
            "fabric_name"=> "required|min:2",
        ]);
        $fabric = new Fabric();
        $fabric->fabric_name = $request->fabric_name;
        $fabric->fabric_description = $request->fabric_description;
        $fabric->save();
        alert()->success('Successfully Added');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fabric  $fabric
     * @return \Illuminate\Http\Response
     */
    public function show(Fabric $fabric)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fabric  $fabric
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fabric $fabric,$id)
    {
        $fabric= Fabric::find($id);
        $fabric->fabric_name = $request->fabric_name;
        $fabric->fabric_description = $request->fabric_description;
        $fabric->save();
        alert()->success('Successfully Updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fabric  $fabric
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fabric $fabric,$id)
    {
        $fabric = Fabric::find($id);
        $fabric->delete();
        alert()->success('Successfully Deleted');
        return redirect()->back();
    }
}
